<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Candidate;
use App\Models\HospitalRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\HospitalConfirmationMail;
use App\Mail\AdminAlertMail;

class BlindCatalog extends Component
{
    // فلاتر البحث
    public $search = '';
    public $titleFilter = '';
    public $specialtyFilter = '';
    public $nationalityFilter = '';
    public $experienceFilter = '';
    public $prometricFilter = '';
    public $scfhsFilter = '';
    public $dataflowFilter = '';
    public $noticePeriodFilter = '';

    // سلة التوظيف (Shortlist)
    public $shortlist = [];

    // متغيرات نافذة عرض التفاصيل (Candidate Details Modal)
    public $showDetailsModal = false;
    public $viewingCandidate = null; // سيخزن كامل كائن المرشح المعروض حالياً

    // متغيرات نافذة الطلب المجمع (Checkout Modal)
    public $showCheckoutModal = false;
    public $hospital_name, $hr_contact_name, $hr_email;
    public $requestSuccess = false;

    // --- دوال سلة التوظيف ---
    public function toggleShortlist($candidateId)
    {
        if (in_array($candidateId, $this->shortlist)) {
            $this->shortlist = array_diff($this->shortlist, [$candidateId]);
        } else {
            $this->shortlist[] = $candidateId;
        }
    }

    // دالة تفريغ السلة بالكامل
    public function clearShortlist()
    {
        $this->shortlist = []; // تصفير المصفوفة
    }

    // --- دوال نافذة عرض التفاصيل (الجديدة) ---
    public function openDetailsModal($candidateId)
    {
        // جلب بيانات المرشح كاملة من الداتا بيز لعرضها
        $this->viewingCandidate = Candidate::find($candidateId);
        $this->showDetailsModal = true;
    }

    public function closeDetailsModal()
    {
        $this->showDetailsModal = false;
        $this->viewingCandidate = null;
    }

    // --- دوال نافذة الطلب المجمع (Checkout) ---
    public function openCheckoutModal()
    {
        if (count($this->shortlist) > 0) {
            $this->showCheckoutModal = true;
            $this->requestSuccess = false;
        }
    }

    public function closeCheckoutModal()
    {
        $this->showCheckoutModal = false;
        $this->reset(['hospital_name', 'hr_contact_name', 'hr_email']);
    }

    public function submitBulkRequest()
    {
        $this->validate([
            'hospital_name' => 'required|string|max:255',
            'hr_contact_name' => 'required|string|max:255',
            'hr_email' => 'required|email',
        ]);

        foreach ($this->shortlist as $candidateId) {
            HospitalRequest::create([
                'candidate_id' => $candidateId,
                'hospital_name' => $this->hospital_name,
                'hr_contact_name' => $this->hr_contact_name,
                'hr_email' => $this->hr_email,
                'status' => 'pending',
            ]);
        }

        // جلب الأكواد التي تم طلبها
        $requestedCodes = Candidate::whereIn('id', $this->shortlist)->pluck('candidate_code')->toArray();

        // 1. إرسال إيميل تأكيد لمدير التوظيف في المستشفى
        Mail::to($this->hr_email)->send(new HospitalConfirmationMail($this->hr_contact_name, $this->hospital_name, $requestedCodes));

        // 2. إرسال إشعار إداري داخلي لك لتنبيهك بالطلب
        Mail::to('moh.zahir.mz@gmail.com')->send(new AdminAlertMail($this->hr_contact_name, $this->hospital_name, $this->hr_email, $requestedCodes));

        $this->requestSuccess = true;
        $this->shortlist = [];
        $this->reset(['hospital_name', 'hr_contact_name', 'hr_email']);
    }

    public function resetFilters()
    {
        $this->reset(['search', 'titleFilter', 'specialtyFilter', 'nationalityFilter', 'experienceFilter', 'prometricFilter', 'scfhsFilter', 'dataflowFilter', 'noticePeriodFilter']);
    }

    public function render()
    {
        // 1. الشرط السحري: جلب المرشحين "المفعلين" فقط
        $query = Candidate::where('is_active', true);

        // تطبيق الفلاتر
        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('candidate_code', 'like', '%' . $this->search . '%')
                  ->orWhere('general_specialty', 'like', '%' . $this->search . '%')
                  ->orWhere('sub_specialty', 'like', '%' . $this->search . '%');
            });
        }
        if ($this->titleFilter) $query->where('professional_title', $this->titleFilter);
        if ($this->specialtyFilter) $query->where('general_specialty', $this->specialtyFilter);
        if ($this->nationalityFilter) $query->where('nationality', $this->nationalityFilter);
        if ($this->prometricFilter) $query->where('prometric_status', $this->prometricFilter);
        if ($this->scfhsFilter) $query->where('scfhs_status', $this->scfhsFilter);
        if ($this->dataflowFilter) $query->where('dataflow_status', $this->dataflowFilter);
        if ($this->noticePeriodFilter) $query->where('notice_period', $this->noticePeriodFilter);

        if ($this->experienceFilter) {
            if ($this->experienceFilter == '1-3') $query->whereBetween('years_of_experience', [1, 3]);
            elseif ($this->experienceFilter == '4-7') $query->whereBetween('years_of_experience', [4, 7]);
            elseif ($this->experienceFilter == '8+') $query->where('years_of_experience', '>=', 8);
        }

        $candidates = $query->latest()->get();

        // 2. تحديث القوائم المنسدلة لتقرأ من "المفعلين" فقط
        $dbTitles = Candidate::where('is_active', true)->select('professional_title')->distinct()->pluck('professional_title')->filter();
        $dbSpecialties = Candidate::where('is_active', true)->select('general_specialty')->distinct()->pluck('general_specialty')->filter();
        $dbNationalities = Candidate::where('is_active', true)->select('nationality')->distinct()->pluck('nationality')->filter();

        $selectedCandidatesCodes = Candidate::whereIn('id', $this->shortlist)->pluck('candidate_code')->toArray();

        return view('components.blind-catalog', compact('candidates', 'dbTitles', 'dbSpecialties', 'dbNationalities', 'selectedCandidatesCodes'))
               ->layout('components.layouts.app');
    }
}