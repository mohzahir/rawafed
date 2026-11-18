<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Candidate;
use Illuminate\Support\Facades\Storage;

class Dashboard extends Component
{
    use WithPagination;

    public $search = '';
    public $statusFilter = ''; // فلتر الحالة (مفعل / غير مفعل)

    // إعادة تعيين رقم الصفحة عند البحث
    public function updatingSearch()
    {
        $this->resetPage();
    }

    // دالة تفعيل/إلغاء تفعيل المرشح (ليظهر أو يختفي من الكتالوج)
    public function toggleStatus($id)
    {
        $candidate = Candidate::findOrFail($id);

        if (!$candidate->is_active && (!$candidate->summary_cv_path || !Storage::disk('local')->exists($candidate->summary_cv_path))) {
            session()->flash('statusMessage', 'لا يمكن تفعيل المرشح قبل إنشاء ملخص السيرة الذاتية.');
            return;
        }

        $candidate->update(['is_active' => !$candidate->is_active]);
        session()->flash('statusMessage', $candidate->is_active ? 'تم تفعيل المرشح.' : 'تم إخفاء المرشح من الكتالوج.');
    }

    // دالة حذف المرشح تماماً
    public function deleteCandidate($id)
    {
        $candidate = Candidate::find($id);
        if ($candidate) {
            // حذف الملفات المرتبطة به من السيرفر (اختياري، يفضل للحفاظ على المساحة)
            if ($candidate->original_cv_path) {
                Storage::disk('local')->delete($candidate->original_cv_path);
                Storage::disk('public')->delete($candidate->original_cv_path);
            }
            if ($candidate->blind_cv_path) Storage::disk('public')->delete($candidate->blind_cv_path);
            if ($candidate->summary_cv_path) Storage::disk('local')->delete($candidate->summary_cv_path);
            
            $candidate->delete();
        }
    }

    public function render()
    {
        $query = Candidate::query();

        // فلتر البحث النصي (يبحث في الاسم، الكود، التخصص، أو رقم الهاتف)
        if ($this->search) {
            $query->where(function($q) {
                $q->where('full_name', 'like', '%'.$this->search.'%')
                  ->orWhere('candidate_code', 'like', '%'.$this->search.'%')
                  ->orWhere('general_specialty', 'like', '%'.$this->search.'%')
                  ->orWhere('phone', 'like', '%'.$this->search.'%');
            });
        }

        // فلتر الحالة
        if ($this->statusFilter !== '') {
            $query->where('is_active', $this->statusFilter);
        }

        // جلب البيانات مع ترتيبها من الأحدث للأقدم، وتقسيمها لـ 15 مرشح في كل صفحة
        $candidates = $query->latest()->paginate(15);

        // حساب الإحصائيات السريعة للأدمن
        $stats = [
            'total' => Candidate::count(),
            'active' => Candidate::where('is_active', true)->count(),
            'pending' => Candidate::where('is_active', false)->count(),
        ];

        return view('components.admin.dashboard', compact('candidates', 'stats'))
               ->layout('components.layouts.admin');
    }
}