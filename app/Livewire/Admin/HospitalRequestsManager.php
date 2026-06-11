<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\HospitalRequest;

class HospitalRequestsManager extends Component
{
    use WithPagination;

    public $statusFilter = ''; // فلتر حالة الطلبات

    // دالة لتغيير حالة الطلب (مثلاً من معلق إلى تم التواصل)
    public function updateStatus($requestId, $newStatus)
    {
        $request = HospitalRequest::find($requestId);
        if ($request) {
            $request->update(['status' => $newStatus]);
            $this->dispatch('alert-success', message: 'تم تحديث حالة الطلب بنجاح.');
        }
    }

    // دالة لحذف الطلب إذا لزم الأمر
    public function deleteRequest($requestId)
    {
        $request = HospitalRequest::find($requestId);
        if ($request) {
            $request->delete();
            $this->dispatch('alert-success', message: 'تم حذف الطلب.');
        }
    }

    public function render()
    {
        // جلب الطلبات مع بيانات الطبيب المرتبطة بها
        $query = HospitalRequest::with('candidate')->latest();

        if ($this->statusFilter) {
            $query->where('status', $this->statusFilter);
        }

        $requests = $query->paginate(15);

        return view('components.admin.hospital-requests-manager', [
            'requests' => $requests
        ])->layout('components.layouts.admin'); // تأكد من استخدام الـ layout الخاص بك
    }
}