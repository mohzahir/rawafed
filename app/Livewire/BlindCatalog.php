<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Candidate;
use App\Models\HospitalRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Http;
use App\Mail\AdminAlertMail;
use App\Mail\HospitalConfirmationMail;

class BlindCatalog extends Component
{
    use WithPagination;

    // 1. التبويبات والفلاتر الأساسية
    public $selectedTab = 'doctors_dentists'; 
    
    // 2. الفلاتر الجانبية 
    public $selectedSpecialty = ''; 
    public $selectedTitle = ''; 
    public $selectedCountries = []; 
    public $dataflowStatus = '';
    public $prometricStatus = '';
    public $experience = '';
    public $noticePeriod = '';

    // 3. الفلاتر الجديدة والمحسنة
    public $searchQuery = ''; 
    public $selectedNationality = ''; 
    public $selectedLicenses = []; 

    // 🌟 4. متغيرات البحث الذكي
    public $aiSearchQuery = ''; 

    // 5. متغيرات اللوحة الجانبية وسلة المقابلات
    public $selectedCandidate = null;
    public $selectedCandidatesForInterview = []; 
    public $hospitalName = '';
    public $hrContactName = '';
    public $hrEmail = '';
    public $interviewNotes = '';

    public function getTabsMappingProperty()
    {
        return [
            'doctors_dentists' => [
                'label' => 'الأطباء وطب الأسنان',
                'icon' => '🩺',
                'titles' => ['استشاري (Consultant)', 'طبيب نائب أول (Senior Registrar)', 'طبيب نائب / أخصائي (Registrar)', 'طبيب مقيم (Resident)', 'طبيب عام (General Practitioner)'],
                'specialties' => ['باطنة عامة', 'جراحة عامة', 'طب أطفال', 'نساء وتوليد', 'طب أسرة ومجتمع', 'طب طوارئ', 'عناية مركزة (ICU)', 'تخدير', 'جلدية وتجميل', 'طب وجراحة العيون', 'أنف وأذن وحنجرة (ENT)', 'جراحة عظام', 'مسالك بولية', 'أمراض صدرية', 'طب / جراحة قلب', 'أعصاب (طب/جراحة)', 'طب نفسي', 'مختبرات طبية / علم أمراض', 'أشعة وتصوير طبى', 'طب أسنان عام', 'جراحة وجه وفكين', 'تقويم أسنان', 'أسنان أطفال']
            ],
            'nurses' => [
                'label' => 'التمريض والقبالة',
                'icon' => '💉',
                'titles' => ['أخصائي تمريض (بكالوريوس)', 'فني تمريض (دبلوم)', 'قابلة (Midwife)'],
                'specialties' => ['تمريض عام', 'تمريض عناية مركزة', 'تمريض طوارئ', 'تمريض عمليات', 'تمريض نساء وولادة', 'تمريض أطفال وحضانات', 'تمريض غسيل كلوي']
            ],
            'pharmacy_allied' => [
                'label' => 'الصيدلة والمهن المساعدة',
                'icon' => '🔬',
                'titles' => ['استشاري (Consultant)', 'طبيب نائب أول (Senior Registrar)', 'طبيب نائب / أخصائي (Registrar)', 'طبيب عام (General Practitioner)', 'صيدلي (Pharmacist)', 'أخصائي تقني / فني', 'أخرى'],
                'specialties' => ['صيدلة', 'مختبرات طبية / علم أمراض', 'أشعة وتصوير طبى', 'تغذية علاجية', 'علاج طبيعي وتأهيل', 'أخرى']
            ],
        ];
    }

    public function setTab($tabKey)
    {
        $this->selectedTab = $tabKey;
        $this->selectedSpecialty = ''; 
        $this->selectedTitle = ''; 
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['selectedSpecialty', 'selectedTitle', 'selectedCountries', 'dataflowStatus', 'prometricStatus', 'experience', 'noticePeriod', 'searchQuery', 'selectedNationality', 'selectedLicenses', 'aiSearchQuery']);
        $this->resetPage();
    }

    // ==========================================
    // 🪄 دالة البحث السحري المدعوم بالذكاء الاصطناعي
    // ==========================================
    public function performSmartSearch()
    {
        if (empty(trim($this->aiSearchQuery))) return;

        // 1. تجهيز القوائم المسموحة ليراها الذكاء الاصطناعي
        $allTitles = collect($this->tabsMapping)->flatMap(fn($tab) => $tab['titles'])->unique()->implode('", "');
        $allSpecialties = collect($this->tabsMapping)->flatMap(fn($tab) => $tab['specialties'])->unique()->implode('", "');

        $prompt = 'أنت مساعد بحث لموارد بشرية طبية. حلل هذه الجملة: "' . $this->aiSearchQuery . '".
        استخرج شروط البحث كـ JSON Object صالح برمجياً فقط بدون أي نصوص أخرى، يحتوي على المفاتيح التالية:
        1. "title": اختر بدقة من ["' . $allTitles . '"] أو اجعله null.
        2. "specialty": اختر بدقة من ["' . $allSpecialties . '"] أو اجعله null.
        3. "experience": إذا ذُكرت خبرة، اختر فئة قريبة من ["0-2", "3-5", "6-10", "11+"] أو اجعله null.
        4. "nationality": اسم الجنسية المستخرجة (مثل: سوري، مصري، سعودي) أو null.
        5. "country": اسم دولة العمل إذا ذُكرت (مثل: السعودية، الكويت) أو null.
        6. "keywords": أي مصطلحات طبية، تخصص دقيق، مهارات، أو مدن (مثل: خدج، الرياض، جراحة قلب) مفصولة بمسافات، أو اجعلها سلسلة فارغة "".';

        try {
            $modelId = 'gemini-3.1-flash-lite-preview'; 
            $response = Http::withoutVerifying()->timeout(30)->withHeaders(['Content-Type' => 'application/json'])
                ->post('https://generativelanguage.googleapis.com/v1beta/models/' . $modelId . ':generateContent?key=' . env('GEMINI_API_KEY'), [
                'contents' => [['parts' => [['text' => $prompt]]]],
                'generationConfig' => ['response_mime_type' => 'application/json']
            ]);

            if ($response->successful()) {
                $aiText = $response->json('candidates.0.content.parts.0.text');
                $cleanJson = str_replace(['```json', '```'], '', $aiText);
                $parsedData = json_decode(trim($cleanJson), true);

                if(is_array($parsedData)) {
                    // مسح الفلاتر القديمة قبل تطبيق الجديدة
                    $this->clearFilters();

                    // تطبيق اختيارات الذكاء الاصطناعي على فلاتر الواجهة
                    if (!empty($parsedData['title'])) $this->selectedTitle = $parsedData['title'];
                    if (!empty($parsedData['specialty'])) $this->selectedSpecialty = $parsedData['specialty'];
                    if (!empty($parsedData['experience'])) $this->experience = $parsedData['experience'];
                    if (!empty($parsedData['nationality'])) $this->selectedNationality = $parsedData['nationality'];
                    if (!empty($parsedData['country'])) $this->selectedCountries = [$parsedData['country']];
                    if (!empty($parsedData['keywords'])) $this->searchQuery = trim($parsedData['keywords']);
                    
                    // استعادة جملة البحث لتظل ظاهرة للمستخدم
                    $this->aiSearchQuery = trim($this->aiSearchQuery);
                    
                    // إشعار نجاح لطيف
                    $this->dispatch('alert-success', message: 'تم تطبيق فلاتر الذكاء الاصطناعي بنجاح!');
                }
            }
        } catch (\Exception $e) {
            $this->dispatch('alert-error', message: 'عذراً، حدث خطأ في معالجة البحث الذكي.');
        }
    }

    public function showCandidateDetails($id)
    {
        $this->selectedCandidate = Candidate::query()
            ->where('is_active', true)
            ->whereNotNull('summary_cv_path')
            ->findOrFail($id);
        $this->dispatch('open-slide-panel');
    }

    public function clearSelections()
    {
        $this->reset('selectedCandidatesForInterview');
    }

    public function submitInterviewRequest()
    {
        $this->validate([
            'hospitalName' => 'required|string|max:255',
            'hrEmail' => 'required|email|max:255',
            'hrContactName' => 'nullable|string|max:255',
            'interviewNotes' => 'nullable|string',
        ]);

        $requestedCodes = []; 
        foreach ($this->selectedCandidatesForInterview as $candidateId) {
            HospitalRequest::create([
                'candidate_id' => $candidateId,
                'hospital_name' => $this->hospitalName,
                'hr_contact_name' => $this->hrContactName ?? 'مسؤول توظيف',
                'hr_email' => $this->hrEmail,
                'status' => 'pending',
                'notes' => $this->interviewNotes,
            ]);

            $candidate = Candidate::find($candidateId);
            if ($candidate) {
                $requestedCodes[] = $candidate->candidate_code;
            }
        }

        try {
            $hrName = $this->hrContactName ?? 'مسؤول توظيف';
            $adminEmail = env('ADMIN_EMAIL', 'admin@yourdomain.com'); 

            Mail::to($adminEmail)->send(new AdminAlertMail($hrName, $this->hospitalName, $this->hrEmail, $requestedCodes));
            Mail::to($this->hrEmail)->send(new HospitalConfirmationMail($hrName, $this->hospitalName, $requestedCodes));

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('فشل إرسال إيميل طلب الكوادر: ' . $e->getMessage());
        }

        $this->reset(['hospitalName', 'hrContactName', 'hrEmail', 'interviewNotes', 'selectedCandidatesForInterview']);
        $this->dispatch('close-interview-modal');
        $this->dispatch('alert-success', message: 'تم استلام طلبكم بنجاح! أرسلنا لكم رسالة تأكيد على البريد الإلكتروني.');
    }

    public function render()
    {
        $query = Candidate::query()
            ->where('is_active', true)
            ->whereNotNull('summary_cv_path');
        $currentMapping = $this->tabsMapping[$this->selectedTab];

        $query->whereIn('professional_title', $currentMapping['titles'])
              ->whereIn('general_specialty', $currentMapping['specialties']);

        // نظام البحث المعمق الذي يعمل بتناغم مع كلمات الذكاء الاصطناعي المتبقية (المدن، التخصص الدقيق، الأجهزة)
        // if (!empty($this->searchQuery)) {
        //     $searchTerms = array_filter(explode(' ', trim($this->searchQuery)));
        //     $query->where(function ($q) use ($searchTerms) {
        //         foreach ($searchTerms as $term) {
        //             $termClean = preg_replace('/[أإآا]/u', '_', $term); 
        //             $q->where(function ($subQ) use ($termClean, $term) {
        //                 $subQ->where('candidate_code', 'like', '%' . $term . '%')
        //                      ->orWhere('general_specialty', 'like', '%' . $termClean . '%')
        //                      ->orWhere('sub_specialty', 'like', '%' . $termClean . '%')
        //                      ->orWhere('professional_title', 'like', '%' . $termClean . '%')
        //                      ->orWhere('current_location', 'like', '%' . $termClean . '%') // للبحث بالمدينة (الرياض)
        //                      ->orWhere('extracted_skills', 'like', '%' . $termClean . '%')
        //                      ->orWhere('extracted_skills', 'like', '%' . $term . '%');
        //             });
        //         }
        //     });
        // }

        // ==========================================
        // 🔍 محرك الدقة الفائقة (يعمل في الخفاء بفضل الذكاء الاصطناعي)
        // ==========================================
        if (!empty($this->searchQuery)) {
            // تفكيك الكلمات (مثال: "خدج", "قلب", "الرياض")
            $searchTerms = array_filter(explode(' ', trim($this->searchQuery)));
            
            $query->where(function ($q) use ($searchTerms) {
                foreach ($searchTerms as $term) {
                    $termClean = preg_replace('/[أإآا]/u', '_', $term); 
                    $termCleanTaa = preg_replace('/[ةه]/u', '_', $termClean); // معالجة التاء المربوطة
                    
                    // يجب أن يجد كل كلمة في أحد هذه الأماكن العميقة
                    $q->where(function ($subQ) use ($termClean, $termCleanTaa, $term) {
                        $subQ->where('candidate_code', 'like', '%' . $term . '%')
                             ->orWhere('sub_specialty', 'like', '%' . $termCleanTaa . '%')
                             ->orWhere('current_location', 'like', '%' . $termCleanTaa . '%') // للبحث بالمدينة (مثل: الرياض)
                             // البحث داخل مصفوفة المهارات (JSON)
                             ->orWhere('extracted_skills', 'like', '%' . $termCleanTaa . '%')
                             ->orWhere('extracted_skills', 'like', '%' . $term . '%');
                    });
                }
            });
        }

        if (!empty($this->selectedTitle)) $query->where('professional_title', $this->selectedTitle);
        if (!empty($this->selectedSpecialty)) $query->where('general_specialty', $this->selectedSpecialty);
        if (!empty($this->selectedNationality)) $query->where('nationality', $this->selectedNationality);
        if (!empty($this->dataflowStatus)) $query->where('dataflow_status', $this->dataflowStatus);
        if (!empty($this->noticePeriod)) $query->where('notice_period', $this->noticePeriod);
        
        if (!empty($this->prometricStatus)) {
            if (str_contains($this->prometricStatus, 'مجتاز')) {
                $query->where('prometric_status', 'like', '%مجتاز%');
            } else {
                $query->where('prometric_status', $this->prometricStatus);
            }
        }

        if (!empty($this->experience)) {
            switch ($this->experience) {
                case '0-2': $query->whereBetween('years_of_experience', [0, 2]); break;
                case '3-5': $query->whereBetween('years_of_experience', [3, 5]); break;
                case '6-10': $query->whereBetween('years_of_experience', [6, 10]); break;
                case '11+': $query->where('years_of_experience', '>=', 11); break;
            }
        }

        if (!empty($this->selectedCountries)) {
            $query->where(function ($q) {
                foreach ($this->selectedCountries as $country) {
                    $q->orWhereJsonContains('target_countries', $country);
                }
            });
        }
        
        if (!empty($this->selectedLicenses)) {
            $query->where(function ($q) {
                foreach ($this->selectedLicenses as $license) {
                    $q->orWhereJsonContains('current_licenses', $license);
                }
            });
        }

        $availableNationalities = Candidate::where('is_active', true)
                                ->select('nationality')
                                ->distinct()->orderBy('nationality')->pluck('nationality')->filter(); 

        return view('components.blind-catalog1', [
            'candidates' => $query->latest()->paginate(12),
            'tabs' => $this->tabsMapping,
            'availableNationalities' => $availableNationalities 
        ])->layout('components.layouts.app');
    }
}