<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Candidate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use App\Jobs\ProcessCandidateCV; // 🌟 استدعاء الـ Job الجديد

class CandidateRegistration extends Component
{
    use WithFileUploads;

    public $currentStep = 1; 
    public $isSubmitted = false;

    public $job_id = null;
    public $isFastTrack = false; 
    public $showUpsell = false; 
    public $created_candidate_id = null;

    // البيانات
    public $full_name, $email, $phone, $nationality, $current_location;
    public $professional_title, $general_specialty, $sub_specialty, $years_of_experience;
    public $target_countries = []; 
    public $current_licenses = []; 
    public $dataflow_status, $prometric_status, $notice_period;
    public $cv_file;

    public $gulfCountries = ['السعودية', 'الإمارات', 'قطر', 'عمان', 'الكويت', 'البحرين'];
    public $licenseTypes = ['SCFHS (السعودية)', 'DHA (دبي)', 'DOH/HAAD (أبوظبي)', 'MOHAP (الإمارات الشمالية)', 'QCHP (قطر)', 'OMSB (عمان)', 'MOH (الكويت)', 'NHRA (البحرين)'];

    public $nationalitiesList = ['سوداني', 'مصري', 'أردني', 'سوري', 'فلبيني', 'هندي', 'باكستاني', 'سعودي', 'إماراتي', 'كويتي', 'قطري', 'بحريني', 'عماني', 'فلسطيني', 'لبناني', 'عراقي', 'يمني', 'مغربي', 'تونسي', 'جزائري', 'ليبيا', 'موريتاني', 'صومالي', 'جيبوتي', 'بريطاني', 'أمريكي', 'كندي', 'أسترالي', 'أيرلندي', 'نيجيري', 'جنوب أفريقي', 'ماليزي', 'إندونيسي', 'بنغلاديشي', 'سريلانكي', 'أخرى'];

    public $medicalTitles = ['استشاري (Consultant)', 'طبيب نائب أول (Senior Registrar)', 'طبيب نائب / أخصائي (Registrar)', 'طبيب مقيم (Resident)', 'طبيب عام (General Practitioner)', 'أخصائي تمريض (بكالوريوس)', 'فني تمريض (دبلوم)', 'قابلة (Midwife)', 'أخصائي تقني / فني', 'صيدلي (Pharmacist)', 'أخرى'];

    public $medicalSpecialties = ['باطنة عامة', 'جراحة عامة', 'طب أطفال', 'نساء وتوليد', 'طب أسرة ومجتمع', 'طب طوارئ', 'عناية مركزة (ICU)', 'تخدير', 'جلدية وتجميل', 'طب وجراحة العيون', 'أنف وأذن وحنجرة (ENT)', 'جراحة عظام', 'مسالك بولية', 'أمراض صدرية', 'طب / جراحة قلب', 'أعصاب (طب/جراحة)', 'طب نفسي', 'علاج طبيعي وتأهيل', 'طب أسنان عام', 'جراحة وجه وفكين', 'تقويم أسنان', 'أسنان أطفال', 'تمريض عام', 'تمريض عناية مركزة', 'تمريض طوارئ', 'تمريض عمليات', 'تمريض نساء وولادة', 'تمريض أطفال وحضانات', 'تمريض غسيل كلوي', 'مختبرات طبية / علم أمراض', 'أشعة وتصوير طبى', 'صيدلة', 'تغذية علاجية', 'أخرى'];

    public function mount()
    {
        $this->job_id = request()->query('job_id');
        if ($this->job_id) {
            $this->isFastTrack = true;
        }
    }

    public function nextStep()
    {
        if ($this->currentStep == 1) {
            $this->validate(['full_name' => 'required|string|max:255', 'email' => 'required|email|unique:candidates,email', 'phone' => 'required|string|max:20', 'nationality' => 'required|string', 'current_location' => 'required|string']);
        } elseif ($this->currentStep == 2) {
            $this->validate(['professional_title' => 'required|string', 'general_specialty' => 'required|string', 'years_of_experience' => 'required|integer|min:0']);
        } elseif ($this->currentStep == 3) {
            $this->validate(['target_countries' => 'required|array|min:1', 'dataflow_status' => 'required|string', 'prometric_status' => 'required|string']);
        }
        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    // ==========================================
    // 🚀 1. دالة التقديم السريع (الآن سريعة كالبرق!)
    // ==========================================
    public function submitFastTrack()
    {
        $this->validate([
            'full_name' => 'required|string|max:255', 'email' => 'required|email|unique:candidates,email',
            'phone' => 'required|string|max:20', 'nationality' => 'required|string',
            'current_location' => 'required|string', 'cv_file' => 'required|file|mimes:pdf|max:10240',
        ]);

        $originalFileName = time() . '_' . Str::slug($this->full_name) . '.pdf';
        $cvPath = $this->cv_file->storeAs('cvs/original', $originalFileName, 'local');
        $generatedCode = 'RWD-' . strtoupper(Str::random(6));

        // 1. إنشاء السجل الأولي في قاعدة البيانات بسرعة (مخفي تماماً)
        $candidate = Candidate::create([
            'candidate_code' => $generatedCode,
            'job_id' => $this->job_id, 
            'full_name' => trim($this->full_name),
            'email' => trim($this->email),
            'phone' => trim($this->phone),
            'nationality' => trim($this->nationality),
            'current_location' => trim($this->current_location),
            'professional_title' => 'قيد المعالجة', // سيتم تحديثها لاحقاً
            'general_specialty' => 'قيد المعالجة',
            'sub_specialty' => 'غير محدد',
            'years_of_experience' => 0,
            'target_countries' => '[]',
            'current_licenses' => '[]',
            'extracted_skills' => [],
            'scfhs_status' => 'غير مصنف',
            'dataflow_status' => 'غير محدد',
            'prometric_status' => 'غير محدد',
            'notice_period' => 'غير محدد',
            'original_cv_path' => $cvPath,
            'blind_cv_path' => null,
            'summary_cv_path' => null,
            'needs_manual_review' => false,
            'is_active' => false, // مخفي!
        ]);

        $this->created_candidate_id = $candidate->id;

        // 🌟 2. إرسال المهام الثقيلة لتعمل في الخلفية (في الطابور)
        ProcessCandidateCV::dispatch($candidate->id, true);
        Log::info('Candidate CV summary job queued.', ['candidate_id' => $candidate->id]);

        // 3. إظهار شاشة النجاح فوراً للطبيب!
        $this->isSubmitted = true;
        $this->showUpsell = true; 
    }

    // ==========================================
    // 🌟 2. دالة الترقية (Upsell)
    // ==========================================
    public function upgradeToCatalog()
    {
        $this->validate([
            'target_countries' => 'required|array|min:1', 'dataflow_status' => 'required|string',
            'prometric_status' => 'required|string', 'notice_period' => 'required|string',
        ]);

        if ($this->created_candidate_id) {
            $candidate = Candidate::find($this->created_candidate_id);
            if ($candidate) {
                // تحديث البيانات، ولكن لاحظ أن is_active سيصبح true بمجرد أن ينتهي الـ Job من الطمس (مُعالج داخل الـ Job)
                $candidate->update([
                    'target_countries' => json_encode($this->target_countries, JSON_UNESCAPED_UNICODE),
                    'current_licenses' => json_encode($this->current_licenses, JSON_UNESCAPED_UNICODE),
                    'scfhs_status' => in_array('SCFHS (السعودية)', $this->current_licenses) ? 'مصنف وجاهز' : 'غير مصنف',
                    'dataflow_status' => $this->dataflow_status,
                    'prometric_status' => $this->prometric_status,
                    'notice_period' => $this->notice_period,
                    'is_active' => true, // تفعيل ظهوره في الكتالوج
                ]);
            }
        }
        $this->showUpsell = false; 
    }

    // ==========================================
    // 📝 3. التسجيل العادي (الآن فائق السرعة!)
    // ==========================================
    public function submitRegistration()
    {
        $this->validate([
            'notice_period' => 'required|string',
            'cv_file' => 'required|file|mimes:pdf|max:10240',
        ]);

        $originalFileName = time() . '_' . Str::slug($this->full_name) . '.pdf';
        $cvPath = $this->cv_file->storeAs('cvs/original', $originalFileName, 'local');
        $generatedCode = 'RWD-' . strtoupper(Str::random(6));

        // 1. إنشاء السجل الأولي
        $candidate = Candidate::create([
            'candidate_code' => $generatedCode,
            'job_id' => $this->job_id,
            'full_name' => trim($this->full_name),
            'email' => trim($this->email),
            'phone' => trim($this->phone),
            'nationality' => trim($this->nationality),
            'current_location' => trim($this->current_location),
            'professional_title' => trim($this->professional_title),
            'general_specialty' => trim($this->general_specialty),
            'sub_specialty' => trim($this->sub_specialty) ?: 'غير محدد',
            'years_of_experience' => $this->years_of_experience,
            'target_countries' => json_encode($this->target_countries, JSON_UNESCAPED_UNICODE),
            'current_licenses' => json_encode($this->current_licenses, JSON_UNESCAPED_UNICODE),
            'extracted_skills' => [], // سيتم استخراجها لاحقاً
            'scfhs_status' => in_array('SCFHS (السعودية)', $this->current_licenses) ? 'مصنف وجاهز' : 'غير مصنف',
            'dataflow_status' => $this->dataflow_status,
            'prometric_status' => $this->prometric_status,
            'notice_period' => $this->notice_period,
            'original_cv_path' => $cvPath,
            'blind_cv_path' => null,
            'summary_cv_path' => null,
            'needs_manual_review' => false,
            'is_active' => false, // ⚠️ مخفي حتى تنتهي المعالجة (تُدار من الـ Job)
        ]);

        // 🌟 2. إرسال المهمة للخلفية
        ProcessCandidateCV::dispatch($candidate->id, false);
        Log::info('Candidate CV summary job queued.', ['candidate_id' => $candidate->id]);

        // 3. إظهار شاشة النجاح فوراً
        $this->isSubmitted = true;
    }

    public function render()
    {
        return view('components.candidate-registration')->layout('components.layouts.app');
    }
}