<div class="max-w-5xl mx-auto px-6 py-12" dir="rtl">
    
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-extrabold text-[#0a3d62]">استيراد قواعد البيانات (CSV)</h1>
            <p class="text-gray-500 mt-2">قم برفع ملف الـ CSV الناتج من سكريبت البايثون لإدخال آلاف المرشحين في ثوانٍ.</p>
        </div>
    </div>

    @if($successCount > 0)
        <div class="bg-green-50 border-r-4 border-green-500 text-green-800 p-4 rounded-lg mb-6 shadow-sm flex items-center gap-3">
            <span class="text-2xl">✅</span>
            <div>
                <strong class="font-bold text-lg block">اكتملت عملية الاستيراد بنجاح!</strong>
                <span class="text-sm">تم إدخال <strong>{{ $successCount }}</strong> مرشح إلى قاعدة البيانات وهم الآن متاحون في الكتالوج الأعمى.</span>
            </div>
        </div>
    @endif

    @if($errorCount > 0)
        <div class="bg-red-50 border-r-4 border-red-500 text-red-800 p-4 rounded-lg mb-6 shadow-sm flex items-center gap-3">
            <span class="text-2xl">⚠️</span>
            <div>
                <strong class="font-bold text-lg block">تنبيه: يوجد سطور لم يتم استيرادها</strong>
                <span class="text-sm">فشل استيراد <strong>{{ $errorCount }}</strong> سطر بسبب أخطاء في تنسيق البيانات. راجع ملف الـ Log للتفاصيل.</span>
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-1">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200 sticky top-10">
                <h3 class="font-bold text-[#0a3d62] mb-4">رفع الملف</h3>
                
                <form wire:submit.prevent="importCsv">
                    <div class="mb-6">
                        <label for="csv_file" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-[#bda065] rounded-xl cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <span class="text-3xl mb-2">📊</span>
                                <p class="text-sm text-[#0a3d62] font-bold">اختر ملف CSV</p>
                            </div>
                            <input id="csv_file" type="file" wire:model="csv_file" accept=".csv,.txt" class="hidden" />
                        </label>
                        @error('csv_file') <span class="text-red-500 text-xs mt-2 block">{{ $message }}</span> @enderror
                        
                        @if($csv_file)
                            <div class="mt-3 text-sm text-green-600 font-bold bg-green-50 p-2 rounded text-center truncate">
                                📎 {{ $csv_file->getClientOriginalName() }}
                            </div>
                        @endif
                    </div>

                    <button type="submit" class="w-full bg-[#0a3d62] hover:bg-[#082d49] text-white font-extrabold py-3.5 rounded-xl transition shadow-md" {{ empty($csv_file) ? 'disabled' : '' }}>
                        <span wire:loading.remove wire:target="importCsv">بدء الاستيراد الآن</span>
                        <span wire:loading wire:target="importCsv">جاري المعالجة... ⏳</span>
                    </button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-200">
                <h3 class="font-bold text-[#0a3d62] mb-4 flex items-center gap-2">
                    <span>⚠️</span> دليل تنسيق ملف الـ CSV المطلوب
                </h3>
                <p class="text-sm text-gray-600 mb-4 leading-relaxed">
                    يجب أن يقوم سكريبت البايثون بتصدير البيانات بترميز <strong>UTF-8</strong> وبنفس الترتيب الدقيق للأعمدة أدناه. السطر الأول في الملف سيتم تجاهله (عناوين الأعمدة).
                </p>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-right text-gray-500 border border-gray-100">
                        <thead class="text-xs text-[#0a3d62] uppercase bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 border-b">رقم العمود</th>
                                <th class="px-4 py-3 border-b">اسم الحقل المتوقع</th>
                                <th class="px-4 py-3 border-b">مثال لبيانات صحيحة</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border-b"><td class="px-4 py-2 font-bold">0</td><td class="px-4 py-2">الاسم الكامل</td><td class="px-4 py-2 text-xs">أحمد محمد علي</td></tr>
                            <tr class="border-b"><td class="px-4 py-2 font-bold">1</td><td class="px-4 py-2">الإيميل</td><td class="px-4 py-2 text-xs">ahmed@email.com</td></tr>
                            <tr class="border-b"><td class="px-4 py-2 font-bold">2</td><td class="px-4 py-2">رقم الهاتف</td><td class="px-4 py-2 text-xs">+24912345678</td></tr>
                            <tr class="border-b bg-gray-50"><td class="px-4 py-2 font-bold">3 & 4</td><td class="px-4 py-2">الجنسية / الإقامة</td><td class="px-4 py-2 text-xs">سوداني / السعودية</td></tr>
                            <tr class="border-b"><td class="px-4 py-2 font-bold">5</td><td class="px-4 py-2">الدرجة المهنية</td><td class="px-4 py-2 text-xs">طبيب نائب أول (Senior Registrar)</td></tr>
                            <tr class="border-b"><td class="px-4 py-2 font-bold">6 & 7</td><td class="px-4 py-2">التخصص العام / الدقيق</td><td class="px-4 py-2 text-xs">جراحة عامة / مناظير</td></tr>
                            <tr class="border-b bg-gray-50"><td class="px-4 py-2 font-bold">8</td><td class="px-4 py-2">سنوات الخبرة</td><td class="px-4 py-2 text-xs text-red-500 font-bold">5 (يجب أن يكون رقماً فقط)</td></tr>
                            <tr class="border-b"><td class="px-4 py-2 font-bold">9, 10, 11</td><td class="px-4 py-2">حالات التراخيص</td><td class="px-4 py-2 text-xs">مجتاز / قيد الإجراء / مصنف</td></tr>
                            <tr class="border-b bg-green-50"><td class="px-4 py-2 font-bold text-green-700">13</td><td class="px-4 py-2 text-green-700 font-bold">مسار الـ CV الأصلي</td><td class="px-4 py-2 text-xs">cvs/original/ahmed.pdf</td></tr>
                            <tr class="bg-green-50"><td class="px-4 py-2 font-bold text-green-700">14</td><td class="px-4 py-2 text-green-700 font-bold">مسار الـ CV الأعمى</td><td class="px-4 py-2 text-xs">cvs/blind/ahmed_blind.pdf</td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
    </div>
</div>