<?php

namespace Tests\Feature;

use App\Jobs\ProcessCandidateCV;
use App\Models\Candidate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
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

    private function createCandidate(): Candidate
    {
        return Candidate::create([
            'candidate_code' => 'RWD-TEST01',
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