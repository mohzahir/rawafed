<div class="font-sans antialiased text-gray-800 bg-[#f8f9fa] min-h-screen pb-24" dir="rtl">
    
    

    <div class="bg-white border-b border-gray-200 py-5 shadow-sm sticky top-0 z-30" x-data="{ showFilters: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            
            <div class="flex flex-col md:flex-row gap-4 items-center justify-between">
                
                <div class="flex items-center gap-4 w-full md:w-auto justify-between md:justify-start">
                    <h1 class="text-xl font-extrabold text-[#0a3d62] hidden lg:block">الكفاءات الطبية</h1>
                    <div class="text-sm font-bold text-[#bda065] bg-[#0a3d62]/5 px-4 py-2 rounded-xl border border-[#0a3d62]/10 whitespace-nowrap">
                        النتائج: <span class="text-[#0a3d62] text-lg">{{ $candidates->count() }}</span>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 w-full md:w-auto flex-grow max-w-3xl">
                    <div class="relative flex-grow">
                        <span class="absolute right-4 top-3 text-gray-400 text-sm">🔍</span>
                        <input type="text" wire:model.live.debounce.300ms="search" class="w-full pr-11 pl-4 py-2.5 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:ring-2 focus:ring-[#bda065]/50 focus:border-[#bda065] text-sm text-gray-700 font-medium transition shadow-inner" placeholder="ابحث بكود المرشح، التخصص، الكلمات المفتاحية...">
                    </div>
                    
                    <button @click="showFilters = !showFilters" class="flex-shrink-0 bg-[#0a3d62] hover:bg-[#082d49] text-white px-5 py-2.5 rounded-xl text-sm font-bold transition flex items-center gap-2 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        <span class="hidden sm:inline" x-text="showFilters ? 'إخفاء الفلاتر' : 'الفلاتر المتقدمة'"></span>
                    </button>
                </div>
            </div>
            
            <div x-show="showFilters" 
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 -translate-y-4"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-y-0"
                 x-transition:leave-end="opacity-0 -translate-y-4"
                 style="display: none;" 
                 class="mt-5 pt-5 border-t border-gray-100">
                
                <div class="flex justify-between items-center mb-4 px-1">
                    <span class="text-sm font-bold text-[#0a3d62]">تصفية النتائج بدقة:</span>
                    <button wire:click="resetFilters" class="text-xs font-bold text-red-500 hover:text-red-700 bg-red-50 px-3 py-1.5 rounded-lg transition flex items-center gap-1">
                        <span>↺</span> مسح الفلاتر
                    </button>
                </div>

                <div class="bg-gray-50 p-5 rounded-2xl border border-gray-100 flex flex-col gap-4 shadow-inner">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <select wire:model.live="titleFilter" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#bda065] text-sm text-gray-700 font-medium shadow-sm">
                            <option value="">التصنيف المهني (الكل)</option>
                            @foreach($dbTitles as $title) <option value="{{ $title }}">{{ $title }}</option> @endforeach
                        </select>

                        <select wire:model.live="specialtyFilter" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#bda065] text-sm text-gray-700 font-medium shadow-sm">
                            <option value="">التخصص العام (الكل)</option>
                            @foreach($dbSpecialties as $spec) <option value="{{ $spec }}">{{ $spec }}</option> @endforeach
                        </select>
                        
                        <select wire:model.live="nationalityFilter" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#bda065] text-sm text-gray-700 shadow-sm">
                            <option value="">الجنسية (الكل)</option>
                            @foreach($dbNationalities as $nat) <option value="{{ $nat }}">{{ $nat }}</option> @endforeach
                        </select>

                        <select wire:model.live="experienceFilter" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#bda065] text-sm text-gray-700 shadow-sm">
                            <option value="">الخبرة (الكل)</option>
                            <option value="1-3">1 - 3 سنوات</option>
                            <option value="4-7">4 - 7 سنوات</option>
                            <option value="8+">8+ سنوات</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <select wire:model.live="prometricFilter" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#bda065] text-sm text-gray-700 shadow-sm">
                            <option value="">البرومترك (الكل)</option>
                            <option value="مجتاز (سعودي)">مجتاز (سعودي)</option>
                            <option value="مجتاز (دولة أخرى)">مجتاز (دولة أخرى)</option>
                            <option value="غير مجتاز / لم أمتَحن">غير مجتاز</option>
                        </select>

                        <select wire:model.live="scfhsFilter" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#bda065] text-sm text-gray-700 shadow-sm">
                            <option value="">تصنيف الهيئة (الكل)</option>
                            <option value="مصنف وجاهز">مصنف وجاهز</option>
                            <option value="قيد التقييم (ممارس بلس)">قيد التقييم</option>
                            <option value="غير مصنف">غير مصنف</option>
                        </select>

                        <select wire:model.live="dataflowFilter" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#bda065] text-sm text-gray-700 shadow-sm">
                            <option value="">DataFlow (الكل)</option>
                            <option value="مكتمل وجاهز">مكتمل وجاهز</option>
                            <option value="قيد الإجراء (مقدم مسبقاً)">قيد الإجراء</option>
                        </select>

                        <select wire:model.live="noticePeriodFilter" class="w-full px-4 py-2.5 bg-white border border-gray-200 rounded-xl focus:outline-none focus:border-[#bda065] text-sm text-gray-700 shadow-sm">
                            <option value="">الاستعداد (الكل)</option>
                            <option value="جاهز فوراً">جاهز فوراً</option>
                            <option value="شهر واحد (30 يوم)">خلال شهر</option>
                            <option value="شهرين (60 يوم)">خلال شهرين</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 py-10">
        
        @if($candidates->isEmpty())
            <div class="text-center py-24 bg-white rounded-3xl border border-dashed border-gray-300 shadow-sm">
                <div class="text-7xl mb-5 opacity-40">🥼</div>
                <h3 class="text-2xl font-bold text-[#0a3d62]">لا يوجد مرشحين يطابقون معايير البحث</h3>
                <p class="text-gray-500 mt-2">حاول تخفيف الفلاتر أو البحث بكلمات مختلفة.</p>
                <button wire:click="resetFilters" class="mt-6 bg-[#bda065] text-white px-6 py-2.5 rounded-xl font-bold hover:bg-[#a68c58] transition">مسح الفلاتر</button>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($candidates as $candidate)
                    @php $isSelected = in_array($candidate->id, $shortlist); @endphp
                    
                    <div class="bg-white rounded-2xl p-6 border {{ $isSelected ? 'border-[#bda065] ring-2 ring-[#bda065]/20 bg-[#fbf9f4]' : 'border-gray-200 hover:border-[#0a3d62]/30' }} hover:shadow-xl transition-all duration-300 flex flex-col relative h-full group">
                        
                        <div class="flex justify-between items-start mb-5">
                            <div class="bg-[#0a3d62] text-white px-3 py-1.5 rounded-lg flex flex-col items-center justify-center shadow-sm">
                                <span class="text-[9px] uppercase tracking-wider text-[#bda065] font-black">كود المرشح</span>
                                <span class="font-mono font-bold text-base leading-none mt-1">{{ str_replace('RWD-', '', $candidate->candidate_code) }}</span>
                            </div>
                            
                            <button wire:click="toggleShortlist({{ $candidate->id }})" class="p-2.5 rounded-xl transition flex items-center justify-center border shadow-sm {{ $isSelected ? 'bg-red-50 text-red-600 border-red-200 hover:bg-red-100' : 'bg-white text-gray-400 border-gray-200 hover:text-[#bda065] hover:border-[#bda065]' }}" title="{{ $isSelected ? 'إزالة من السلة' : 'إضافة للسلة' }}">
                                @if($isSelected)
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                @else
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                @endif
                            </button>
                        </div>

                        <div class="mb-5 flex-grow">
                            <h3 class="text-lg font-extrabold text-[#0a3d62] leading-snug mb-3">
                                {{ $candidate->professional_title }}
                            </h3>
                            
                            <div class="space-y-2">
                                <div class="flex items-start gap-2">
                                    <span class="text-[#bda065] mt-0.5 text-sm">⚕️</span>
                                    <span class="font-bold text-sm text-gray-700 leading-tight">{{ $candidate->general_specialty }}</span>
                                </div>
                                
                                @if($candidate->sub_specialty && $candidate->sub_specialty !== 'غير محدد')
                                <div class="flex items-start gap-2">
                                    <span class="text-gray-400 mt-0.5 text-sm">🔬</span>
                                    <span class="text-xs font-bold bg-gray-100 border border-gray-200 text-gray-600 px-2.5 py-1.5 rounded-lg leading-tight">{{ $candidate->sub_specialty }}</span>
                                </div>
                                @endif
                            </div>
                        </div>

                        <hr class="border-gray-100 mb-4">

                        <div class="grid grid-cols-2 gap-4 mb-5 bg-gray-50 rounded-xl p-3 border border-gray-100">
                            <div>
                                <span class="text-[10px] text-gray-400 font-bold block mb-1">الجنسية</span>
                                <span class="font-bold text-sm text-gray-800 flex items-center gap-1.5">
                                    🌍 {{ $candidate->nationality }}
                                </span>
                            </div>
                            <div>
                                <span class="text-[10px] text-gray-400 font-bold block mb-1">الخبرة</span>
                                <span class="font-bold text-sm text-gray-800 flex items-center gap-1.5">
                                    ⭐ {{ $candidate->years_of_experience }} سنوات
                                </span>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-2 mb-6">
                            @if(str_contains($candidate->prometric_status, 'مجتاز'))
                                <span class="text-[10px] font-bold text-green-700 bg-green-50 border border-green-200 px-2 py-1 rounded-md flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> برومترك: مجتاز
                                </span>
                            @endif

                            @if(str_contains($candidate->dataflow_status, 'مكتمل'))
                                <span class="text-[10px] font-bold text-green-700 bg-green-50 border border-green-200 px-2 py-1 rounded-md flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span> داتافلو: جاهز
                                </span>
                            @elseif(str_contains($candidate->dataflow_status, 'إجراء'))
                                <span class="text-[10px] font-bold text-yellow-700 bg-yellow-50 border border-yellow-200 px-2 py-1 rounded-md flex items-center gap-1">
                                    <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span> داتافلو: قيد الإجراء
                                </span>
                            @endif
                        </div>

                        <button wire:click="openDetailsModal({{ $candidate->id }})" class="w-full mt-auto bg-[#f8f9fa] hover:bg-[#0a3d62] text-[#0a3d62] hover:text-white border border-[#0a3d62]/20 py-3 rounded-xl text-sm font-bold transition-colors flex justify-center items-center gap-2">
                            <span>📄</span> عرض السيرة الذاتية والتفاصيل
                        </button>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @if(count($shortlist) > 0)
        <div class="fixed bottom-0 left-0 w-full bg-[#0a3d62] border-t-4 border-[#bda065] shadow-[0_-10px_40px_rgba(0,0,0,0.2)] z-40 transform transition-transform duration-500">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 py-4 flex flex-col sm:flex-row justify-between items-center gap-4">
                
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-[#bda065] rounded-full flex items-center justify-center text-[#0a3d62] text-xl font-black shadow-inner">{{ count($shortlist) }}</div>
                    <div>
                        <h4 class="text-white font-bold text-lg">مرشحين مختارين</h4>
                        <p class="text-[#bda065] text-xs">أكمل الطلب للحصول على بيانات التواصل وترتيب المقابلات.</p>
                    </div>
                </div>
                
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <button wire:click="clearShortlist" class="flex-shrink-0 bg-transparent border border-red-400/50 text-red-400 hover:bg-red-500 hover:text-white font-bold px-4 py-3.5 rounded-xl transition flex items-center justify-center gap-2" title="تفريغ السلة بالكامل">
                        <span class="text-lg">🗑️</span> 
                        <span class="hidden sm:inline">تفريغ</span>
                    </button>
                    
                    <button wire:click="openCheckoutModal" class="w-full sm:w-auto bg-[#bda065] hover:bg-[#a68c58] text-[#0a3d62] font-extrabold px-8 py-3.5 rounded-xl shadow-lg transition transform hover:-translate-y-1">
                        تأكيد الطلب المجمع ←
                    </button>
                </div>
            </div>
        </div>
    @endif

    @if($showDetailsModal && $viewingCandidate)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-[#0a3d62]/90 backdrop-blur-md p-4">
            <div class="relative w-full max-w-6xl h-[90vh] bg-white rounded-[2rem] shadow-2xl overflow-hidden flex flex-col">
                
                <div class="bg-gradient-to-r from-[#0a3d62] to-[#0f4f7a] px-6 sm:px-8 py-4 sm:py-5 flex justify-between items-center text-white">
                    <div>
                        <span class="text-xs text-[#bda065] font-bold block mb-1">تفاصيل المرشح الطبي</span>
                        <h3 class="font-bold text-lg sm:text-xl font-mono tracking-widest">كود: {{ str_replace('RWD-', '', $viewingCandidate->candidate_code) }}</h3>
                    </div>
                    <button wire:click="closeDetailsModal" class="w-10 h-10 rounded-full bg-white/10 hover:bg-red-500 text-white flex items-center justify-center text-2xl transition">&times;</button>
                </div>
                
                <div class="flex flex-col lg:flex-row flex-grow overflow-hidden">
                    <div class="lg:w-[35%] bg-gray-50 border-l border-gray-200 p-6 sm:p-8 overflow-y-auto custom-scrollbar">
                        
                        <div class="mb-8">
                            <h2 class="text-xl font-extrabold text-[#0a3d62] leading-snug mb-2">{{ $viewingCandidate->professional_title }}</h2>
                            <h3 class="text-lg font-bold text-[#bda065] mb-4">{{ $viewingCandidate->general_specialty }}</h3>
                            
                            @if($viewingCandidate->sub_specialty && $viewingCandidate->sub_specialty !== 'غير محدد')
                            <div class="p-4 bg-white border border-gray-200 rounded-xl shadow-sm">
                                <span class="text-xs text-gray-400 font-bold block mb-1">التخصص الدقيق والمهارات:</span>
                                <span class="text-sm font-bold text-gray-800 leading-relaxed">{{ $viewingCandidate->sub_specialty }}</span>
                            </div>
                            @endif
                        </div>

                        <div class="space-y-6">
                            <div>
                                <h4 class="text-xs font-extrabold text-[#bda065] uppercase tracking-wider border-b border-gray-200 pb-2 mb-3">البيانات الأساسية</h4>
                                <ul class="space-y-3 text-sm">
                                    <li class="flex justify-between items-center"><span class="text-gray-500">الجنسية:</span> <span class="font-bold text-[#0a3d62]">{{ $viewingCandidate->nationality }}</span></li>
                                    <li class="flex justify-between items-center"><span class="text-gray-500">مكان الإقامة الحالي:</span> <span class="font-bold text-[#0a3d62]">{{ $viewingCandidate->current_location }}</span></li>
                                    <li class="flex justify-between items-center"><span class="text-gray-500">الخبرة الكلية:</span> <span class="font-bold text-[#0a3d62]">{{ $viewingCandidate->years_of_experience }} سنوات</span></li>
                                    <li class="flex justify-between items-center"><span class="text-gray-500">فترة الإنذار:</span> <span class="font-bold text-[#0a3d62]">{{ $viewingCandidate->notice_period }}</span></li>
                                </ul>
                            </div>

                            <div>
                                <h4 class="text-xs font-extrabold text-[#bda065] uppercase tracking-wider border-b border-gray-200 pb-2 mb-3">حالة التراخيص الطبية</h4>
                                <ul class="space-y-3 text-sm">
                                    <li class="flex flex-col gap-1.5">
                                        <span class="text-gray-500">توثيق DataFlow:</span> 
                                        <span class="font-bold text-[#0a3d62] bg-white px-3 py-2 rounded-lg border border-gray-200 shadow-sm">{{ $viewingCandidate->dataflow_status }}</span>
                                    </li>
                                    <li class="flex flex-col gap-1.5">
                                        <span class="text-gray-500">امتحان البرومترك:</span> 
                                        <span class="font-bold text-[#0a3d62] bg-white px-3 py-2 rounded-lg border border-gray-200 shadow-sm">{{ $viewingCandidate->prometric_status }}</span>
                                    </li>
                                    <li class="flex flex-col gap-1.5">
                                        <span class="text-gray-500">تصنيف الهيئة (SCFHS):</span> 
                                        <span class="font-bold text-[#0a3d62] bg-white px-3 py-2 rounded-lg border border-gray-200 shadow-sm">{{ $viewingCandidate->scfhs_status }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-200">
                            @php $inShortlist = in_array($viewingCandidate->id, $shortlist); @endphp
                            <button wire:click="toggleShortlist({{ $viewingCandidate->id }})" class="w-full font-extrabold py-4 rounded-xl transition-all duration-300 shadow-lg text-sm border-2 
                                {{ $inShortlist ? 'bg-[#bda065]/10 border-[#bda065] text-[#bda065] hover:bg-red-50 hover:border-red-500 hover:text-red-500' : 'bg-[#0a3d62] border-[#0a3d62] text-white hover:bg-[#082d49]' }}">
                                {{ $inShortlist ? '✕ إزالة من قائمة الطلبات' : '✓ إضافة إلى قائمة الطلبات (السلة)' }}
                            </button>
                        </div>
                    </div>

                    <div class="lg:w-[65%] bg-gray-800 relative flex flex-col h-full hidden md:flex">
                        <div class="bg-gray-900 px-4 py-3 flex justify-between items-center text-gray-300 text-xs shrink-0">
                            <span class="font-bold flex items-center gap-2"><span class="text-[#bda065]">📄</span> السيرة الذاتية (النسخة العمياء)</span>
                            <span>النسخة الموضحة خالية من بيانات الاتصال لدواعي السرية.</span>
                        </div>
                        
                        <div class="flex-grow w-full h-full relative bg-gray-800">
                            @if($viewingCandidate->blind_cv_path)
                                <iframe src="{{ asset('storage/' . $viewingCandidate->blind_cv_path) }}#toolbar=0&navpanes=0" class="w-full h-full border-0" title="السيرة الذاتية العمياء"></iframe>
                            @else
                                <div class="absolute inset-0 flex flex-col items-center justify-center text-gray-400">
                                    <span class="text-6xl mb-4">⏳</span>
                                    <p class="font-bold text-lg">جاري معالجة السيرة الذاتية...</p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($showCheckoutModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center overflow-y-auto overflow-x-hidden bg-[#0a3d62]/90 backdrop-blur-md p-4">
            <div class="relative w-full max-w-lg bg-white rounded-[2rem] shadow-2xl overflow-hidden">
                <div class="bg-gradient-to-r from-[#0a3d62] to-[#0f4f7a] px-8 py-5 flex justify-between items-center text-white">
                    <div>
                        <span class="text-xs text-[#bda065] font-bold block mb-1">تأكيد طلب الشراكة</span>
                        <h3 class="font-bold text-xl">طلب التواصل مع {{ count($shortlist) }} مرشحين</h3>
                    </div>
                    <button wire:click="closeCheckoutModal" class="w-8 h-8 rounded-full bg-white/10 hover:bg-red-500 text-white flex items-center justify-center text-xl">&times;</button>
                </div>
                
                <div class="p-8">
                    @if($requestSuccess)
                        <div class="text-center py-6">
                            <div class="w-20 h-20 bg-[#e8f3ee] text-[#27ae60] rounded-full flex items-center justify-center text-4xl mx-auto mb-6 shadow-inner">✓</div>
                            <h4 class="text-2xl font-extrabold text-[#0a3d62] mb-3">تم إرسال طلباتك بنجاح!</h4>
                            <p class="text-gray-500 text-sm mb-8 leading-relaxed">سيقوم فريق التوظيف في روافد بتجهيز الملفات الأصلية وبيانات الاتصال للمرشحين المختارين وإرسالها لبريدكم الإلكتروني فوراً لتنسيق المقابلات.</p>
                            <button wire:click="closeCheckoutModal" class="w-full bg-[#0a3d62] hover:bg-[#082d49] text-white px-8 py-3.5 rounded-xl font-bold transition shadow-md">حسناً، إغلاق</button>
                        </div>
                    @else
                        <div class="mb-6 bg-gray-50 p-4 rounded-xl border border-gray-200">
                            <h4 class="text-xs font-bold text-gray-500 mb-2">أكواد المرشحين المختارة:</h4>
                            <div class="flex flex-wrap gap-2">
                                @foreach($selectedCandidatesCodes as $code)
                                    <span class="bg-[#0a3d62] text-white px-2 py-1 rounded text-xs font-mono tracking-wider">{{ str_replace('RWD-', '', $code) }}</span>
                                @endforeach
                            </div>
                        </div>

                        <form wire:submit.prevent="submitBulkRequest" class="space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-[#0a3d62] mb-1.5">اسم المستشفى / المركز الطبي</label>
                                <input type="text" wire:model="hospital_name" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:border-[#bda065] focus:ring-1 focus:ring-[#bda065] outline-none transition">
                                @error('hospital_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#0a3d62] mb-1.5">اسم مسؤول التوظيف (الاسم الكريم)</label>
                                <input type="text" wire:model="hr_contact_name" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:border-[#bda065] focus:ring-1 focus:ring-[#bda065] outline-none transition">
                                @error('hr_contact_name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-[#0a3d62] mb-1.5">البريد الإلكتروني الرسمي للتواصل</label>
                                <input type="email" wire:model="hr_email" class="w-full px-4 py-3 bg-white border border-gray-200 rounded-xl focus:border-[#bda065] focus:ring-1 focus:ring-[#bda065] outline-none text-left transition" dir="ltr" placeholder="hr@hospital.com">
                                @error('hr_email') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <button type="submit" class="w-full bg-[#bda065] hover:bg-[#a68c58] text-[#0a3d62] font-extrabold py-4 rounded-xl mt-6 border-b-4 border-[#8c7447] transition shadow-lg">
                                <span wire:loading.remove wire:target="submitBulkRequest">تأكيد الإرسال واستلام البيانات</span>
                                <span wire:loading wire:target="submitBulkRequest">جاري معالجة الطلب... ⏳</span>
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    @endif

</div>