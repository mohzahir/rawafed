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
    public $tries = 5;
    public $backoff = [30, 60, 120, 300];

    public function __construct($candidateId, $isFastTrack = false)
    {
        $this->candidateId = $candidateId;
        $this->isFastTrack = $isFastTrack;
    }

    public function handle(): void
    {
        $candidate = Candidate::find($this->candidateId);
        if (!$candidate || !$candidate->original_cv_path) {
            Log::warning('Candidate CV summary job has no candidate or original CV.', [
                'candidate_id' => $this->candidateId,
            ]);
            return;
        }

        Log::info('Candidate CV summary job started.', ['candidate_id' => $candidate->id]);

        $privateDisk = Storage::disk('local');
        $originalDisk = $privateDisk->exists($candidate->original_cv_path)
            ? $privateDisk
            : Storage::disk('public');

        if (!$originalDisk->exists($candidate->original_cv_path)) {
            throw new \RuntimeException('Original CV file was not found.');
        }

        try {
            $apiKey = config('services.gemini.api_key');
            if (!$apiKey) {
                throw new \RuntimeException('GEMINI_API_KEY is not configured.');
            }

            $pdfContents = $originalDisk->get($candidate->original_cv_path);
            $pdfText = trim($this->extractPdfText($pdfContents));
            $hasExtractableText = mb_strlen($pdfText) >= 80;

            $prompt = 'أنت خبير توظيف طبي. أنشئ ملخصاً مهنياً دقيقاً باللغة العربية من السيرة الذاتية. أخرج JSON صالحاً فقط بالمفاتيح: "summary" (ملخص منظم بعناوين قصيرة)، "skills" (مصفوفة مهارات)، "experience_years" (عدد صحيح أو null)، "inferred_title" (مسمى مهني أو null)، "inferred_specialty" (تخصص أو null). لا تخمّن أي معلومة غير موجودة. لا تُدرج اسم المرشح أو البريد أو الهاتف أو العنوان الدقيق أو تاريخ الميلاد أو أرقام الهوية أو الروابط أو أي بيانات اتصال أو تعريف شخصية. إذا كانت الصفحات صوراً ممسوحة ضوئياً، اقرأ النص الظاهر فيها. أدرج الخبرات والمؤهلات والتراخيص والمهارات واللغات فقط إن كانت موجودة.';

            $parts = [['text' => $prompt]];
            if ($hasExtractableText) {
                $pdfText = str_replace(
                    array_filter([$candidate->full_name, $candidate->email, $candidate->phone]),
                    '[بيانات محذوفة]',
                    $pdfText
                );
                $pdfText = preg_replace('/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}/iu', '[بريد محذوف]', $pdfText) ?? $pdfText;
                $pdfText = preg_replace('/(?:https?:\/\/|www\.)\S+/iu', '[رابط محذوف]', $pdfText) ?? $pdfText;
                $parts[] = ['text' => "Extracted CV text:\n" . mb_substr($pdfText, 0, 24000)];
            } else {
                $parts[] = ['inline_data' => [
                    'mime_type' => 'application/pdf',
                    'data' => base64_encode($pdfContents),
                ]];
            }

            $response = Http::acceptJson()
                ->timeout(120)
                ->post('https://generativelanguage.googleapis.com/v1beta/models/' . config('services.gemini.model') . ':generateContent?key=' . $apiKey, [
                    'contents' => [['parts' => $parts]],
                    'generationConfig' => [
                        'response_mime_type' => 'application/json',
                        'maxOutputTokens' => 2500,
                        'temperature' => 0.1,
                    ],
                ]);

            if (!$response->successful()) {
                $providerMessage = $response->json('error.message') ?? 'No provider error message returned.';
                Log::error('Gemini API request failed.', [
                    'candidate_id' => $candidate->id,
                    'status' => $response->status(),
                    'model' => config('services.gemini.model'),
                    'provider_message' => mb_substr((string) $providerMessage, 0, 1000),
                ]);

                if ($response->status() === 429) {
                    $retryAfter = (int) $response->header('Retry-After', 60);
                    $this->release(max(10, min($retryAfter, 900)));
                    return;
                }

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
            Log::info('Candidate CV summary generated.', [
                'candidate_id' => $candidate->id,
                'summary_path' => $summaryPath,
            ]);
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

    protected function extractPdfText(string $pdfContents): string
    {
        $parser = new \Smalot\PdfParser\Parser();

        return $parser->parseContent($pdfContents)->getText();
    }

}