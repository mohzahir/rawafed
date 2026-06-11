<div class="relative bg-[#f4f7f6] pb-24 font-sans antialiased text-gray-800 selection:bg-[#bda065] selection:text-[#0a3d62]" dir="rtl">
    
    <div class="absolute top-0 left-0 w-full h-[450px] bg-[#0a3d62] overflow-hidden z-0">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#bda065 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#bda065] rounded-full blur-[150px] opacity-20 transform translate-x-1/2 -translate-y-1/4"></div>
    </div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pt-12 lg:pt-20">
        
        <div class="text-center text-white mb-12 animate-[fadeIn_0.5s_ease-out]">
            <span class="inline-block py-1 px-3 rounded-full bg-white/10 border border-white/20 text-[#bda065] text-xs font-bold tracking-widest mb-4">بوابة الاستقطاب</span>
            <h1 class="text-3xl md:text-5xl font-black mb-4 leading-tight">
                {{ $isFastTrack ? 'التقديم السريع للوظيفة' : 'سجل كفاءتك بخصوصية تامة' }}
            </h1>
            <p class="text-gray-300 text-sm md:text-base max-w-2xl mx-auto leading-relaxed">
                {{ $isFastTrack ? 'أكمل بياناتك الأساسية فقط، وسيقوم الذكاء الاصطناعي باستخراج باقي تفاصيل خبرتك من سيرتك الذاتية.' : 'أكمل ملفك الأعمى الآن، ودع نخبة المستشفيات في المملكة والخليج تتنافس لتقديم أفضل العروض لك.' }}
            </p>
        </div>

        <div class="bg-white rounded-[2.5rem] shadow-2xl shadow-[#0a3d62]/10 border border-gray-100 overflow-hidden flex flex-col md:flex-row min-h-[600px]">
            
            <div class="w-full md:w-[70%] p-6 md:p-12 flex flex-col relative">
                
                @if($isSubmitted && !$showUpsell)
                    <div class="flex-1 flex flex-col items-center justify-center text-center animate-[fadeIn_0.5s_ease-out] w-full max-w-md mx-auto py-8">
                        
                        <div class="w-20 h-20 bg-green-50 text-green-500 rounded-full flex items-center justify-center mb-5 shadow-sm ring-4 ring-green-50/50">
                            <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h3 class="text-2xl font-black text-[#0a3d62] mb-2">تم تشفير ملفك واستلامه!</h3>
                        <p class="text-gray-500 mb-8 leading-relaxed text-sm">أرسلنا رسالة تأكيد لبريدك الإلكتروني. يقوم نظامنا الآن بمعالجة ملفك الأعمى لعرضه على شركائنا بسرية تامة.</p>

                        <div class="w-full bg-gradient-to-br from-blue-50 to-white border border-blue-100 rounded-2xl p-6 mb-6 shadow-sm relative overflow-hidden">
                            <svg class="absolute -top-4 -right-4 w-24 h-24 text-blue-500/5 rotate-12" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                            
                            <div class="relative z-10">
                                <div class="flex justify-center mb-3">
                                    <span class="bg-blue-100 text-blue-600 text-[10px] font-black px-3 py-1 rounded-full tracking-widest uppercase">المجتمع الطبي</span>
                                </div>
                                <h4 class="text-base font-black text-[#0a3d62] mb-2">هل تعرف زميلاً يبحث عن فرصة في الخليج؟</h4>
                                <p class="text-xs text-gray-500 mb-5 font-medium">شارك هذا الرابط مع زملائك الأطباء لمساعدتهم في الوصول إلى أفضل الفرص الوظيفية المخفية.</p>
                                
                                <div class="flex flex-col sm:flex-row gap-3 w-full">
                                    <a href="https://api.whatsapp.com/send?text=مرحباً، أنصحك بالتسجيل في منصة 'روافد' للتوظيف الطبي في الخليج. المنصة تقوم بتحليل سيرتك الذاتية وتعرضها على كبرى المستشفيات بسرية تامة وبدون كشف هويتك لجهة عملك الحالية. سجل من هنا: {{ urlencode(route('candidate.register')) }}" target="_blank" class="flex-1 flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#1ebd5a] text-white px-4 py-2.5 rounded-xl font-bold text-sm transition-all shadow-sm hover:shadow-md">
                                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12.012 2c-5.506 0-9.989 4.478-9.99 9.984a9.964 9.964 0 001.333 4.993L2 22l5.233-1.237a9.994 9.994 0 004.777 1.217h.004c5.502 0 9.988-4.478 9.989-9.984 0-2.669-1.037-5.176-2.922-7.062A9.935 9.935 0 0012.012 2zm0 18.275c-1.515 0-2.996-.407-4.29-1.176l-.308-.182-3.193.754.853-3.11-.2-.318a8.293 8.293 0 01-1.265-4.46c.001-4.568 3.723-8.29 8.296-8.29 2.215 0 4.296.864 5.86 2.428 1.563 1.564 2.425 3.645 2.424 5.861-.001 4.569-3.724 8.291-8.292 8.291zm4.561-6.223c-.25-.125-1.479-.728-1.708-.811-.23-.083-.396-.125-.563.125-.167.25-.646.811-.792.978-.146.166-.292.187-.542.062-.25-.125-1.054-.388-2.008-1.189-.743-.624-1.244-1.396-1.39-1.646-.146-.25-.015-.385.11-.51.112-.112.25-.291.375-.437.125-.146.167-.25.25-.417.083-.166.042-.312-.021-.437-.063-.125-.563-1.354-.771-1.854-.2-.49-.404-.424-.563-.432l-.479-.009c-.167 0-.438.063-.667.313-.229.25-.875.854-.875 2.083 0 1.23.896 2.417 1.021 2.584.125.167 1.761 2.684 4.269 3.769.597.259 1.063.414 1.428.53.603.191 1.15.164 1.583.1.487-.072 1.479-.604 1.688-1.188.208-.584.208-1.084.146-1.188-.062-.104-.229-.166-.479-.291z"/></svg>
                                        إرسال عبر الواتساب
                                    </a>
                                    
                                    <button 
                                        type="button"
                                        x-data="{ 
                                            copied: false,
                                            copyText() {
                                                const link = '{{ route('candidate.register') }}';
                                                if (navigator.clipboard && window.isSecureContext) {
                                                    navigator.clipboard.writeText(link);
                                                } else {
                                                    let textArea = document.createElement('textarea');
                                                    textArea.value = link;
                                                    textArea.style.position = 'absolute';
                                                    textArea.style.opacity = '0';
                                                    document.body.appendChild(textArea);
                                                    textArea.select();
                                                    try { document.execCommand('copy'); } catch(err) {}
                                                    textArea.remove();
                                                }
                                                this.copied = true;
                                                setTimeout(() => this.copied = false, 2000);
                                            }
                                        }" 
                                        @click="copyText()"
                                        :class="copied ? 'border-green-500 text-green-600 bg-green-50' : 'bg-white border-gray-200 hover:bg-gray-50 text-[#0a3d62]'"
                                        class="flex-1 flex items-center justify-center gap-2 border px-4 py-2.5 rounded-xl font-bold text-sm transition-all shadow-sm"
                                    >
                                        <svg x-show="!copied" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        <svg x-cloak style="display: none;" x-show="copied" class="w-4 h-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <span x-text="copied ? 'تم النسخ بنجاح!' : 'نسخ الرابط'"></span>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <button onclick="window.location.reload()" class="text-gray-400 hover:text-[#0a3d62] text-xs font-bold underline transition-colors mt-2">تسجيل ملف كادر آخر</button>
                    </div>

                @elseif($isSubmitted && $showUpsell)
                    <div class="animate-[fadeIn_0.5s_ease-out] w-full max-w-lg mx-auto py-4">
                        <div class="text-center mb-6">
                            <span class="inline-flex items-center justify-center bg-green-100 text-green-600 w-12 h-12 rounded-full mb-3">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                            </span>
                            <h3 class="text-2xl font-black text-[#0a3d62] mb-1">تم التقديم على الوظيفة بنجاح!</h3>
                            <p class="text-sm font-bold text-gray-500">تم إرسال ملفك وسنتواصل معك قريباً.</p>
                        </div>

                        <div class="bg-gradient-to-b from-[#bda065]/10 to-transparent border border-[#bda065]/30 rounded-[2rem] p-6 shadow-lg">
                            <div class="flex items-center gap-3 mb-4 border-b border-[#bda065]/20 pb-4">
                                <span class="text-2xl">🚀</span>
                                <div>
                                    <h4 class="text-lg font-black text-[#0a3d62]">ضاعف فرصك الوظيفية (خطوة اختيارية)</h4>
                                    <p class="text-xs text-gray-600 font-medium mt-1">هل ترغب بعرض ملفك المشفّر على 50+ مستشفى في الكتالوج الأعمى؟ أكمل هذه الحقول السريعة:</p>
                                </div>
                            </div>

                            <form wire:submit.prevent="upgradeToCatalog" class="space-y-5">
                                <div>
                                    <label class="block text-xs font-bold text-[#0a3d62] mb-2">الدول التي ترغب بالعمل فيها <span class="text-red-500">*</span></label>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($gulfCountries as $country)
                                            <label class="relative group cursor-pointer">
                                                <input type="checkbox" wire:model="target_countries" value="{{ $country }}" class="peer hidden">
                                                <div class="px-3 py-1.5 rounded-lg border border-gray-200 bg-white text-gray-600 font-bold text-[11px] transition-all peer-checked:bg-[#bda065] peer-checked:border-[#bda065] peer-checked:text-white hover:border-[#bda065]">
                                                    {{ $country }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs font-bold text-[#0a3d62] mb-2">تراخيص خليجية سابقة (إن وجدت)</label>
                                    <div class="flex flex-wrap gap-2">
                                        @foreach($licenseTypes as $license)
                                            <label class="relative group cursor-pointer">
                                                <input type="checkbox" wire:model="current_licenses" value="{{ $license }}" class="peer hidden">
                                                <div class="px-2 py-1 rounded bg-white border border-gray-200 text-[10px] font-bold text-gray-500 transition-all peer-checked:bg-[#0a3d62] peer-checked:text-white hover:border-[#0a3d62]/50" dir="ltr">
                                                    {{ $license }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 mb-1.5">DataFlow <span class="text-red-500">*</span></label>
                                        <select wire:model="dataflow_status" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg outline-none text-xs font-bold">
                                            <option value="">اختر...</option>
                                            <option value="مكتمل وجاهز">مكتمل</option>
                                            <option value="قيد الإجراء">قيد الإجراء</option>
                                            <option value="لم أبدأ بعد">لم أبدأ بعد</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Prometric <span class="text-red-500">*</span></label>
                                        <select wire:model="prometric_status" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg outline-none text-xs font-bold">
                                            <option value="">اختر...</option>
                                            <option value="مجتاز (سعودي)">مجتاز (سعودي)</option>
                                            <option value="مجتاز (دولة أخرى)">مجتاز (دولة أخرى)</option>
                                            <option value="لم أمتَحن بعد">لم أمتحن بعد</option>
                                        </select>
                                    </div>
                                    <div class="col-span-2">
                                        <label class="block text-xs font-bold text-gray-700 mb-1.5">جاهزية المباشرة <span class="text-red-500">*</span></label>
                                        <select wire:model="notice_period" class="w-full px-3 py-2 bg-white border border-gray-200 rounded-lg outline-none text-xs font-bold">
                                            <option value="">اختر...</option>
                                            <option value="جاهز فوراً">جاهز فوراً</option>
                                            <option value="شهر واحد">خلال شهر</option>
                                            <option value="شهرين">خلال شهرين</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="pt-4 flex flex-col gap-2">
                                    <button type="submit" class="w-full bg-[#0a3d62] text-white py-3 rounded-xl font-black shadow-md hover:bg-[#082d49] transition-all flex justify-center items-center gap-2">
                                        حفظ وإضافة للكتالوج الأعمى
                                    </button>
                                    <button type="button" wire:click="$set('showUpsell', false)" class="w-full bg-transparent text-gray-400 hover:text-gray-600 py-2 rounded-xl text-xs font-bold transition-all">
                                        لا شكراً، أكتفي بالتقديم لهذه الوظيفة فقط
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                @elseif(!$isSubmitted && $isFastTrack)
                    <form wire:submit.prevent="submitFastTrack" class="flex-1 flex flex-col animate-[fadeIn_0.3s_ease-out]">
                        <h3 class="text-xl font-black text-[#0a3d62] mb-1">التقديم السريع</h3>
                        <p class="text-xs text-gray-500 mb-6 border-b border-gray-100 pb-3 font-medium">أكمل البيانات الأساسية، وسيقوم الذكاء الاصطناعي باستخراج خبراتك من السيرة الذاتية.</p>
                        
                        <div class="space-y-4 flex-1">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">الاسم الكامل <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="full_name" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#bda065] outline-none text-sm">
                                @error('full_name') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">الإيميل <span class="text-red-500">*</span></label>
                                    <input type="email" wire:model="email" dir="ltr" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#bda065] outline-none text-sm">
                                    @error('email') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">الواتساب <span class="text-red-500">*</span></label>
                                    <input type="text" wire:model="phone" dir="ltr" placeholder="+966..." class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#bda065] outline-none text-sm">
                                    @error('phone') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">الجنسية <span class="text-red-500">*</span></label>
                                    <select wire:model="nationality" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#bda065] outline-none text-sm">
                                        <option value="">اختر...</option>
                                        @foreach($nationalitiesList as $nat) <option value="{{ $nat }}">{{ $nat }}</option> @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">بلد الإقامة <span class="text-red-500">*</span></label>
                                    <select wire:model="current_location" class="w-full px-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#bda065] outline-none text-sm">
                                        <option value="">اختر...</option>
                                        <option value="السعودية">السعودية</option>
                                        <option value="مصر">مصر</option>
                                        <option value="السودان">السودان</option>
                                        <option value="أخرى">أخرى</option>
                                    </select>
                                </div>
                            </div>

                            <div class="relative group mt-2">
                                <label class="block text-sm font-bold text-gray-700 mb-1">السيرة الذاتية (PDF) <span class="text-red-500">*</span></label>
                                <input type="file" wire:model="cv_file" id="cv_upload_fast" class="hidden" accept=".pdf">
                                <label for="cv_upload_fast" class="flex flex-col items-center justify-center w-full h-24 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:border-[#bda065] transition-all">
                                    @if($cv_file)
                                        <div class="flex items-center gap-2 text-[#27ae60]">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                            <span class="text-xs font-black">{{ $cv_file->getClientOriginalName() }}</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2 text-gray-400">
                                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                            <span class="text-xs font-bold">انقر لرفع ملف الـ PDF</span>
                                        </div>
                                    @endif
                                </label>
                                <div wire:loading wire:target="cv_file" class="absolute inset-0 bg-white/80 rounded-xl flex items-center justify-center z-20">
                                    <span class="text-xs font-bold text-[#0a3d62] animate-pulse">جاري الرفع...</span>
                                </div>
                                @error('cv_file') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <div class="mt-6 pt-4 border-t border-gray-100">
                            <button type="submit" wire:loading.attr="disabled" class="w-full bg-[#bda065] text-white py-3.5 rounded-xl font-black hover:bg-[#a68c58] transition shadow-lg flex justify-center items-center gap-2">
                                <span wire:loading.remove wire:target="submitFastTrack">تقديم الطلب وتشفير الملف</span>
                                <svg wire:loading wire:target="submitFastTrack" class="animate-spin h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                <span wire:loading wire:target="submitFastTrack">جاري التحليل والمعالجة...</span>
                            </button>
                        </div>
                    </form>

                @else
                    <div class="mb-10 relative">
                        <div class="flex justify-between items-center relative z-10">
                            <div class="absolute top-1/2 right-0 w-full h-1.5 bg-gray-100 -translate-y-1/2 z-0 rounded-full"></div>
                            <div class="absolute top-1/2 right-0 h-1.5 bg-gradient-to-l from-[#0a3d62] to-[#bda065] -translate-y-1/2 z-0 transition-all duration-700 rounded-full" style="width: {{ (($currentStep - 1) / 3) * 100 }}%"></div>
                            
                            @php
                                $steps = [
                                    ['label' => 'شخصي', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />'],
                                    ['label' => 'مهني', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />'],
                                    ['label' => 'تراخيص', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />'],
                                    ['label' => 'المرفقات', 'icon' => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />']
                                ];
                            @endphp

                            @foreach($steps as $index => $step)
                                <div class="flex flex-col items-center gap-2 bg-white px-2">
                                    <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-all duration-500 z-10 {{ $currentStep > $index + 1 ? 'bg-[#bda065] text-white' : ($currentStep == $index + 1 ? 'bg-[#0a3d62] text-white ring-4 ring-[#0a3d62]/20' : 'bg-white border-2 border-gray-200 text-gray-300') }}">
                                        @if($currentStep > $index + 1)
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">{!! $step['icon'] !!}</svg>
                                        @endif
                                    </div>
                                    <span class="text-[10px] font-black {{ $currentStep >= $index + 1 ? 'text-[#0a3d62]' : 'text-gray-400' }} hidden sm:block">{{ $step['label'] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <form wire:submit.prevent="submitRegistration" class="flex-1 flex flex-col">
                        
                        @if($currentStep == 1)
                            <div class="space-y-5 animate-[fadeIn_0.3s_ease-out]">
                                <h3 class="text-xl font-black text-[#0a3d62] mb-4 border-b border-gray-100 pb-3">المعلومات الشخصية</h3>
                                
                                <div class="space-y-5">
                                    <div class="relative">
                                        <label class="block text-sm font-bold text-gray-700 mb-1.5">الاسم الكامل (كما في الجواز) <span class="text-red-500">*</span></label>
                                        <input type="text" wire:model="full_name" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#bda065] outline-none transition-all text-sm">
                                        @error('full_name') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1.5">البريد الإلكتروني <span class="text-red-500">*</span></label>
                                            <input type="email" wire:model="email" dir="ltr" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#bda065] outline-none transition-all text-sm">
                                            @error('email') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1.5">الواتساب <span class="text-red-500">*</span></label>
                                            <input type="text" wire:model="phone" dir="ltr" placeholder="+966..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#bda065] outline-none transition-all text-sm">
                                            @error('phone') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1.5">الجنسية <span class="text-red-500">*</span></label>
                                            <select wire:model="nationality" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#bda065] outline-none transition-all text-sm">
                                                <option value="">اختر...</option>
                                                @foreach($nationalitiesList as $nat) <option value="{{ $nat }}">{{ $nat }}</option> @endforeach
                                            </select>
                                            @error('nationality') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1.5">بلد الإقامة الحالي <span class="text-red-500">*</span></label>
                                            <select wire:model="current_location" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#bda065] outline-none transition-all text-sm">
                                                <option value="">اختر...</option>
                                                <option value="السعودية">السعودية</option>
                                                <option value="الإمارات">الإمارات</option>
                                                <option value="الكويت">الكويت</option>
                                                <option value="قطر">قطر</option>
                                                <option value="سلطنة عمان">سلطنة عمان</option>
                                                <option value="البحرين">البحرين</option>
                                                <option disabled>──────────</option>
                                                <option value="السودان">السودان</option>
                                                <option value="مصر">مصر</option>
                                                <option value="الأردن">الأردن</option>
                                                <option value="أخرى">أخرى</option>
                                            </select>
                                            @error('current_location') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($currentStep == 2)
                            <div class="space-y-5 animate-[fadeIn_0.3s_ease-out]">
                                <h3 class="text-xl font-black text-[#0a3d62] mb-4 border-b border-gray-100 pb-3">التخصص والخبرة</h3>
                                <div class="space-y-5">
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1.5">التصنيف المهني <span class="text-red-500">*</span></label>
                                            <select wire:model="professional_title" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#bda065] outline-none text-sm">
                                                <option value="">اختر التصنيف...</option>
                                                @foreach($medicalTitles as $title) <option value="{{ $title }}">{{ $title }}</option> @endforeach
                                            </select>
                                            @error('professional_title') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1.5">سنوات الخبرة <span class="text-red-500">*</span></label>
                                            <input type="number" wire:model="years_of_experience" min="0" placeholder="0" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#bda065] outline-none text-sm">
                                            @error('years_of_experience') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1.5">التخصص العام <span class="text-red-500">*</span></label>
                                        <select wire:model="general_specialty" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#bda065] outline-none text-sm">
                                            <option value="">اختر التخصص...</option>
                                            @foreach($medicalSpecialties as $spec) <option value="{{ $spec }}">{{ $spec }}</option> @endforeach
                                        </select>
                                        @error('general_specialty') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1.5">التخصص الدقيق والمهارات <span class="font-normal text-gray-400">(اختياري)</span></label>
                                        <textarea wire:model="sub_specialty" rows="3" placeholder="أضف مهاراتك الدقيقة..." class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#bda065] outline-none text-sm resize-none"></textarea>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($currentStep == 3)
                            <div class="space-y-5 animate-[fadeIn_0.3s_ease-out]">
                                <h3 class="text-xl font-black text-[#0a3d62] mb-4 border-b border-gray-100 pb-3">الجاهزية الخليجية</h3>
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-bold text-[#0a3d62] mb-3">الوجهة المستهدفة <span class="text-red-500">*</span></label>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($gulfCountries as $country)
                                                <label class="relative group cursor-pointer">
                                                    <input type="checkbox" wire:model="target_countries" value="{{ $country }}" class="peer hidden">
                                                    <div class="px-4 py-2 rounded-lg border border-gray-200 bg-gray-50 text-gray-600 font-bold text-xs transition-all peer-checked:bg-[#bda065]/10 peer-checked:border-[#bda065] peer-checked:text-[#0a3d62]">
                                                        {{ $country }}
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                        @error('target_countries') <span class="text-red-500 text-[10px] font-bold mt-2 block">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label class="block text-sm font-bold text-[#0a3d62] mb-3">التراخيص الحالية <span class="font-normal text-gray-400">(إن وجدت)</span></label>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($licenseTypes as $license)
                                                <label class="relative group cursor-pointer">
                                                    <input type="checkbox" wire:model="current_licenses" value="{{ $license }}" class="peer hidden">
                                                    <div class="px-3 py-2 rounded-lg border border-gray-200 bg-white text-[11px] font-bold text-gray-500 transition-all peer-checked:bg-[#0a3d62] peer-checked:text-white" dir="ltr">
                                                        {{ $license }}
                                                    </div>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-4">
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1.5">توثيق DataFlow <span class="text-red-500">*</span></label>
                                            <select wire:model="dataflow_status" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#bda065] outline-none text-sm">
                                                <option value="">اختر...</option>
                                                <option value="مكتمل وجاهز">مكتمل وجاهز</option>
                                                <option value="قيد الإجراء">قيد الإجراء</option>
                                                <option value="لم أبدأ بعد">لم أبدأ بعد</option>
                                            </select>
                                            @error('dataflow_status') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                        <div>
                                            <label class="block text-sm font-bold text-gray-700 mb-1.5">امتحان Prometric <span class="text-red-500">*</span></label>
                                            <select wire:model="prometric_status" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#bda065] outline-none text-sm">
                                                <option value="">اختر...</option>
                                                <option value="مجتاز (سعودي)">مجتاز (سعودي)</option>
                                                <option value="مجتاز (دولة أخرى)">مجتاز (دولة أخرى)</option>
                                                <option value="لم أمتَحن بعد">لم أمتحن بعد</option>
                                            </select>
                                            @error('prometric_status') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if($currentStep == 4)
                            <div class="space-y-5 animate-[fadeIn_0.3s_ease-out]">
                                <h3 class="text-xl font-black text-[#0a3d62] mb-4 border-b border-gray-100 pb-3">المرفقات والإنهاء</h3>
                                <div class="space-y-6">
                                    <div>
                                        <label class="block text-sm font-bold text-gray-700 mb-1.5">متى يمكنك المباشرة؟ <span class="text-red-500">*</span></label>
                                        <select wire:model="notice_period" class="w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:bg-white focus:border-[#bda065] outline-none text-sm font-bold">
                                            <option value="">اختر الفترة...</option>
                                            <option value="جاهز فوراً">جاهز فوراً (بدون إنذار)</option>
                                            <option value="شهر واحد">خلال شهر واحد</option>
                                            <option value="شهرين">خلال شهرين</option>
                                            <option value="3 أشهر فأكثر">3 أشهر فأكثر</option>
                                        </select>
                                        @error('notice_period') <span class="text-red-500 text-[10px] font-bold mt-1 block">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="relative group pt-2">
                                        <label class="block text-sm font-bold text-gray-700 mb-2">السيرة الذاتية (PDF) <span class="text-red-500">*</span></label>
                                        <input type="file" wire:model="cv_file" id="cv_upload" class="hidden" accept=".pdf">
                                        <label for="cv_upload" class="flex flex-col items-center justify-center w-full h-40 border-2 border-dashed border-gray-300 rounded-2xl cursor-pointer bg-gray-50 hover:border-[#bda065] transition-all">
                                            @if($cv_file)
                                                <div class="flex flex-col items-center text-[#27ae60] z-10">
                                                    <svg class="w-10 h-10 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                    <span class="text-sm font-black">{{ $cv_file->getClientOriginalName() }}</span>
                                                </div>
                                            @else
                                                <div class="flex flex-col items-center text-gray-400 z-10">
                                                    <svg class="w-10 h-10 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                                    <span class="text-sm font-bold text-gray-600">انقر لرفع ملف الـ PDF</span>
                                                </div>
                                            @endif
                                        </label>
                                        <div wire:loading wire:target="cv_file" class="absolute inset-0 bg-white/80 rounded-2xl flex flex-col items-center justify-center z-20">
                                            <svg class="animate-spin h-6 w-6 text-[#bda065] mb-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                            <span class="text-xs font-bold text-[#0a3d62]">جاري الرفع...</span>
                                        </div>
                                        @error('cv_file') <span class="text-red-500 text-[10px] font-bold mt-2 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mt-auto pt-8 flex justify-between items-center">
                            @if($currentStep > 1)
                                <button type="button" wire:click="previousStep" class="text-gray-500 hover:text-[#0a3d62] font-bold transition text-sm bg-gray-100 hover:bg-gray-200 px-5 py-2.5 rounded-xl">رجوع</button>
                            @else
                                <div></div>
                            @endif

                            @if($currentStep < 4)
                                <button type="button" wire:click="nextStep" class="bg-[#0a3d62] text-white px-8 py-3 rounded-xl font-bold hover:bg-[#082d49] transition shadow-md flex items-center gap-2">التالي</button>
                            @else
                                <button type="submit" wire:loading.attr="disabled" class="bg-[#bda065] text-white px-8 py-3 rounded-xl font-bold hover:bg-[#a68c58] transition shadow-lg flex items-center gap-2 disabled:opacity-70">
                                    <span wire:loading.remove wire:target="submitRegistration">إرسال وتشفير الملف</span>
                                    <svg wire:loading wire:target="submitRegistration" class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    <span wire:loading wire:target="submitRegistration">جاري المعالجة...</span>
                                </button>
                            @endif
                        </div>
                    </form>
                @endif
            </div>

            <div class="hidden md:flex md:w-[30%] bg-[#f8fafc] border-l border-gray-100 p-8 flex-col justify-center relative overflow-hidden">
                <svg class="absolute top-0 left-0 w-32 h-32 text-gray-100 transform -translate-x-10 -translate-y-10" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                
                <h4 class="text-lg font-black text-[#0a3d62] mb-8 relative z-10">لماذا "روافد"؟</h4>
                
                <div class="space-y-6 relative z-10">
                    <div class="flex gap-4">
                        <div class="mt-1 w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-gray-800">سرية تامة</h5>
                            <p class="text-xs text-gray-500 mt-1">نظام الملف الأعمى يحمي بياناتك عن جهة عملك الحالية.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="mt-1 w-8 h-8 rounded-lg bg-blue-100 text-[#0a3d62] flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-gray-800">وصول مباشر</h5>
                            <p class="text-xs text-gray-500 mt-1">ملفك يصل فوراً لصناع القرار في المستشفيات بلا وسطاء.</p>
                        </div>
                    </div>
                    <div class="flex gap-4">
                        <div class="mt-1 w-8 h-8 rounded-lg bg-yellow-100 text-[#bda065] flex items-center justify-center shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                        <div>
                            <h5 class="text-sm font-bold text-gray-800">تشفير آلي</h5>
                            <p class="text-xs text-gray-500 mt-1">تتم معالجة السيرة الذاتية وطمس الهوية برمجياً بالذكاء الاصطناعي.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-10 p-4 bg-white rounded-xl border border-gray-100 text-center relative z-10 shadow-sm">
                    <p class="text-[10px] font-bold text-gray-400 mb-2 uppercase">شركاء النجاح</p>
                    <div class="flex justify-center gap-3 opacity-60 grayscale">
                        <span class="text-xs font-black text-[#0a3d62]">الحبيب</span>
                        <span class="text-xs font-black text-[#0a3d62]">المواساة</span>
                        <span class="text-xs font-black text-[#0a3d62]">دلة</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</div>