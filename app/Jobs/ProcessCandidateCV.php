<?php

namespace App\Jobs;

use App\Mail\DoctorWelcomeMail;
use App\Models\Candidate;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class ProcessCandidateCV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $candidateId;
    public $isFastTrack;

    public $timeout = 180;

    public function __construct($candidateId, $isFastTrack = false)
    {
        $this->candidateId = $candidateId;
        $this->isFastTrack = $isFastTrack;
    }

    public function handle(): void
    {
        $candidate = Candidate::find($this->candidateId);
        if (!$candidate || !$candidate->original_cv_path) {
            return;
        }

        $privateDisk = Storage::disk('local');
        $originalDisk = $privateDisk->exists($candidate->original_cv_path)
            ? $privateDisk
            : Storage::disk('public');

        if (!$originalDisk->exists($candidate->original_cv_path)) {
            throw new \RuntimeException('Original CV file was not found.');
        }

        try {
            $prompt = 'أنت خبير توظيف طبي. اكتب ملخصاً مهنياً دقيقاً باللغة العربية لهذا الملف، في JSON صالح فقط بالمفاتيح: "summary" (نص منظم بعناوين قصيرة)، "skills" (مصفوفة مهارات)، "experience_years" (عدد صحيح أو null)، "inferred_title" (مسمى مهني أو null)، "inferred_specialty" (تخصص أو null). لا تخمّن أي معلومة غير موجودة. احذف تماماً اسم المرشح والبريد والهاتف والعنوان الدقيق وتاريخ الميلاد وأرقام الهوية والروابط وأي بيانات اتصال أو تعريف شخصية. اذكر الخبرات والمؤهلات والتراخيص والمهارات واللغات فقط إن كانت موجودة.';
            $response = Http::timeout(120)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post('https://generativelanguage.googleapis.com/v1beta/models/gemini-3.1-flash-lite-preview:generateContent?key=' . env('GEMINI_API_KEY'), [
                    'contents' => [[
                        'parts' => [
                            ['text' => $prompt],
                            ['inline_data' => [
                                'mime_type' => 'application/pdf',
                                'data' => base64_encode($originalDisk->get($candidate->original_cv_path)),
                            ]],
                        ],
                    ]],
                    'generationConfig' => ['response_mime_type' => 'application/json'],
                ]);

            if (!$response->successful()) {
                throw new \RuntimeException('Gemini API request failed with status ' . $response->status());
            }

            $aiText = $response->json('candidates.0.content.parts.0.text');
            $parsedData = json_decode(trim(str_replace(['```json', '```'], '', (string) $aiText)), true);
            $summary = trim((string) ($parsedData['summary'] ?? ''));
            if (!is_array($parsedData) || $summary === '') {
                throw new \RuntimeException('Gemini did not return a usable CV summary.');
            }

            $summary = str_replace(
                array_filter([$candidate->full_name, $candidate->email, $candidate->phone]),
                '[بيانات محذوفة]',
                $summary
            );
            $summaryPath = 'cvs/summaries/' . $candidate->id . '.html';
            $escapedSummary = nl2br(e($summary));
            $summaryDocument = '<!doctype html><html lang="ar" dir="rtl"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><title>ملخص مهني</title><style>body{font-family:Tahoma,Arial,sans-serif;max-width:800px;margin:40px auto;padding:32px;color:#1f2937;line-height:1.9}h1{font-size:24px;color:#0a3d62;border-bottom:2px solid #bda065;padding-bottom:12px}</style></head><body><h1>ملخص مهني مجهول الهوية</h1><main>' . $escapedSummary . '</main></body></html>';

            if (!$privateDisk->put($summaryPath, $summaryDocument)) {
                throw new \RuntimeException('Could not save the generated CV summary.');
            }

            $updateData = [
                'extracted_skills' => is_array($parsedData['skills'] ?? null) ? $parsedData['skills'] : [],
                'blind_cv_path' => null,
                'summary_cv_path' => $summaryPath,
                'needs_manual_review' => false,
            ];

            if ($this->isFastTrack) {
                if (in_array($candidate->professional_title, [null, '', 'غير محدد', 'قيد المعالجة'], true) && !empty($parsedData['inferred_title'])) {
                    $updateData['professional_title'] = trim($parsedData['inferred_title']);
                }
                if (in_array($candidate->general_specialty, [null, '', 'غير محدد', 'قيد المعالجة'], true) && !empty($parsedData['inferred_specialty'])) {
                    $updateData['general_specialty'] = trim($parsedData['inferred_specialty']);
                }
                if (!$candidate->years_of_experience && is_numeric($parsedData['experience_years'] ?? null)) {
                    $updateData['years_of_experience'] = (int) $parsedData['experience_years'];
                }
            } else {
                $updateData['is_active'] = true;
            }

            $candidate->update($updateData);
        } catch (\Throwable $e) {
            Log::error('Candidate CV summary generation failed.', [
                'candidate_id' => $candidate->id,
                'exception' => $e->getMessage(),
            ]);
            throw $e;
        }

        try {
            Mail::to($candidate->email)->send(new DoctorWelcomeMail($candidate->full_name, $candidate->candidate_code));
        } catch (\Throwable $e) {
            Log::error('Background Email Failed: ' . $e->getMessage());
        }
    }
}