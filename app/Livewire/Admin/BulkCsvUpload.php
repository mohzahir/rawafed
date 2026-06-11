<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Candidate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BulkCsvUpload extends Component
{
    use WithFileUploads;

    public $csv_file;
    public $successCount = 0;
    public $errorCount = 0;

    public function importCsv()
    {
        $this->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:10240', // حد أقصى 10 ميجا
        ]);

        $path = $this->csv_file->getRealPath();
        
        if (($handle = fopen($path, 'r')) !== false) {
            
            // تخطي الصف الأول (عناوين الأعمدة)
            fgetcsv($handle); 
            
            $inserted_or_updated = 0;
            $failed = 0;

            while (($row = fgetcsv($handle)) !== false) {
                try {
                    // تجنب السطور الفارغة
                    if (empty(array_filter($row))) {
                        continue;
                    }

                    // 1. تنظيف البيانات من أي مسافات زائدة (خاصة رقم الهاتف الذي عدلناه في البايثون)
                    $fullName = trim($row[0] ?? 'غير محدد');
                    $email = trim($row[1] ?? 'غير محدد');
                    $phone = trim($row[2] ?? 'غير محدد');
                    
                    // تجاوز السطر إذا كان الإيميل والهاتف فارغين (رغم أن البايثون ينظفهم، لكن كطبقة حماية إضافية)
                    if ($email === 'غير محدد' && $phone === 'غير محدد') {
                        continue;
                    }

                    // 2. استخدام updateOrCreate لمنع التكرار وتحديث البيانات إن وُجدت
                    // سيبحث عن المرشح بالهاتف والإيميل، إذا وجده يحدّثه، وإذا لم يجده ينشئه
                    Candidate::updateOrCreate(
                        [
                            // شروط البحث (المفاتيح الفريدة)
                            'email' => $email,
                            'phone' => $phone,
                        ],
                        [
                            // البيانات التي سيتم إضافتها أو تحديثها
                            'candidate_code' => 'RWD-' . strtoupper(Str::random(6)), // توليد كود فريد أكثر أماناً من rand
                            'full_name' => $fullName,
                            'nationality' => trim($row[3] ?? 'غير محدد'),
                            'current_location' => trim($row[4] ?? 'غير محدد'),
                            'professional_title' => trim($row[5] ?? 'غير محدد'),
                            'general_specialty' => trim($row[6] ?? 'غير محدد'),
                            'sub_specialty' => trim($row[7] ?? null),
                            'years_of_experience' => (int) trim($row[8] ?? 0),
                            'prometric_status' => trim($row[9] ?? 'غير محدد'),
                            'dataflow_status' => trim($row[10] ?? 'غير محدد'),
                            'scfhs_status' => trim($row[11] ?? 'غير محدد'),
                            'notice_period' => trim($row[12] ?? 'غير محدد'),
                            'original_cv_path' => trim($row[13] ?? null),
                            'blind_cv_path' => trim($row[14] ?? null),
                            'is_active' => true, 
                        ]
                    );

                    $inserted_or_updated++;
                } catch (\Exception $e) {
                    Log::error('خطأ في استيراد السطر: ' . json_encode($row) . ' - الخطأ: ' . $e->getMessage());
                    $failed++;
                }
            }
            fclose($handle);

            $this->successCount = $inserted_or_updated;
            $this->errorCount = $failed;
            
            // تفريغ الملف بعد الانتهاء
            $this->reset('csv_file');
        }
    }

    public function render()
    {
        return view('components.admin.bulk-csv-upload')->layout('components.layouts.admin');
    }
}