<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Candidate;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Mail\DoctorWelcomeMail;

class ProcessCandidateCV implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $candidateId;
    public $isFastTrack;

    // تحديد وقت أقصى لتنفيذ المهمة (3 دقائق) لتجنب الـ Timeout
    public $timeout = 180;

    public function __construct($candidateId, $isFastTrack = false)
    {
        $this->candidateId = $candidateId;
        $this->isFastTrack = $isFastTrack;
    }

    public function handle()
    {
        $candidate = Candidate::find($this->candidateId);
        if (!$candidate || !$candidate->original_cv_path) return;

        $absoluteOriginalPath = storage_path('app/public/' . $candidate->original_cv_path);
        $blindFileName = 'blind_' . basename($candidate->original_cv_path);
        $blindRelativePath = 'cvs/blind/' . $blindFileName;
        $absoluteBlindPath = storage_path('app/public/' . $blindRelativePath);
        $pythonScriptPath = base_path('scripts/cv_redactor.py');

        // 🌟 1. الحل الأول: التأكد من إنشاء المجلد قبل أن يحاول البايثون حفظ الملف فيه
        if (!file_exists(dirname($absoluteBlindPath))) {
            mkdir(dirname($absoluteBlindPath), 0755, true);
        }

        $extractedSkills = []; 
        $aiPersonalData = []; 
        $aiExperience = $candidate->years_of_experience ?? 0;
        $aiTitle = $candidate->professional_title ?? 'غير محدد';
        $aiSpecialty = $candidate->general_specialty ?? 'غير محدد';

        // 🤖 تشغيل الذكاء الاصطناعي
        try {
            $pdfContent = base64_encode(file_get_contents($absoluteOriginalPath));

            $allowedTitlesList = implode('", "', ['استشاري (Consultant)', 'طبيب نائب أول (Senior Registrar)', 'طبيب نائب / أخصائي (Registrar)', 'طبيب مقيم (Resident)', 'طبيب عام (General Practitioner)', 'أخصائي تمريض (بكالوريوس)', 'فني تمريض (دبلوم)', 'قابلة (Midwife)', 'أخصائي تقني / فني', 'صيدلي (Pharmacist)', 'أخرى']);
            $allowedSpecialtiesList = implode('", "', ['باطنة عامة', 'جراحة عامة', 'طب أطفال', 'نساء وتوليد', 'طب أسرة ومجتمع', 'طب طوارئ', 'عناية مركزة (ICU)', 'تخدير', 'جلدية وتجميل', 'طب وجراحة العيون', 'أنف وأذن وحنجرة (ENT)', 'جراحة عظام', 'مسالك بولية', 'أمراض صدرية', 'طب / جراحة قلب', 'أعصاب (طب/جراحة)', 'طب نفسي', 'علاج طبيعي وتأهيل', 'طب أسنان عام', 'جراحة وجه وفكين', 'تقويم أسنان', 'أسنان أطفال', 'تمريض عام', 'تمريض عناية مركزة', 'تمريض طوارئ', 'تمريض عمليات', 'تمريض نساء وولادة', 'تمريض أطفال وحضانات', 'تمريض غسيل كلوي', 'مختبرات طبية / علم أمراض', 'أشعة وتصوير طبى', 'صيدلة', 'تغذية علاجية', 'أخرى']);

            if($this->isFastTrack) {
                $prompt = 'أنت خبير موارد بشرية. حلل هذا الـ CV. استخرج البيانات في JSON Object صارم يحتوي على:
                1. "skills": مصفوفة نصوص للمهارات والأجهزة.
                2. "personal_data": مصفوفة نصوص للأسماء والأرقام.
                3. "experience_years": رقم صحيح لإجمالي سنوات الخبرة.
                4. "inferred_title": اختر بدقة من: ["' . $allowedTitlesList . '"].
                5. "inferred_specialty": اختر بدقة من: ["' . $allowedSpecialtiesList . '"].';
            } else {
                $prompt = 'أنت خبير موارد بشرية. حلل هذا الـ CV. استخرج البيانات التالية في صيغة JSON Object صارم يحتوي على مفتاحين فقط:
                1. "skills": مصفوفة نصوص للمهارات السريرية، الأجهزة، والشهادات.
                2. "personal_data": مصفوفة نصوص لاسم المرشح، الأرقام، والإيميلات.';
            }

            $modelId = 'gemini-3.1-flash-lite-preview'; 

            $response = Http::withoutVerifying()
                ->timeout(60)
                ->withHeaders(['Content-Type' => 'application/json'])
                ->post('https://generativelanguage.googleapis.com/v1beta/models/' . $modelId . ':generateContent?key=' . env('GEMINI_API_KEY'), [
                'contents' => [['parts' => [['text' => $prompt], ['inline_data' => ['mime_type' => 'application/pdf', 'data' => $pdfContent]]]]],
                'generationConfig' => ['response_mime_type' => 'application/json']
            ]);

            if ($response->successful()) {
                $aiText = $response->json('candidates.0.content.parts.0.text');
                if (!empty($aiText)) {
                    $cleanJson = str_replace(['```json', '```'], '', $aiText);
                    $parsedData = json_decode(trim($cleanJson), true);

                    if (isset($parsedData['skills'])) $extractedSkills = $parsedData['skills'];
                    if (isset($parsedData['personal_data'])) $aiPersonalData = $parsedData['personal_data'];
                    
                    if($this->isFastTrack) {
                        if (isset($parsedData['experience_years'])) $aiExperience = (int) $parsedData['experience_years'];
                        if (isset($parsedData['inferred_title']) && str_contains($allowedTitlesList, trim($parsedData['inferred_title']))) {
                            $aiTitle = trim($parsedData['inferred_title']);
                        }
                        if (isset($parsedData['inferred_specialty']) && str_contains($allowedSpecialtiesList, trim($parsedData['inferred_specialty']))) {
                            $aiSpecialty = trim($parsedData['inferred_specialty']);
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Background Job Gemini Exception: ' . $e->getMessage());
        }

        // 🛡️ تشغيل بايثون لطمس الهوية
        $aiTargetsBase64 = !empty($aiPersonalData) ? base64_encode(json_encode(array_filter($aiPersonalData), JSON_UNESCAPED_UNICODE)) : "NONE";
        
        // 🌟 استدعاء المسار من .env مع تحويله لمسار كامل (Absolute Path) إذا كان داخل مجلد المشروع
        $envPath = env('PYTHON_EXEC_PATH', 'venv/Scripts/python.exe');
        $pythonExec = str_contains($envPath, 'venv') 
            ? base_path(str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $envPath)) 
            : $envPath;

        $result = Process::run([
            $pythonExec, 
            $pythonScriptPath, $absoluteOriginalPath, $absoluteBlindPath,
            $candidate->full_name, $candidate->email, $candidate->phone, $aiTargetsBase64
        ]);

        $output = $result->output();
        $finalBlindPath = str_contains($output, 'SUCCESS') ? $blindRelativePath : null;
        $needsManualReview = str_contains($output, 'SCANNED_IMAGE') ? true : false; 

        // 🌟 مراقبة الأخطاء في الخلفية لضمان عدم الفشل الصامت
        if (!str_contains($output, 'SUCCESS') && !str_contains($output, 'SCANNED_IMAGE')) {
            \Illuminate\Support\Facades\Log::error('Python Script Failed in Background: ' . $result->errorOutput() . ' Output: ' . $output);
        }

        // 💾 3. تحديث بيانات الطبيب في الداتابيز بعد انتهاء المعالجة
        $updateData = [
            'extracted_skills' => $extractedSkills,
            'blind_cv_path' => $finalBlindPath,
            'needs_manual_review' => $needsManualReview,
        ];

        // 🌟 2. الحل الثاني: تحديث الشرط ليشمل عبارة "قيد المعالجة"
        if($this->isFastTrack) {
            if(!$candidate->professional_title || in_array($candidate->professional_title, ['غير محدد', 'قيد المعالجة'])) {
                $updateData['professional_title'] = $aiTitle;
            }
            if(!$candidate->general_specialty || in_array($candidate->general_specialty, ['غير محدد', 'قيد المعالجة'])) {
                $updateData['general_specialty'] = $aiSpecialty;
            }
            if(!$candidate->years_of_experience) {
                $updateData['years_of_experience'] = $aiExperience;
            }
        }

        if(!$this->isFastTrack && !$needsManualReview) {
            $updateData['is_active'] = true;
        } elseif ($this->isFastTrack) {
            // نتركه is_active = false كما هو
        } else {
            $updateData['is_active'] = false; 
        }

        $candidate->update($updateData);

        // 📧 إرسال الإيميل
        try { 
            Mail::to($candidate->email)->send(new DoctorWelcomeMail($candidate->full_name, $candidate->candidate_code)); 
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Background Email Failed: ' . $e->getMessage());
        }
    }
}