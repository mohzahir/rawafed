<div class="bg-[#f8fafc] py-6 font-sans antialiased" dir="rtl">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-gray-200 pb-6">
            <div>
                <span class="text-[#bda065] font-black text-sm tracking-widest uppercase mb-1 block">لوحة الإدارة</span>
                <h1 class="text-3xl font-black text-[#0a3d62] mb-2">إدارة حملات التوظيف (الوظائف المفتوحة)</h1>
                <p class="text-gray-500 text-sm">أنشئ صفحات هبوط للوظائف، انشر الروابط، واستقطب الكفاءات الطبية مباشرة.</p>
            </div>
            
            <button wire:click="openModal" class="bg-[#0a3d62] hover:bg-[#082d49] text-white px-6 py-3 rounded-xl font-bold transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                إضافة وظيفة جديدة
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @forelse($jobs as $job)
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 flex flex-col {{ !$job->is_active ? 'opacity-60 grayscale-[50%]' : '' }} transition-all">
                    
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex gap-2">
                            <span class="text-[10px] font-bold px-2 py-1 rounded bg-blue-50 text-blue-600">{{ $job->specialty }}</span>
                            <span class="text-[10px] font-bold px-2 py-1 rounded bg-gray-50 text-gray-600">{{ $job->country }}</span>
                        </div>
                        <button wire:click="toggleActive({{ $job->id }})" class="text-xs font-bold {{ $job->is_active ? 'text-green-500 hover:text-green-700' : 'text-gray-400 hover:text-gray-600' }} flex items-center gap-1 transition-colors" title="إيقاف/تشغيل استقبال الطلبات">
                            <div class="w-8 h-4 rounded-full {{ $job->is_active ? 'bg-green-500' : 'bg-gray-300' }} relative transition-colors">
                                <div class="w-3 h-3 bg-white rounded-full absolute top-0.5 transition-all {{ $job->is_active ? 'left-0.5' : 'right-0.5' }}"></div>
                            </div>
                            {{ $job->is_active ? 'نشط' : 'متوقف' }}
                        </button>
                    </div>

                    <h3 class="text-lg font-black text-[#0a3d62] mb-2 leading-tight line-clamp-2">{{ $job->title }}</h3>
                    @if($job->salary_range)
                        <p class="text-sm font-bold text-[#bda065] mb-4">الراتب: {{ $job->salary_range }}</p>
                    @else
                        <p class="text-sm font-bold text-gray-400 mb-4">الراتب: يحدد لاحقاً</p>
                    @endif

                    <div class="mt-auto pt-4 border-t border-gray-50 flex items-center justify-between gap-2">
                        <button 
                            type="button"
                            x-data="{ copied: false }" 
                            @click="
                                window.copyToClipboard('{{ route('jobs.show', $job->slug) }}');
                                copied = true;
                                setTimeout(() => copied = false, 2000);
                            "
                            :class="copied ? 'bg-green-50 text-green-600 border-green-200' : 'bg-gray-50 text-gray-600 hover:bg-[#0a3d62] hover:text-white border-gray-100'"
                            class="flex-1 flex items-center justify-center gap-2 px-3 py-2 rounded-xl text-xs font-bold transition-all border group"
                        >
                            <svg x-show="!copied" class="w-4 h-4 text-gray-400 group-hover:text-white transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                            <svg x-cloak style="display: none;" x-show="copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            <span x-text="copied ? 'تم النسخ!' : 'نسخ الرابط للنشر'"></span>
                        </button>

                        <button wire:click="deleteJob({{ $job->id }})" onclick="confirm('هل أنت متأكد من حذف هذه الوظيفة؟') || event.stopImmediatePropagation()" class="w-9 h-9 flex items-center justify-center rounded-xl bg-red-50 text-red-500 hover:bg-red-500 hover:text-white transition-colors shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-3xl p-12 text-center border border-gray-100 border-dashed">
                    <div class="w-16 h-16 bg-gray-50 rounded-full flex items-center justify-center text-gray-300 mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    </div>
                    <h3 class="text-xl font-black text-gray-400 mb-2">لا توجد حملات توظيف نشطة</h3>
                    <p class="text-gray-400 text-sm mb-6">ابدأ بإنشاء أول وظيفة لنشرها واستقطاب الكفاءات.</p>
                </div>
            @endforelse
        </div>
    </div>

    @if($isModalOpen)
        <div class="fixed inset-0 bg-[#0a3d62]/80 backdrop-blur-sm z-50 flex items-center justify-center p-4 animate-[fadeIn_0.2s_ease-out]">
            <div class="bg-white w-full max-w-2xl rounded-[24px] shadow-2xl overflow-hidden flex flex-col max-h-[90vh]">
                
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50">
                    <h2 class="text-xl font-black text-[#0a3d62]">إضافة حملة توظيف (وظيفة جديدة)</h2>
                    <button wire:click="closeModal" class="text-gray-400 hover:text-red-500 transition-colors">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <div class="p-6 overflow-y-auto custom-scrollbar">
                    <form wire:submit.prevent="saveJob" class="space-y-5">
                        
                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">العنوان الجذاب للوظيفة (سيظهر للأطباء) <span class="text-red-500">*</span></label>
                            <input type="text" wire:model="title" placeholder="مثال: مطلوب استشاري عناية مركزة (ICU) عاجل" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-[#bda065] focus:ring-2 focus:ring-[#bda065]/20 transition-all font-bold">
                            @error('title') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">التخصص <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="specialty" placeholder="مثال: تخدير، أطفال..." class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-[#bda065] focus:ring-2 focus:ring-[#bda065]/20 transition-all">
                                @error('specialty') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-2">الدولة / المدينة <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="country" placeholder="مثال: السعودية - الرياض" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-[#bda065] focus:ring-2 focus:ring-[#bda065]/20 transition-all">
                                @error('country') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">نطاق الراتب أو المميزات (اختياري)</label>
                            <input type="text" wire:model="salary_range" placeholder="مثال: يبدأ من 45,000 ريال + سكن وتذاكر" class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-[#bda065] focus:ring-2 focus:ring-[#bda065]/20 transition-all">
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-gray-700 mb-2">وصف الوظيفة والمتطلبات <span class="text-red-500">*</span></label>
                            <textarea wire:model="description" rows="5" placeholder="اكتب تفاصيل الوظيفة، ساعات العمل، اشتراطات التصنيف (داتا فلو والبرومترك)..." class="w-full bg-white border border-gray-200 rounded-xl px-4 py-3 outline-none focus:border-[#bda065] focus:ring-2 focus:ring-[#bda065]/20 transition-all"></textarea>
                            @error('description') <span class="text-red-500 text-xs font-bold mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-4 border-t border-gray-100 flex gap-3">
                            <button type="submit" class="flex-1 bg-[#0a3d62] text-white py-3.5 rounded-xl font-black shadow-lg hover:bg-[#082d49] hover:shadow-xl transition-all flex justify-center items-center gap-2">
                                <span wire:loading.remove wire:target="saveJob">حفظ وإنشاء الرابط المخصص</span>
                                <span wire:loading wire:target="saveJob">جاري الإنشاء...</span>
                            </button>
                            <button type="button" wire:click="closeModal" class="px-6 py-3.5 bg-gray-100 hover:bg-gray-200 text-gray-600 rounded-xl font-bold transition-colors">
                                إلغاء
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    @endif

    <script>
        window.addEventListener('alert-success', event => {
            alert(event.detail.message);
        });

        // دالة النسخ العالمية (لتعمل في كل مكان)
        if (typeof window.copyToClipboard !== 'function') {
            window.copyToClipboard = function(text) {
                if (navigator.clipboard && window.isSecureContext) {
                    navigator.clipboard.writeText(text);
                } else {
                    let textArea = document.createElement('textarea');
                    textArea.value = text;
                    textArea.style.position = 'fixed';
                    textArea.style.left = '-999999px';
                    document.body.appendChild(textArea);
                    textArea.focus();
                    textArea.select();
                    try { document.execCommand('copy'); } catch (err) {}
                    textArea.remove();
                }
            }
        }
    </script>
</div>