<div class="min-h-screen bg-[#f8fafc] py-12 font-sans antialiased" dir="rtl">
    
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4">
            <div>
                <h1 class="text-3xl font-black text-[#0a3d62] mb-2">الكتالوج الأعمى للكفاءات</h1>
                <p class="text-gray-500 text-sm">تصفح، فلتر، واختر النخبة الطبية الجاهزة للمباشرة بسرية تامة.</p>
            </div>
            
            <div class="hidden md:flex items-center gap-3">
                <span class="text-sm font-bold text-gray-400"><span class="text-[#bda065] font-black mx-1">{{ count($selectedCandidatesForInterview) }}</span> مرشح محدد</span>
                <button onclick="openInterviewModal()" {{ count($selectedCandidatesForInterview) == 0 ? 'disabled' : '' }} class="{{ count($selectedCandidatesForInterview) > 0 ? 'bg-[#0a3d62] text-white hover:bg-[#082d49]' : 'bg-gray-200 text-gray-400 cursor-not-allowed' }} px-6 py-2.5 rounded-xl font-bold transition-all">
                    طلب مقابلات
                </button>
            </div>
        </div>

        <div class="flex flex-col lg:flex-row gap-8">
            
            <div class="w-full lg:w-[280px] xl:w-[320px] shrink-0">
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6 lg:sticky lg:top-8">
                    
                    <div class="flex items-center justify-between mb-6 border-b border-gray-50 pb-4">
                        <h3 class="font-black text-[#0a3d62] text-lg flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#bda065]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            تصفية النتائج
                        </h3>
                        <button wire:click="clearFilters" class="text-[11px] font-bold text-red-500 hover:text-red-700 bg-red-50 px-2 py-1 rounded-md transition-colors">
                            مسح الكل
                        </button>
                    </div>

                    {{-- <div class="space-y-8">

                        <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-50">
                            <label class="block text-sm font-bold text-[#0a3d62] mb-3">الدرجة الوظيفية</label>
                            <select wire:model.live="selectedTitle" class="w-full text-sm bg-white border border-gray-200 rounded-xl px-3 py-2.5 outline-none focus:border-[#bda065] focus:ring-2 focus:ring-[#bda065]/10 font-bold text-[#0a3d62] shadow-sm">
                                <option value="">جميع درجات القسم</option>
                                @foreach($tabs[$selectedTab]['titles'] as $title)
                                    <option value="{{ $title }}">{{ $title }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-50 -mt-4">
                            <label class="block text-sm font-bold text-[#0a3d62] mb-3">التخصص العام</label>
                            <select wire:model.live="selectedSpecialty" class="w-full text-sm bg-white border border-gray-200 rounded-xl px-3 py-2.5 outline-none focus:border-[#bda065] focus:ring-2 focus:ring-[#bda065]/10 font-bold text-[#0a3d62] shadow-sm">
                                <option value="">جميع تخصصات القسم</option>
                                @foreach($tabs[$selectedTab]['specialties'] as $specialty)
                                    <option value="{{ $specialty }}">{{ $specialty }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-[#0a3d62] mb-3">دولة العمل المستهدفة</label>
                            <div class="space-y-2">
                                @php $countries = ['السعودية', 'الكويت', 'الإمارات', 'قطر', 'عمان', 'البحرين']; @endphp
                                @foreach($countries as $country)
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" wire:model.live="selectedCountries" value="{{ $country }}" class="w-5 h-5 rounded border-gray-300 text-[#bda065] focus:ring-[#bda065]/20 cursor-pointer">
                                        <span class="text-sm text-gray-600 font-medium group-hover:text-[#0a3d62] transition-colors">{{ $country }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-[#0a3d62] mb-3">الجاهزية والتراخيص</label>
                            <div class="space-y-4">
                                <div>
                                    <select wire:model.live="dataflowStatus" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 outline-none focus:border-[#bda065] focus:ring-2 focus:ring-[#bda065]/10 font-medium text-gray-600">
                                        <option value="">حالة DataFlow (الكل)</option>
                                        <option value="مكتمل وجاهز">مكتمل وجاهز</option>
                                        <option value="قيد الإجراء">قيد الإجراء</option>
                                    </select>
                                </div>
                                <div>
                                    <select wire:model.live="prometricStatus" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 outline-none focus:border-[#bda065] focus:ring-2 focus:ring-[#bda065]/10 font-medium text-gray-600">
                                        <option value="">حالة Prometric (الكل)</option>
                                        <option value="مجتاز (سعودي)">مجتاز (سعودي)</option>
                                        <option value="مجتاز (دولة أخرى)">مجتاز (دولة أخرى)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-[#0a3d62] mb-3">سنوات الخبرة</label>
                            <select wire:model.live="experience" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 outline-none focus:border-[#bda065] focus:ring-2 focus:ring-[#bda065]/10 font-medium text-gray-600">
                                <option value="">أي خبرة</option>
                                <option value="0-2">حديث (0 - 2 سنوات)</option>
                                <option value="3-5">متوسط (3 - 5 سنوات)</option>
                                <option value="6-10">متقدم (6 - 10 سنوات)</option>
                                <option value="11+">خبير (أكثر من 10 سنوات)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-[#0a3d62] mb-3">التوفر للمباشرة</label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" wire:model.live="noticePeriod" value="جاهز فوراً" class="w-5 h-5 border-gray-300 text-[#bda065] focus:ring-[#bda065]/20 cursor-pointer">
                                    <span class="text-sm text-gray-600 font-medium group-hover:text-[#0a3d62] transition-colors">جاهز فوراً (بدون إنذار)</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" wire:model.live="noticePeriod" value="شهر واحد" class="w-5 h-5 border-gray-300 text-[#bda065] focus:ring-[#bda065]/20 cursor-pointer">
                                    <span class="text-sm text-gray-600 font-medium group-hover:text-[#0a3d62] transition-colors">خلال شهر واحد</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" wire:model.live="noticePeriod" value="شهرين فأكثر" class="w-5 h-5 border-gray-300 text-[#bda065] focus:ring-[#bda065]/20 cursor-pointer">
                                    <span class="text-sm text-gray-600 font-medium group-hover:text-[#0a3d62] transition-colors">شهرين فأكثر</span>
                                </label>
                            </div>
                        </div>

                    </div> --}}


                    <div class="space-y-6">

                        <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-50 space-y-4">
                            <div>
                                <label class="block text-sm font-bold text-[#0a3d62] mb-2">الدرجة الوظيفية</label>
                                <select wire:model.live="selectedTitle" class="w-full text-sm bg-white border border-gray-200 rounded-xl px-3 py-2.5 outline-none focus:border-[#bda065] focus:ring-2 focus:ring-[#bda065]/10 font-bold text-[#0a3d62] shadow-sm">
                                    <option value="">جميع الدرجات</option>
                                    @foreach($tabs[$selectedTab]['titles'] as $title)
                                        <option value="{{ $title }}">{{ $title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-[#0a3d62] mb-2">التخصص العام</label>
                                <select wire:model.live="selectedSpecialty" class="w-full text-sm bg-white border border-gray-200 rounded-xl px-3 py-2.5 outline-none focus:border-[#bda065] focus:ring-2 focus:ring-[#bda065]/10 font-bold text-[#0a3d62] shadow-sm">
                                    <option value="">جميع التخصصات</option>
                                    @foreach($tabs[$selectedTab]['specialties'] as $specialty)
                                        <option value="{{ $specialty }}">{{ $specialty }}</option>
                                    @endforeach
                                </select>
                            </div>
                            </div>
                        
                        <div>
                            <label class="block text-sm font-bold text-[#0a3d62] mb-3">دولة العمل المستهدفة</label>
                            <div class="space-y-2">
                                @php $countries = ['السعودية', 'الكويت', 'الإمارات', 'قطر', 'عمان', 'البحرين']; @endphp
                                @foreach($countries as $country)
                                    <label class="flex items-center gap-3 cursor-pointer group">
                                        <input type="checkbox" wire:model.live="selectedCountries" value="{{ $country }}" class="w-5 h-5 rounded border-gray-300 text-[#bda065] focus:ring-[#bda065]/20 cursor-pointer">
                                        <span class="text-sm text-gray-600 font-medium group-hover:text-[#0a3d62] transition-colors">{{ $country }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-[#0a3d62] mb-3">الجنسية</label>
                            <select wire:model.live="selectedNationality" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 outline-none focus:border-[#bda065] focus:ring-2 focus:ring-[#bda065]/10 font-medium text-gray-600">
                                <option value="">جميع الجنسيات</option>
                                @foreach($availableNationalities as $nationality)
                                    <option value="{{ $nationality }}">{{ $nationality }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-[#0a3d62] mb-3">التراخيص والتوثيق</label>
                            <div class="space-y-4">
                                
                                <div class="bg-gray-50 p-3 rounded-xl border border-gray-100">
                                    <span class="block text-xs font-bold text-gray-500 mb-2">يمتلك ترخيص:</span>
                                    <div class="flex flex-wrap gap-2">
                                        @php $licenses = ['الهيئة السعودية', 'DHA (دبي)', 'MOH (الإمارات)', 'MOH (الكويت)', 'NHRA (البحرين)', 'QCHP (قطر)']; @endphp
                                        @foreach($licenses as $license)
                                            <label class="relative group cursor-pointer">
                                                <input type="checkbox" wire:model.live="selectedLicenses" value="{{ $license }}" class="peer hidden">
                                                <div class="px-2 py-1 rounded border border-gray-200 bg-white text-[10px] font-bold text-gray-500 transition-all peer-checked:bg-[#0a3d62] peer-checked:text-white peer-checked:border-[#0a3d62] hover:border-[#bda065]">
                                                    {{ $license }}
                                                </div>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-2">
                                    <select wire:model.live="dataflowStatus" class="w-full text-xs bg-white border border-gray-200 rounded-lg px-2 py-2 outline-none focus:border-[#bda065] text-gray-600">
                                        <option value="">DataFlow (الكل)</option>
                                        <option value="مكتمل وجاهز">مكتمل</option>
                                        <option value="قيد الإجراء">قيد الإجراء</option>
                                    </select>
                                    <select wire:model.live="prometricStatus" class="w-full text-xs bg-white border border-gray-200 rounded-lg px-2 py-2 outline-none focus:border-[#bda065] text-gray-600">
                                        <option value="">Prometric (الكل)</option>
                                        <option value="مجتاز (سعودي)">مجتاز (سعودي)</option>
                                        <option value="مجتاز (دولة أخرى)">مجتاز (دولة أخرى)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-[#0a3d62] mb-3">سنوات الخبرة</label>
                            <select wire:model.live="experience" class="w-full text-sm bg-gray-50 border border-gray-200 rounded-xl px-3 py-2.5 outline-none focus:border-[#bda065] focus:ring-2 focus:ring-[#bda065]/10 font-medium text-gray-600">
                                <option value="">أي خبرة</option>
                                <option value="0-2">حديث (0 - 2 سنوات)</option>
                                <option value="3-5">متوسط (3 - 5 سنوات)</option>
                                <option value="6-10">متقدم (6 - 10 سنوات)</option>
                                <option value="11+">خبير (أكثر من 10 سنوات)</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-bold text-[#0a3d62] mb-3">التوفر للمباشرة</label>
                            <div class="space-y-2">
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" wire:model.live="noticePeriod" value="جاهز فوراً" class="w-5 h-5 border-gray-300 text-[#bda065] focus:ring-[#bda065]/20 cursor-pointer">
                                    <span class="text-sm text-gray-600 font-medium group-hover:text-[#0a3d62] transition-colors">جاهز فوراً (بدون إنذار)</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" wire:model.live="noticePeriod" value="شهر واحد" class="w-5 h-5 border-gray-300 text-[#bda065] focus:ring-[#bda065]/20 cursor-pointer">
                                    <span class="text-sm text-gray-600 font-medium group-hover:text-[#0a3d62] transition-colors">خلال شهر واحد</span>
                                </label>
                                <label class="flex items-center gap-3 cursor-pointer group">
                                    <input type="radio" wire:model.live="noticePeriod" value="شهرين فأكثر" class="w-5 h-5 border-gray-300 text-[#bda065] focus:ring-[#bda065]/20 cursor-pointer">
                                    <span class="text-sm text-gray-600 font-medium group-hover:text-[#0a3d62] transition-colors">شهرين فأكثر</span>
                                </label>
                            </div>
                        </div>
                    </div>



                </div>
            </div>


            


            <div class="flex-1 flex flex-col min-w-0">
                
                <div class="bg-gradient-to-r from-[#0a3d62] to-[#0d4e7d] p-1.5 rounded-[1.25rem] mb-6 shadow-xl relative overflow-hidden group">
                    <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#bda065 1px, transparent 1px); background-size: 15px 15px;"></div>
                    
                    <div class="bg-white rounded-xl p-2 md:p-3 flex flex-col md:flex-row items-center relative z-10 gap-3">
                        <div class="flex items-center gap-3 px-4 w-full">
                            
                            <div class="w-10 h-10 rounded-full bg-blue-50 flex items-center justify-center shrink-0 border border-blue-100">
                                <svg class="w-5 h-5 text-[#bda065] animate-pulse" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            
                            <input 
                                type="text" 
                                wire:model="aiSearchQuery" 
                                wire:keydown.enter="performSmartSearch"
                                placeholder="صف طلبك بدقة... مثال: (أخصائي أطفال خبرة 5 سنوات سوري بالرياض)" 
                                class="w-full bg-transparent border-none outline-none text-sm font-black text-[#0a3d62] placeholder-gray-400 py-2.5"
                            >
                        </div>
                        <button 
                            wire:click="performSmartSearch" 
                            wire:loading.attr="disabled"
                            class="w-full md:w-auto bg-[#0a3d62] text-white px-8 py-3.5 rounded-lg font-black hover:bg-[#082d49] transition-all shrink-0 flex items-center justify-center gap-2 shadow-md hover:shadow-lg disabled:opacity-70 group/btn"
                        >
                            <span wire:loading.remove wire:target="performSmartSearch">بحث ذكي</span>
                            <svg wire:loading.remove wire:target="performSmartSearch" class="w-4 h-4 text-[#bda065] group-hover/btn:translate-x-1 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                            <svg wire:loading wire:target="performSmartSearch" class="animate-spin h-4 w-4 text-[#bda065]" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            <span wire:loading wire:target="performSmartSearch" class="text-[#bda065]">جاري التحليل...</span>
                        </button>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-2 mb-6 overflow-x-auto custom-scrollbar flex gap-2">
                    
                    @foreach($tabs as $key => $data)
                        <button 
                            wire:click="setTab('{{ $key }}')"
                            class="flex items-center gap-2 px-5 py-3 rounded-xl font-bold text-sm whitespace-nowrap transition-all duration-300
                            {{ $selectedTab === $key 
                                ? 'bg-[#0a3d62] text-white shadow-md' 
                                : 'bg-transparent text-gray-500 hover:bg-gray-50 hover:text-[#0a3d62]' }}"
                        >
                            <span class="text-lg">{{ $data['icon'] }}</span>
                            {{ $data['label'] }}
                        </button>
                    @endforeach
                </div>

                <div class="flex justify-between items-center mb-6 px-2">
                    <p class="text-sm font-bold text-gray-500">
                        عرض <span class="text-[#0a3d62] font-black mx-1">{{ $candidates->total() }}</span> سيرة ذاتية عمياء
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 mb-8">
    
                    @forelse($candidates as $candidate)
                        {{-- <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm hover:shadow-xl hover:border-[#bda065]/30 transition-all duration-300 flex flex-col h-full relative group transform hover:-translate-y-1">
                            
                            <div class="flex justify-between items-start mb-4">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-black text-gray-400 tracking-widest uppercase mb-1">الرمز المرجعي</span>
                                    <span class="text-sm font-black text-[#0a3d62] bg-blue-50 px-2 py-1 rounded-lg">#{{ $candidate->candidate_code }}</span>
                                </div>
                                
                                <label class="relative flex items-center justify-center cursor-pointer">
                                    <input type="checkbox" wire:model.live="selectedCandidatesForInterview" value="{{ $candidate->id }}" class="candidate-checkbox peer sr-only">
                                    <div class="w-6 h-6 rounded-md border-2 border-gray-200 peer-checked:bg-[#bda065] peer-checked:border-[#bda065] transition-all flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                </label>
                            </div>

                            <div class="mb-5">
                                <h3 class="text-lg font-black text-gray-800 leading-tight mb-1 line-clamp-2" title="{{ $candidate->general_specialty }}">
                                    {{ $candidate->general_specialty }}
                                </h3>
                                <p class="text-xs text-gray-500 font-medium mb-3 line-clamp-1">{{ $candidate->sub_specialty ?? $candidate->professional_title }}</p>
                                
                                <div class="flex items-center gap-2 text-[#0a3d62] font-black text-sm bg-gray-50 w-max px-3 py-1.5 rounded-xl">
                                    <svg class="w-4 h-4 text-[#bda065]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    خبرة {{ $candidate->years_of_experience }} سنوات
                                </div>
                            </div>

                            <div class="flex flex-wrap gap-2 mb-6 mt-auto">
                                @if($candidate->dataflow_status == 'مكتمل وجاهز')
                                    <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 border border-green-100 px-2 py-1 rounded-lg text-[10px] font-bold">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        DataFlow جاهز
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 bg-gray-50 text-gray-500 border border-gray-200 px-2 py-1 rounded-lg text-[10px] font-bold">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        DataFlow {{ $candidate->dataflow_status }}
                                    </span>
                                @endif

                                @if(str_contains($candidate->prometric_status, 'مجتاز'))
                                    <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 border border-green-100 px-2 py-1 rounded-lg text-[10px] font-bold">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                        Prometric مجتاز
                                    </span>
                                @endif

                                <span class="inline-flex items-center gap-1 {{ $candidate->notice_period == 'جاهز فوراً' ? 'bg-blue-50 text-blue-700 border-blue-100' : 'bg-orange-50 text-orange-700 border-orange-100' }} px-2 py-1 rounded-lg text-[10px] font-bold">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                    {{ $candidate->notice_period }}
                                </span>
                            </div>

                            <div class="flex items-center justify-between border-t border-gray-100 pt-4">
                                <div class="flex flex-col">
                                    <span class="text-[9px] text-gray-400 font-bold mb-1">الوجهة المستهدفة:</span>
                                    <div class="flex gap-1 flex-wrap max-w-[120px]">
                                        @php 
                                            $targets = is_string($candidate->target_countries) ? json_decode($candidate->target_countries, true) : $candidate->target_countries;
                                            $targets = $targets ?? [];
                                        @endphp
                                        @foreach(array_slice($targets, 0, 2) as $country)
                                            <span class="text-[10px] font-bold text-[#0a3d62] bg-gray-100 px-1.5 py-0.5 rounded">{{ $country }}</span>
                                        @endforeach
                                        @if(count($targets) > 2)
                                            <span class="text-[10px] font-bold text-gray-400 bg-gray-50 px-1.5 py-0.5 rounded">+{{ count($targets) - 2 }}</span>
                                        @endif
                                    </div>
                                </div>

                                <button wire:click="showCandidateDetails({{ $candidate->id }})" class="flex items-center gap-2 bg-gray-50 hover:bg-[#0a3d62] text-gray-600 hover:text-white px-4 py-2 rounded-xl text-xs font-black transition-colors duration-300 group/btn">
                                    <svg wire:loading.remove wire:target="showCandidateDetails({{ $candidate->id }})" class="w-4 h-4 text-gray-400 group-hover/btn:text-[#bda065] transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg wire:loading wire:target="showCandidateDetails({{ $candidate->id }})" class="w-4 h-4 animate-spin text-[#bda065]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    التفاصيل
                                </button>
                            </div>

                        </div> --}}
                        <div class="bg-white rounded-[24px] p-5 border border-gray-100 shadow-sm hover:shadow-2xl hover:shadow-[#0a3d62]/5 hover:border-[#bda065]/40 transition-all duration-300 flex flex-col h-full relative group transform hover:-translate-y-1">
    
                            <div class="flex justify-between items-center mb-4">
                                <span class="text-xs font-black text-[#0a3d62] bg-gray-50 border border-gray-100 px-3 py-1.5 rounded-lg tracking-wide">
                                    #{{ $candidate->candidate_code }}
                                </span>
                                
                                <label class="relative flex items-center justify-center cursor-pointer">
                                    <input type="checkbox" wire:model.live="selectedCandidatesForInterview" value="{{ $candidate->id }}" class="candidate-checkbox peer sr-only">
                                    <div class="w-6 h-6 rounded border-2 border-gray-200 peer-checked:bg-[#bda065] peer-checked:border-[#bda065] transition-all flex items-center justify-center shadow-sm">
                                        <svg class="w-4 h-4 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                    </div>
                                </label>
                            </div>

                            <div class="mb-4">
                                <span class="inline-block text-[10px] font-black text-[#bda065] bg-[#bda065]/10 border border-[#bda065]/20 px-2.5 py-1 rounded-md mb-2">
                                    {{ $candidate->professional_title }}
                                </span>
                                <h3 class="text-lg font-black text-gray-800 leading-tight mb-1 line-clamp-1" title="{{ $candidate->general_specialty }}">
                                    {{ $candidate->general_specialty }}
                                </h3>
                                @if($candidate->sub_specialty && $candidate->sub_specialty !== 'غير محدد')
                                    <p class="text-xs font-bold text-gray-500 line-clamp-1" title="{{ $candidate->sub_specialty }}">
                                        <span class="text-gray-300 ml-1">↳</span> {{ $candidate->sub_specialty }}
                                    </p>
                                @endif
                            </div>

                            @php
                                // معالجة مصفوفة المهارات الذكية
                                $skills = is_string($candidate->extracted_skills) ? json_decode($candidate->extracted_skills, true) : $candidate->extracted_skills;
                                $skills = is_array($skills) ? array_filter($skills) : []; // إزالة القيم الفارغة
                                $topSkills = array_slice($skills, 0, 3); // عرض أول 3 مهارات فقط
                                $remainingSkillsCount = count($skills) - count($topSkills);
                            @endphp

                            @if(count($topSkills) > 0)
                                <div class="mb-5 bg-gradient-to-r from-gray-50 to-white p-2 rounded-xl border border-gray-100/50">
                                    <div class="flex flex-wrap items-center gap-1.5">
                                        <span class="flex items-center justify-center text-purple-500" title="مهارات مستخرجة آلياً من السيرة الذاتية">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                                        </span>
                                        
                                        @foreach($topSkills as $skill)
                                            <span class="text-[9px] font-bold text-gray-600 bg-white border border-gray-200 px-2 py-1 rounded shadow-sm whitespace-nowrap">{{ $skill }}</span>
                                        @endforeach
                                        
                                        @if($remainingSkillsCount > 0)
                                            <span class="text-[9px] font-bold text-[#0a3d62] bg-blue-50 px-2 py-1 rounded whitespace-nowrap">+{{ $remainingSkillsCount }}</span>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="mb-5 h-[34px]"></div>
                            @endif

                            <div class="grid grid-cols-2 gap-2 mb-4 mt-auto">
                                <div class="flex items-center gap-2 bg-blue-50/50 p-2.5 rounded-xl border border-blue-100">
                                    <div class="w-7 h-7 rounded-full bg-white flex items-center justify-center text-[#0a3d62] shadow-sm shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                    </div>
                                    <div class="flex flex-col overflow-hidden">
                                        <span class="text-[9px] text-gray-500 font-bold">الخبرة العملية</span>
                                        <span class="text-[11px] font-black text-[#0a3d62] truncate">{{ $candidate->years_of_experience }} سنوات</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 {{ $candidate->notice_period == 'جاهز فوراً' ? 'bg-green-50/50 border-green-100' : 'bg-orange-50/50 border-orange-100' }} p-2.5 rounded-xl border">
                                    <div class="w-7 h-7 rounded-full bg-white flex items-center justify-center {{ $candidate->notice_period == 'جاهز فوراً' ? 'text-green-600' : 'text-orange-500' }} shadow-sm shrink-0">
                                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    </div>
                                    <div class="flex flex-col overflow-hidden">
                                        <span class="text-[9px] text-gray-500 font-bold">فترة المباشرة</span>
                                        <span class="text-[10px] font-black {{ $candidate->notice_period == 'جاهز فوراً' ? 'text-green-700' : 'text-orange-700' }} truncate" title="{{ $candidate->notice_period }}">{{ $candidate->notice_period == 'جاهز فوراً' ? 'فوراً (بدون إنذار)' : $candidate->notice_period }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-center justify-between border-t border-gray-100 pt-4 mt-2">
                                <div class="flex gap-2">
                                    @if($candidate->dataflow_status == 'مكتمل وجاهز')
                                        <div class="w-8 h-8 rounded-full bg-green-50 text-green-600 flex items-center justify-center border border-green-100 tooltip-trigger" title="DataFlow مكتمل">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                    @endif
                                    @if(str_contains($candidate->prometric_status, 'مجتاز'))
                                        <div class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center border border-blue-100 tooltip-trigger" title="Prometric مجتاز">
                                            <span class="text-[10px] font-black">PRO</span>
                                        </div>
                                    @endif
                                </div>

                                <button wire:click="showCandidateDetails({{ $candidate->id }})" class="flex items-center gap-2 bg-gray-50 hover:bg-[#0a3d62] text-[#0a3d62] hover:text-white px-4 py-2 rounded-xl text-xs font-black transition-colors duration-300 group/btn border border-gray-200 hover:border-[#0a3d62]">
                                    <svg wire:loading.remove wire:target="showCandidateDetails({{ $candidate->id }})" class="w-4 h-4 text-[#bda065]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    <svg wire:loading wire:target="showCandidateDetails({{ $candidate->id }})" class="w-4 h-4 animate-spin text-[#bda065]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    التفاصيل الكاملة
                                </button>
                            </div>

                        </div>
                    @empty
                        <div class="col-span-1 md:col-span-2 xl:col-span-3 bg-gradient-to-br from-[#0a3d62] to-[#0d4e7d] rounded-[24px] p-8 md:p-12 text-center shadow-xl relative overflow-hidden">
                            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#bda065 1px, transparent 1px); background-size: 20px 20px;"></div>
                            
                            <div class="relative z-10 flex flex-col items-center">
                                <div class="w-20 h-20 bg-white/10 rounded-full flex items-center justify-center text-gold mb-6 shadow-inner border border-white/10">
                                    <svg class="w-10 h-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"/></svg>
                                </div>
                                
                                <h3 class="text-2xl md:text-3xl font-black text-white mb-3">لم تجد الكفاءة المطلوبة؟</h3>
                                <p class="text-gray-300 text-sm md:text-base max-w-lg mx-auto mb-8 leading-relaxed">
                                    قاعدة بياناتنا تتحدث يومياً، ولكن بعض التخصصات الدقيقة تتطلب "استقطاباً موجهاً" (Headhunting). دع فريق روافد يبحث لك خارج المنصة ويجلب لك أفضل المرشحين خلال 72 ساعة.
                                </p>
                                
                                <div class="flex flex-col sm:flex-row gap-4 w-full justify-center max-w-md mx-auto">
                                    <button wire:click="clearFilters" class="bg-white/10 text-white border border-white/20 hover:bg-white/20 px-6 py-3.5 rounded-xl font-bold transition-colors">
                                        مسح الفلاتر والمحاولة مجدداً
                                    </button>
                                    <a href="https://wa.me/249909590325?text=مرحباً، أبحث عن تخصص طبي دقيق ولم أجده في الكتالوج." target="_blank" class="bg-gold text-navy hover:bg-goldlight hover:shadow-lg hover:shadow-gold/20 px-6 py-3.5 rounded-xl font-black transition-all flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                        اطلب استقطاب مخصص الآن
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforelse

                </div>

                <div class="mt-auto">
                    {{ $candidates->links() }}
                </div>

            </div>
        </div>
    </div>


    {{-- modals --}}
    {{-- <div id="slide-backdrop" class="fixed inset-0 bg-[#0a3d62]/60 backdrop-blur-sm z-40 hidden transition-opacity duration-300 opacity-0" onclick="closeCandidatePanel()"></div>

    <div id="slide-panel" class="fixed top-0 left-0 h-full w-full max-w-2xl bg-[#f8fafc] shadow-2xl z-50 transform -translate-x-full transition-transform duration-500 ease-in-out flex flex-col" dir="rtl">

        @if($selectedCandidate)
            <div class="bg-white px-6 py-4 border-b border-gray-100 flex items-center justify-between shrink-0">
                <div class="flex items-center gap-4">
                    <button onclick="closeCandidatePanel()" class="w-10 h-10 rounded-full bg-gray-50 hover:bg-red-50 text-gray-400 hover:text-red-500 flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-sm font-black text-[#0a3d62] bg-blue-50 px-2 py-0.5 rounded-lg">#{{ $selectedCandidate->candidate_code }}</span>
                            <span class="flex h-2 w-2 relative">
                                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                            </span>
                            <span class="text-[10px] text-green-600 font-bold">متاح للتوظيف</span>
                        </div>
                        <h2 class="text-lg font-black text-gray-800 line-clamp-1">{{ $selectedCandidate->general_specialty }}</h2>
                    </div>
                </div>

                <label class="hidden sm:flex relative items-center gap-2 bg-gray-50 hover:bg-gray-100 text-[#0a3d62] px-4 py-2 rounded-xl text-xs font-bold transition-colors shadow-sm cursor-pointer border border-gray-200">
                    <input type="checkbox" wire:model.live="selectedCandidatesForInterview" value="{{ $selectedCandidate->id }}" class="peer sr-only">
                    <div class="w-4 h-4 rounded border-2 border-gray-300 peer-checked:bg-[#bda065] peer-checked:border-[#bda065] flex items-center justify-center transition-all">
                        <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    تحديد للمقابلة
                </label>
            </div>

            <div class="bg-white px-6 border-b border-gray-100 flex gap-6 shrink-0">
                <button onclick="switchPanelTab('overview')" id="tab-btn-overview" class="py-4 text-sm font-black text-[#0a3d62] border-b-2 border-[#0a3d62] transition-colors">
                    النظرة العامة
                </button>
                <button onclick="switchPanelTab('cv')" id="tab-btn-cv" class="py-4 text-sm font-bold text-gray-400 border-b-2 border-transparent hover:text-[#0a3d62] transition-colors">
                    السيرة الذاتية (PDF)
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6 custom-scrollbar">
                
                <div id="tab-content-overview" class="block space-y-6">
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm text-center">
                            <span class="block text-[10px] font-bold text-gray-400 mb-1">الخبرة</span>
                            <span class="block text-lg font-black text-[#0a3d62]">{{ $selectedCandidate->years_of_experience }} سنة</span>
                        </div>
                        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm text-center">
                            <span class="block text-[10px] font-bold text-gray-400 mb-1">الجنسية</span>
                            <span class="block text-lg font-black text-[#0a3d62]">{{ $selectedCandidate->nationality }}</span>
                        </div>
                        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm text-center">
                            <span class="block text-[10px] font-bold text-gray-400 mb-1">الإقامة الحالية</span>
                            <span class="block text-[13px] font-black text-[#0a3d62] mt-2">{{ $selectedCandidate->current_location }}</span>
                        </div>
                        <div class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm text-center">
                            <span class="block text-[10px] font-bold text-gray-400 mb-1">الدرجة</span>
                            <span class="block text-[12px] font-black text-[#0a3d62] mt-2">{{ $selectedCandidate->professional_title }}</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-5 py-3 border-b border-gray-50 bg-gray-50/50">
                            <h3 class="font-bold text-[#0a3d62] text-sm">التفاصيل المهنية والتراخيص</h3>
                        </div>
                        <div class="p-5 space-y-4">
                            <div class="grid grid-cols-3 border-b border-dashed border-gray-100 pb-3">
                                <span class="col-span-1 text-xs font-bold text-gray-400">التخصص الدقيق</span>
                                <span class="col-span-2 text-sm font-bold text-gray-800">{{ $selectedCandidate->sub_specialty ?? 'غير محدد' }}</span>
                            </div>
                            <div class="grid grid-cols-3 border-b border-dashed border-gray-100 pb-3">
                                <span class="col-span-1 text-xs font-bold text-gray-400">حالة DataFlow</span>
                                <span class="col-span-2 text-sm font-bold {{ $selectedCandidate->dataflow_status == 'مكتمل وجاهز' ? 'text-green-600' : 'text-gray-600' }}">
                                    {{ $selectedCandidate->dataflow_status }}
                                </span>
                            </div>
                            <div class="grid grid-cols-3 border-b border-dashed border-gray-100 pb-3">
                                <span class="col-span-1 text-xs font-bold text-gray-400">حالة Prometric</span>
                                <span class="col-span-2 text-sm font-bold {{ str_contains($selectedCandidate->prometric_status, 'مجتاز') ? 'text-green-600' : 'text-gray-600' }}">
                                    {{ $selectedCandidate->prometric_status }}
                                </span>
                            </div>
                            <div class="grid grid-cols-3">
                                <span class="col-span-1 text-xs font-bold text-gray-400">التراخيص الحالية</span>
                                <div class="col-span-2 flex flex-wrap gap-2">
                                    @php 
                                        $licenses = is_string($selectedCandidate->current_licenses) ? json_decode($selectedCandidate->current_licenses, true) : $selectedCandidate->current_licenses;
                                    @endphp
                                    @if($licenses && count($licenses) > 0)
                                        @foreach($licenses as $license)
                                            <span class="text-[10px] font-bold text-[#0a3d62] bg-gray-100 px-2 py-1 rounded" dir="ltr">{{ $license }}</span>
                                        @endforeach
                                    @else
                                        <span class="text-xs text-gray-400">لا يوجد</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="tab-content-cv" class="hidden h-full min-h-[500px]">
                    <div class="bg-white p-2 rounded-2xl border border-gray-100 shadow-sm h-full flex flex-col">
                        @if($selectedCandidate->blind_cv_path)
                            <div class="flex justify-between items-center p-3 mb-2 bg-gray-50 rounded-xl">
                                <span class="text-xs font-bold text-gray-500 flex items-center gap-2">
                                    <svg class="w-4 h-4 text-red-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/></svg>
                                    السيرة الذاتية العمياء (للمستشفيات)
                                </span>
                                <a href="{{ Storage::url($selectedCandidate->blind_cv_path) }}" target="_blank" class="text-[10px] font-bold text-[#0a3d62] bg-white border border-gray-200 px-3 py-1.5 rounded-lg hover:bg-gray-50 transition-colors">فتح في نافذة</a>
                            </div>
                            <iframe src="{{ Storage::url($selectedCandidate->blind_cv_path) }}" class="w-full flex-1 rounded-xl border border-gray-100" title="السيرة الذاتية"></iframe>
                        @else
                            <div class="flex-1 flex flex-col items-center justify-center text-gray-400">
                                <svg class="w-16 h-16 mb-4 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <p class="font-bold text-sm">ملف السيرة الذاتية غير متوفر حالياً</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        @else
            <div class="flex-1 flex items-center justify-center">
                <svg class="animate-spin h-10 w-10 text-[#bda065]" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
            </div>
        @endif
    </div> --}}

    <div id="slide-backdrop" class="fixed inset-0 bg-[#0a3d62]/60 backdrop-blur-md z-40 hidden transition-opacity duration-300 opacity-0" onclick="closeCandidatePanel()"></div>

    <div id="slide-panel" class="fixed top-0 left-0 h-full w-full max-w-[700px] bg-[#f4f7f6] shadow-2xl z-50 transform -translate-x-full transition-transform duration-500 ease-in-out flex flex-col" dir="rtl">

        @if($selectedCandidate)
            <div class="bg-white px-6 py-5 border-b border-gray-100 flex items-center justify-between shrink-0 shadow-sm z-10">
                <div class="flex items-center gap-4">
                    <button onclick="closeCandidatePanel()" class="w-10 h-10 rounded-full bg-gray-50 hover:bg-red-50 text-gray-400 hover:text-red-500 flex items-center justify-center transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                    
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-black text-[#0a3d62] bg-blue-50 px-2.5 py-1 rounded-lg border border-blue-100 tracking-widest">#{{ $selectedCandidate->candidate_code }}</span>
                            <span class="flex items-center gap-1.5 bg-green-50 text-green-700 px-2 py-1 rounded-md border border-green-100">
                                <span class="relative flex h-2 w-2">
                                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                  <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                                </span>
                                <span class="text-[10px] font-bold">متاح وجاهز</span>
                            </span>
                        </div>
                    </div>
                </div>

                <label class="relative flex items-center gap-2 bg-gradient-to-r from-gray-50 to-white hover:from-blue-50 hover:to-gray-50 text-[#0a3d62] px-5 py-2.5 rounded-xl text-xs font-bold transition-all shadow-sm border border-gray-200 cursor-pointer group">
                    <input type="checkbox" wire:model.live="selectedCandidatesForInterview" value="{{ $selectedCandidate->id }}" onchange="closeCandidatePanel()" class="peer sr-only">
                    <div class="w-4 h-4 rounded border-2 border-gray-300 peer-checked:bg-[#bda065] peer-checked:border-[#bda065] flex items-center justify-center transition-all group-hover:border-[#bda065]">
                        <svg class="w-3 h-3 text-white opacity-0 peer-checked:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    تحديد للمقابلة
                </label>
            </div>

            <div class="bg-white px-8 flex gap-8 shrink-0 border-b border-gray-200">
                <button onclick="switchPanelTab('overview')" id="tab-btn-overview" class="py-4 text-sm font-black text-[#0a3d62] border-b-[3px] border-[#0a3d62] transition-colors relative">
                    الملف الشامل
                </button>
                <button onclick="switchPanelTab('cv')" id="tab-btn-cv" class="py-4 text-sm font-bold text-gray-400 border-b-[3px] border-transparent hover:text-[#0a3d62] transition-colors relative flex items-center gap-2">
                    السيرة الذاتية (PDF)
                </button>
            </div>

            <div class="flex-1 overflow-y-auto custom-scrollbar relative">
                
                <div id="tab-content-overview" class="block p-6 md:p-8 space-y-6">
                    
                    <div class="text-center md:text-right">
                        <span class="inline-block text-xs font-black text-[#bda065] bg-[#bda065]/10 px-3 py-1 rounded-lg mb-2">
                            {{ $selectedCandidate->professional_title }}
                        </span>
                        <h2 class="text-2xl md:text-3xl font-black text-[#0a3d62] leading-tight mb-2">{{ $selectedCandidate->general_specialty }}</h2>
                        @if($selectedCandidate->sub_specialty && $selectedCandidate->sub_specialty !== 'غير محدد')
                            <p class="text-sm font-bold text-gray-500 bg-white inline-block px-4 py-1.5 rounded-full border border-gray-200 shadow-sm">
                                تخصص دقيق: <span class="text-gray-800">{{ $selectedCandidate->sub_specialty }}</span>
                            </p>
                        @endif
                    </div>

                    @php
                        $skills = is_string($selectedCandidate->extracted_skills) ? json_decode($selectedCandidate->extracted_skills, true) : $selectedCandidate->extracted_skills;
                        $skills = is_array($skills) ? array_filter($skills) : [];
                    @endphp
                    
                    @if(count($skills) > 0)
                        <div class="bg-gradient-to-br from-[#0a3d62] to-[#0d4e7d] rounded-[24px] p-6 shadow-lg shadow-blue-900/10 text-white relative overflow-hidden">
                            <div class="absolute top-0 left-0 w-full h-full opacity-10 pointer-events-none" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 20px 20px;"></div>
                            
                            <div class="relative z-10">
                                <div class="flex items-center gap-2 mb-4">
                                    <span class="flex items-center justify-center w-8 h-8 rounded-full bg-white/10 text-[#bda065]">
                                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"/></svg>
                                    </span>
                                    <h3 class="text-base font-black">البصمة السريرية والمهارات المتقدمة</h3>
                                </div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($skills as $skill)
                                        <span class="text-[11px] font-bold text-[#0a3d62] bg-white px-3 py-1.5 rounded-lg shadow-sm" dir="auto">{{ $skill }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm text-center">
                            <div class="w-10 h-10 mx-auto bg-blue-50 text-blue-600 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            </div>
                            <span class="block text-[11px] font-bold text-gray-400 mb-1">الخبرة العملية</span>
                            <span class="block text-xl font-black text-[#0a3d62]">{{ $selectedCandidate->years_of_experience }} <span class="text-sm">سنوات</span></span>
                        </div>
                        <div class="bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm text-center">
                            <div class="w-10 h-10 mx-auto bg-orange-50 text-orange-500 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <span class="block text-[11px] font-bold text-gray-400 mb-1">الجنسية</span>
                            <span class="block text-sm font-black text-[#0a3d62] mt-2">{{ $selectedCandidate->nationality }}</span>
                        </div>
                        <div class="bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm text-center">
                            <div class="w-10 h-10 mx-auto bg-purple-50 text-purple-500 rounded-full flex items-center justify-center mb-3">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            </div>
                            <span class="block text-[11px] font-bold text-gray-400 mb-1">الإقامة الحالية</span>
                            <span class="block text-sm font-black text-[#0a3d62] mt-2">{{ $selectedCandidate->current_location }}</span>
                        </div>
                        <div class="bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm text-center">
                            <div class="w-10 h-10 mx-auto {{ $selectedCandidate->notice_period == 'جاهز فوراً' ? 'bg-green-50 text-green-500' : 'bg-red-50 text-red-500' }} rounded-full flex items-center justify-center mb-3">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <span class="block text-[11px] font-bold text-gray-400 mb-1">المباشرة</span>
                            <span class="block text-[11px] font-black {{ $selectedCandidate->notice_period == 'جاهز فوراً' ? 'text-green-600' : 'text-red-600' }} mt-2">{{ $selectedCandidate->notice_period }}</span>
                        </div>
                    </div>

                    <div class="bg-white rounded-[24px] border border-gray-100 shadow-sm overflow-hidden">
                        <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between bg-gray-50/50">
                            <h3 class="font-black text-[#0a3d62] text-sm">التوثيقات والتراخيص الطبية</h3>
                            <svg class="w-5 h-5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                
                                <div>
                                    <span class="block text-[11px] font-bold text-gray-400 mb-3">التراخيص التي يمتلكها حالياً:</span>
                                    <div class="flex flex-col gap-3">
                                        @php 
                                            $licenses = is_string($selectedCandidate->current_licenses) ? json_decode($selectedCandidate->current_licenses, true) : $selectedCandidate->current_licenses;
                                        @endphp
                                        @if($licenses && count($licenses) > 0)
                                            @foreach($licenses as $license)
                                                <div class="flex items-center gap-2">
                                                    <div class="w-5 h-5 rounded-full bg-green-100 text-green-600 flex items-center justify-center shrink-0">
                                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                                                    </div>
                                                    <span class="text-sm font-bold text-gray-700" dir="ltr">{{ $license }}</span>
                                                </div>
                                            @endforeach
                                        @else
                                            <span class="text-xs font-bold text-gray-400 bg-gray-50 px-3 py-2 rounded-lg w-max">لا توجد تراخيص سابقة</span>
                                        @endif
                                    </div>
                                </div>

                                <div>
                                    <span class="block text-[11px] font-bold text-gray-400 mb-3">حالة الامتحانات والتوثيق:</span>
                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <span class="text-[10px] font-bold text-gray-400 block mb-1">DataFlow (توثيق الشهادات)</span>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold {{ $selectedCandidate->dataflow_status == 'مكتمل وجاهز' ? 'bg-green-50 text-green-700 border border-green-100' : 'bg-gray-100 text-gray-600' }}">
                                                @if($selectedCandidate->dataflow_status == 'مكتمل وجاهز') <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> @endif
                                                {{ $selectedCandidate->dataflow_status }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="text-[10px] font-bold text-gray-400 block mb-1">امتحان Prometric</span>
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-bold {{ str_contains($selectedCandidate->prometric_status, 'مجتاز') ? 'bg-blue-50 text-blue-700 border border-blue-100' : 'bg-gray-100 text-gray-600' }}">
                                                @if(str_contains($selectedCandidate->prometric_status, 'مجتاز')) <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg> @endif
                                                {{ $selectedCandidate->prometric_status }}
                                            </span>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-4 bg-white p-5 rounded-[20px] border border-gray-100 shadow-sm">
                        <span class="text-xs font-bold text-gray-400 shrink-0">يرغب بالعمل في:</span>
                        <div class="flex flex-wrap gap-2">
                            @php 
                                $targets = is_string($selectedCandidate->target_countries) ? json_decode($selectedCandidate->target_countries, true) : $selectedCandidate->target_countries;
                            @endphp
                            @if($targets && count($targets) > 0)
                                @foreach($targets as $country)
                                    <span class="text-xs font-bold text-[#0a3d62] bg-gray-50 border border-gray-200 px-3 py-1.5 rounded-lg">{{ $country }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>

                </div>

                <div id="tab-content-cv" class="hidden h-full min-h-[600px] p-6">
                    <div class="bg-white p-2 rounded-3xl border border-gray-200 shadow-sm h-full flex flex-col relative overflow-hidden">
                        @if($selectedCandidate->blind_cv_path)
                            <div class="flex justify-between items-center p-3 mb-2 bg-gray-50 rounded-2xl">
                                <span class="text-xs font-bold text-gray-600 flex items-center gap-2">
                                    <span class="w-8 h-8 rounded-full bg-red-100 text-red-500 flex items-center justify-center">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd"/></svg>
                                    </span>
                                    نسخة عمياء مطابقة لمعايير الخصوصية
                                </span>
                                <a href="{{ Storage::url($selectedCandidate->blind_cv_path) }}" target="_blank" class="text-[11px] font-bold text-white bg-[#0a3d62] px-4 py-2 rounded-xl hover:bg-[#082d49] transition-colors flex items-center gap-1.5 shadow-sm">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                    توسيع العرض
                                </a>
                            </div>
                            <iframe src="{{ Storage::url($selectedCandidate->blind_cv_path) }}#toolbar=0" class="w-full flex-1 rounded-2xl border border-gray-100 bg-gray-100" title="السيرة الذاتية"></iframe>
                        @else
                            <div class="flex-1 flex flex-col items-center justify-center text-gray-400 bg-gray-50 rounded-2xl">
                                <div class="w-20 h-20 bg-white rounded-full flex items-center justify-center shadow-sm mb-4">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                                <p class="font-black text-gray-500 mb-1">ملف السيرة الذاتية غير متوفر</p>
                                <p class="text-xs font-medium">جاري معالجة الملف أو أنه يتطلب مراجعة يدوية من الإدارة.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

        @else
            <div class="flex-1 flex flex-col items-center justify-center bg-[#f4f7f6]">
                <svg class="animate-spin h-12 w-12 text-[#bda065] mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                <p class="text-sm font-bold text-[#0a3d62] animate-pulse">جاري سحب الملف السري...</p>
            </div>
        @endif
    </div>


    {{-- <script>
        function openCandidatePanel() {
            const backdrop = document.getElementById('slide-backdrop');
            const panel = document.getElementById('slide-panel');
            backdrop.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                panel.classList.remove('-translate-x-full');
            }, 10);
            document.body.style.overflow = 'hidden';
        }

        function closeCandidatePanel() {
            const backdrop = document.getElementById('slide-backdrop');
            const panel = document.getElementById('slide-panel');
            backdrop.classList.add('opacity-0');
            panel.classList.add('-translate-x-full');
            setTimeout(() => {
                backdrop.classList.add('hidden');
            }, 300);
            document.body.style.overflow = 'auto';
        }

        function switchPanelTab(tabName) {
            const overviewBtn = document.getElementById('tab-btn-overview');
            const cvBtn = document.getElementById('tab-btn-cv');
            const overviewContent = document.getElementById('tab-content-overview');
            const cvContent = document.getElementById('tab-content-cv');

            if(tabName === 'overview') {
                overviewBtn.className = "py-4 text-sm font-black text-[#0a3d62] border-b-2 border-[#0a3d62] transition-colors";
                cvBtn.className = "py-4 text-sm font-bold text-gray-400 border-b-2 border-transparent hover:text-[#0a3d62] transition-colors";
                overviewContent.classList.remove('hidden');
                cvContent.classList.add('hidden');
            } else {
                cvBtn.className = "py-4 text-sm font-black text-[#0a3d62] border-b-2 border-[#0a3d62] transition-colors";
                overviewBtn.className = "py-4 text-sm font-bold text-gray-400 border-b-2 border-transparent hover:text-[#0a3d62] transition-colors";
                cvContent.classList.remove('hidden');
                overviewContent.classList.add('hidden');
            }
        }

        // الاستماع لحدث Livewire لفتح اللوحة
        window.addEventListener('open-slide-panel', event => {
            openCandidatePanel();
            switchPanelTab('overview');
        });
    </script> --}}



    <div id="bulk-action-bar" class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 shadow-[0_-20px_50px_-12px_rgba(10,61,98,0.15)] z-40 transform transition-transform duration-500 ease-out {{ count($selectedCandidatesForInterview) > 0 ? 'translate-y-0' : 'translate-y-full' }}" dir="rtl">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-4 flex flex-col sm:flex-row items-center justify-between gap-4">
            
            <div class="flex items-center gap-4 w-full sm:w-auto">
                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center relative shrink-0 border border-blue-100">
                    <svg class="w-6 h-6 text-[#0a3d62]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-black w-5 h-5 rounded-full flex items-center justify-center border-2 border-white shadow-sm">{{ count($selectedCandidatesForInterview) }}</span>
                </div>
                <div>
                    <h4 class="text-sm font-black text-[#0a3d62]">تم تحديد <span class="text-[#bda065]">{{ count($selectedCandidatesForInterview) }}</span> من الكفاءات</h4>
                    <p class="text-[11px] font-bold text-gray-400">جاهزون للمقابلة الفورية وتوقيع العقود.</p>
                </div>
            </div>

            <div class="flex items-center gap-3 w-full sm:w-auto">
                <button wire:click="clearSelections" class="text-xs font-bold text-gray-400 hover:text-red-500 px-3 py-2 transition-colors">
                    إلغاء التحديد
                </button>
                <button onclick="openInterviewModal()" class="flex-1 sm:flex-none bg-gradient-to-r from-[#bda065] to-[#9c814b] text-[#0a3d62] px-8 py-3.5 rounded-xl font-black text-sm hover:shadow-lg hover:shadow-[#bda065]/30 transition-all transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                    طلب تحديد مقابلات
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </button>
            </div>

        </div>
    </div>

    <div id="interview-modal" wire:ignore.self class="fixed inset-0 bg-[#0a3d62]/80 backdrop-blur-md z-50 hidden flex-col items-center justify-center p-4 opacity-0 transition-opacity duration-300" dir="rtl">
        <div id="interview-modal-content" wire:ignore.self class="bg-white w-full max-w-lg rounded-3xl shadow-2xl overflow-hidden transform scale-95 transition-transform duration-300">
            <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                <h3 class="font-black text-[#0a3d62] text-lg">تأكيد طلب المقابلات</h3>
                <button onclick="closeInterviewModal()" class="w-8 h-8 bg-white rounded-full border border-gray-200 text-gray-400 hover:text-red-500 hover:bg-red-50 flex items-center justify-center transition-colors">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <div class="p-6">
                <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 mb-6 flex gap-3">
                    <svg class="w-5 h-5 text-blue-500 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p class="text-xs text-[#0a3d62] font-bold leading-relaxed">
                        لقد قمت باختيار <span class="text-[#bda065] text-sm font-black mx-1">{{ count($selectedCandidatesForInterview) }}</span> مرشح. يرجى تزويدنا بالبيانات المبدئية وسيقوم مستشارنا بالتواصل معك لتزويدك بالسير الذاتية الكاملة.
                    </p>
                </div>

                <form wire:submit.prevent="submitInterviewRequest" class="space-y-4">
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1.5">اسم المنشأة الصحية / المستشفى <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="hospitalName" placeholder="مثال: مستشفى دلة" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-bold text-[#0a3d62] outline-none focus:border-[#bda065] focus:bg-white">
                        @error('hospitalName') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1.5">البريد الإلكتروني الرسمي <span class="text-red-500">*</span></label>
                        <input type="email" wire:model="hrEmail" placeholder="hr@hospital.com" dir="ltr" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-bold text-[#0a3d62] text-left outline-none focus:border-[#bda065] focus:bg-white">
                        @error('hrEmail') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-gray-500 mb-1.5">موعد المقابلة المفضل</label>
                        <select wire:model="interviewNotes" class="w-full bg-gray-50 border border-gray-200 rounded-xl px-4 py-3 text-sm font-bold text-gray-600 outline-none focus:border-[#bda065] focus:bg-white">
                            <option value="">اختر الموعد التقريبي...</option>
                            <option value="أقرب وقت ممكن">أقرب وقت ممكن</option>
                            <option value="الأسبوع القادم">الأسبوع القادم</option>
                            <option value="يحدد لاحقاً">يحدد لاحقاً مع المستشار</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="w-full bg-[#0a3d62] hover:bg-[#082d49] text-white px-6 py-4 rounded-xl font-black text-sm mt-4 transition-all shadow-md flex justify-center items-center gap-2">
                        <span wire:loading.remove wire:target="submitInterviewRequest">إرسال الطلب للإدارة</span>
                        <span wire:loading wire:target="submitInterviewRequest">جاري الإرسال...</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

    {{-- <script>
        function openInterviewModal() {
            const modal = document.getElementById('interview-modal');
            const modalContent = document.getElementById('interview-modal-content');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
            document.body.style.overflow = 'hidden';
        }

        function closeInterviewModal() {
            const modal = document.getElementById('interview-modal');
            const modalContent = document.getElementById('interview-modal-content');
            modal.classList.add('opacity-0');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
            document.body.style.overflow = 'auto';
        }

        window.addEventListener('close-interview-modal', event => {
            closeInterviewModal();
        });

        // ==========================================
        // ⚙️ التحكم في إفادة النجاح (Toast Logic)
        // ==========================================
        let toastTimeout;

        function showSuccessToast(message) {
            const toast = document.getElementById('success-toast');
            
            // إذا أرسلت رسالة مخصصة من السيرفر، نعرضها (اختياري)
            if(message) {
                document.getElementById('toast-title').innerText = message;
            }

            // إظهار التوست بحركة انسيابية
            toast.classList.remove('translate-x-[120%]', 'opacity-0');
            toast.classList.add('translate-x-0', 'opacity-100');

            // مسح أي مؤقت سابق لضمان عدم اختفائها مبكراً إذا ضغط المستخدم مرتين
            clearTimeout(toastTimeout);

            // إخفاء تلقائي بعد 4.5 ثواني
            toastTimeout = setTimeout(() => {
                closeSuccessToast();
            }, 4500);
        }

        function closeSuccessToast() {
            const toast = document.getElementById('success-toast');
            toast.classList.remove('translate-x-0', 'opacity-100');
            toast.classList.add('translate-x-[120%]', 'opacity-0');
        }

        // ==========================================
        // 🔗 الاستماع لإشارات Livewire (Events)
        // ==========================================
        window.addEventListener('close-interview-modal', event => {
            closeInterviewModal();
        });

        // هنا استبدلنا الـ alert() المزعج بـ Toast الأنيق!
        window.addEventListener('alert-success', event => {
            // event.detail.message تأتي من المتحكم في السطر: $this->dispatch('alert-success', message: '...');
            showSuccessToast(event.detail.message); 
        });
    </script> --}}



    <div id="success-toast" class="fixed top-6 right-6 z-[100] transform transition-all duration-500 translate-x-[120%] opacity-0 flex items-start gap-4 bg-white p-4 rounded-2xl shadow-[0_10px_40px_-10px_rgba(39,174,96,0.3)] border border-green-100 max-w-sm w-full" dir="rtl">
        <div class="relative w-10 h-10 rounded-full bg-green-50 flex items-center justify-center shrink-0">
            <span class="absolute inset-0 rounded-full border border-green-200 animate-[ping_2s_cubic-bezier(0,0,0.2,1)_infinite]"></span>
            <svg class="w-5 h-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
        </div>
        
        <div class="flex flex-col">
            <h4 class="text-sm font-black text-gray-800 mb-0.5" id="toast-title">تم إرسال الطلب بنجاح!</h4>
            <p class="text-xs font-medium text-gray-500 leading-relaxed" id="toast-message">شكراً لثقتكم. سيقوم مستشار التوظيف بالتواصل معكم قريباً لترتيب مواعيد المقابلات.</p>
        </div>

        <button onclick="closeSuccessToast()" class="mr-auto w-6 h-6 rounded-full bg-gray-50 hover:bg-gray-100 flex items-center justify-center text-gray-400 transition-colors">
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>




    <script>
        // دوال فتح وإغلاق لوحة تفاصيل الطبيب
        function openCandidatePanel() {
            const backdrop = document.getElementById('slide-backdrop');
            const panel = document.getElementById('slide-panel');
            backdrop.classList.remove('hidden');
            setTimeout(() => {
                backdrop.classList.remove('opacity-0');
                panel.classList.remove('-translate-x-full');
            }, 10);
            document.body.style.overflow = 'hidden'; // إيقاف التمرير
        }

        function closeCandidatePanel() {
            const backdrop = document.getElementById('slide-backdrop');
            const panel = document.getElementById('slide-panel');
            backdrop.classList.add('opacity-0');
            panel.classList.add('-translate-x-full');
            setTimeout(() => {
                backdrop.classList.add('hidden');
            }, 300);
            document.body.style.overflow = ''; // 🌟 استخدام قيمة فارغة أفضل من auto لتجنب التعارض
        }

        // التبديل بين التبويبات في اللوحة المنزلقة
        function switchPanelTab(tabName) {
            const overviewBtn = document.getElementById('tab-btn-overview');
            const cvBtn = document.getElementById('tab-btn-cv');
            const overviewContent = document.getElementById('tab-content-overview');
            const cvContent = document.getElementById('tab-content-cv');

            if(tabName === 'overview') {
                overviewBtn.className = "py-4 text-sm font-black text-[#0a3d62] border-b-2 border-[#0a3d62] transition-colors";
                cvBtn.className = "py-4 text-sm font-bold text-gray-400 border-b-2 border-transparent hover:text-[#0a3d62] transition-colors";
                overviewContent.classList.remove('hidden');
                cvContent.classList.add('hidden');
            } else {
                cvBtn.className = "py-4 text-sm font-black text-[#0a3d62] border-b-2 border-[#0a3d62] transition-colors";
                overviewBtn.className = "py-4 text-sm font-bold text-gray-400 border-b-2 border-transparent hover:text-[#0a3d62] transition-colors";
                cvContent.classList.remove('hidden');
                overviewContent.classList.add('hidden');
            }
        }

        // دوال فتح وإغلاق مودال تأكيد المقابلة
        function openInterviewModal() {
            const modal = document.getElementById('interview-modal');
            const modalContent = document.getElementById('interview-modal-content');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
                modalContent.classList.add('scale-100');
            }, 10);
            document.body.style.overflow = 'hidden'; // إيقاف التمرير
        }

        function closeInterviewModal() {
            const modal = document.getElementById('interview-modal');
            const modalContent = document.getElementById('interview-modal-content');
            modal.classList.add('opacity-0');
            modalContent.classList.remove('scale-100');
            modalContent.classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }, 300);
            document.body.style.overflow = ''; // 🌟 تحرير التمرير فوراً
        }

        // ==========================================
        // ⚙️ التحكم في إفادة النجاح (Toast Logic)
        // ==========================================
        let toastTimeout;

        function showSuccessToast(message) {
            const toast = document.getElementById('success-toast');
            
            if(message) {
                document.getElementById('toast-title').innerText = message;
            }

            toast.classList.remove('translate-x-[120%]', 'opacity-0');
            toast.classList.add('translate-x-0', 'opacity-100');

            clearTimeout(toastTimeout);

            toastTimeout = setTimeout(() => {
                closeSuccessToast();
            }, 4500);
        }

        function closeSuccessToast() {
            const toast = document.getElementById('success-toast');
            toast.classList.remove('translate-x-0', 'opacity-100');
            toast.classList.add('translate-x-[120%]', 'opacity-0');
        }

        // ==========================================
        // 🔗 الاستماع لإشارات Livewire (Events)
        // ==========================================
        
        window.addEventListener('open-slide-panel', event => {
            openCandidatePanel();
            switchPanelTab('overview');
        });

        window.addEventListener('close-interview-modal', event => {
            closeInterviewModal();
            // 🌟 إجراء وقائي إضافي: إجبار المتصفح على تحرير الشاشة بعد 100 ملي ثانية من إغلاق المودال بواسطة Livewire
            setTimeout(() => {
                document.body.style.overflow = '';
            }, 100);
        });

        window.addEventListener('alert-success', event => {
            showSuccessToast(event.detail.message); 
        });

        // 🌟 حارس أمان عالمي لـ Livewire:
        // في كل مرة يقوم Livewire بتحديث الصفحة (مثلاً عند البحث أو اختيار فلاتر)، يتأكد من تحرير الشاشة إذا لم يكن هناك مودال مفتوح
        document.addEventListener('livewire:navigated', () => {
            document.body.style.overflow = '';
        });
    </script>
</div>