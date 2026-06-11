<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Job;
use Illuminate\Support\Str;

class JobManager extends Component
{
    // المتغيرات لنموذج الإضافة
    public $title, $specialty, $country, $salary_range, $description;
    public $isModalOpen = false;

    // القواعد للتحقق من صحة البيانات
    protected $rules = [
        'title' => 'required|string|max:255',
        'specialty' => 'required|string|max:255',
        'country' => 'required|string|max:255',
        'salary_range' => 'nullable|string|max:255',
        'description' => 'required|string',
    ];

    // فتح وإغلاق المودال
    public function openModal()
    {
        $this->resetFields();
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function resetFields()
    {
        $this->title = '';
        $this->specialty = '';
        $this->country = '';
        $this->salary_range = '';
        $this->description = '';
    }

    // حفظ الوظيفة الجديدة
    public function saveJob()
    {
        $this->validate();

        // توليد رابط ذكي وفريد (مثال: consultant-anesthesia-5f8a)
        $slug = Str::slug($this->title) . '-' . substr(uniqid(), -4);

        Job::create([
            'title' => $this->title,
            'slug' => $slug,
            'specialty' => $this->specialty,
            'country' => $this->country,
            'salary_range' => $this->salary_range,
            'description' => $this->description,
            'is_active' => true,
        ]);

        $this->closeModal();
        $this->dispatch('alert-success', message: 'تم إضافة الوظيفة بنجاح وتوليد الرابط!');
    }

    // إيقاف أو تفعيل الوظيفة
    public function toggleActive($id)
    {
        $job = Job::find($id);
        if ($job) {
            $job->update(['is_active' => !$job->is_active]);
        }
    }

    // حذف الوظيفة
    public function deleteJob($id)
    {
        $job = Job::find($id);
        if ($job) {
            $job->delete();
            $this->dispatch('alert-success', message: 'تم حذف الوظيفة.');
        }
    }

    public function render()
    {
        // جلب جميع الوظائف مرتبة من الأحدث للأقدم
        $jobs = Job::latest()->get();
        
        return view('components.admin.job-manager', compact('jobs'))
               ->layout('components.layouts.admin'); // تأكد أن هذا يطابق مسار الـ Layout الخاص بك
    }
}