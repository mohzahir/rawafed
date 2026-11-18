<?php

namespace Tests\Feature;

use App\Jobs\ProcessCandidateCV;
use App\Livewire\Admin\Dashboard;
use App\Models\Candidate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Illuminate\Support\Str;
use Tests\TestCase;

class CandidateSummaryTest extends TestCase
{
    use RefreshDatabase;

    public function test_cv_job_saves_a_private_anonymized_summary_without_python(): void
    {
        Storage::fake('local');
        Storage::fake('public');
        Mail::fake();

        $candidate = $this->createCandidate();
        Storage::disk('local')->put($candidate->original_cv_path, 'fake pdf bytes');

        Http::fake([
            'generativelanguage.googleapis.com/*' => Http::response([
                'candidates' => [[
                    'content' => ['parts' => [[
                        'text' => json_encode([
                            'summary' => 'خبرة في العناية المركزة. د. أحمد ahmed@example.com 12345678',
                            'skills' => ['العناية المركزة'],
                            'experience_years' => 8,
                            'inferred_title' => 'طبيب استشاري',
                            'inferred_specialty' => 'عناية مركزة',
                        ], JSON_UNESCAPED_UNICODE),
                    ]]],
                ]],
            ]),
        ]);

        (new ProcessCandidateCV($candidate->id))->handle();

        $candidate->refresh();
        $this->assertSame('cvs/summaries/' . $candidate->id . '.html', $candidate->summary_cv_path);
        $this->assertTrue($candidate->is_active);
        Storage::disk('local')->assertExists($candidate->original_cv_path);
        Storage::disk('local')->assertExists($candidate->summary_cv_path);
        Storage::disk('public')->assertMissing($candidate->original_cv_path);

        $summary = Storage::disk('local')->get($candidate->summary_cv_path);
        $this->assertStringContainsString('خبرة في العناية المركزة', $summary);
        $this->assertStringNotContainsString('ahmed@example.com', $summary);
        $this->assertStringNotContainsString('د. أحمد', $summary);

        $this->get(route('candidates.summary', $candidate))
            ->assertOk()
            ->assertSee('خبرة في العناية المركزة')
            ->assertDontSee('fake pdf bytes');
    }

    public function test_unprocessed_or_inactive_candidates_do_not_expose_a_summary(): void
    {
        Storage::fake('local');
        $candidate = $this->createCandidate();

        $this->get(route('candidates.summary', $candidate))->assertNotFound();
    }

    public function test_original_cv_is_only_available_to_an_authenticated_admin(): void
    {
        Storage::fake('local');
        $candidate = $this->createCandidate();
        Storage::disk('local')->put($candidate->original_cv_path, '%PDF-private-cv');

        $this->get(route('admin.candidates.original-cv', $candidate))->assertRedirect(route('login'));

        $this->actingAs(User::factory()->create())
            ->get(route('admin.candidates.original-cv', $candidate))
            ->assertOk()
            ->assertHeader('Content-Type', 'application/pdf')
            ->assertSee('%PDF-private-cv', false);
    }

    public function test_dashboard_toggle_requires_a_summary_to_activate_and_can_toggle_ready_candidates(): void
    {
        Storage::fake('local');
        $candidate = $this->createCandidate();

        Livewire::test(Dashboard::class)
            ->call('toggleStatus', $candidate->id)
            ->assertSee('لا يمكن تفعيل المرشح قبل إنشاء ملخص السيرة الذاتية.');

        $this->assertDatabaseHas('candidates', ['id' => $candidate->id, 'is_active' => false]);

        $summaryPath = 'cvs/summaries/' . $candidate->id . '.html';
        Storage::disk('local')->put($summaryPath, 'summary');
        $candidate->update(['summary_cv_path' => $summaryPath]);

        Livewire::test(Dashboard::class)
            ->call('toggleStatus', $candidate->id);
        $this->assertDatabaseHas('candidates', ['id' => $candidate->id, 'is_active' => true]);

        Livewire::test(Dashboard::class)
            ->call('toggleStatus', $candidate->id);
        $this->assertDatabaseHas('candidates', ['id' => $candidate->id, 'is_active' => false]);
    }

    private function createCandidate(): Candidate
    {
        return Candidate::create([
            'candidate_code' => 'RWD-TEST' . strtoupper(Str::random(6)),
            'full_name' => 'د. أحمد',
            'email' => 'ahmed@example.com',
            'phone' => '12345678',
            'nationality' => 'سوداني',
            'current_location' => 'الخرطوم',
            'professional_title' => 'طبيب عام',
            'general_specialty' => 'باطنة عامة',
            'years_of_experience' => 8,
            'dataflow_status' => 'غير محدد',
            'prometric_status' => 'غير محدد',
            'scfhs_status' => 'غير مصنف',
            'notice_period' => 'غير محدد',
            'original_cv_path' => 'cvs/original/original.pdf',
            'target_countries' => [],
            'current_licenses' => [],
            'extracted_skills' => [],
            'is_active' => false,
        ]);
    }
}