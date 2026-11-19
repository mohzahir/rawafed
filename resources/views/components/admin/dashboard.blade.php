<div class="font-sans antialiased text-gray-800 bg-[#f4f7f6] min-h-screen pb-12" dir="rtl">
    
    <nav class="bg-[#0a3d62] shadow-md relative z-20">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-6">
                <a href="/" class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded bg-[#bda065] flex items-center justify-center text-white font-extrabold text-xl">ر</div>
                    <span class="text-xl font-extrabold text-white tracking-wide">روافد<span class="text-[#bda065]">.</span></span>
                </a>
                <span class="text-gray-400 font-bold hidden sm:inline">|</span>
                <span class="text-white font-bold text-sm bg-white/10 px-4 py-1.5 rounded-full">لوحة تحكم الإدارة</span>
            </div>
            
            <div class="flex gap-3">
                <a href="/admin/import" class="text-sm font-bold text-white hover:text-[#bda065] transition px-3 py-2">📥 استيراد CSV</a>
                <a href="/catalog" target="_blank" class="text-sm font-bold bg-[#bda065] text-[#0a3d62] px-4 py-2 rounded-lg hover:bg-white transition shadow-sm">👁️ عرض الكتالوج</a>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-6 py-8">

        @if(session()->has('statusMessage'))
            <div class="mb-5 rounded-xl border border-blue-200 bg-blue-50 px-4 py-3 text-sm font-bold text-blue-800" role="status">
                {{ session('statusMessage') }}
            </div>
        @endif
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div><p class="text-gray-500 text-sm font-bold mb-1">إجمالي المرشحين</p><h3 class="text-3xl font-black text-[#0a3d62]">{{ $stats['total'] }}</h3></div>
                <div class="w-12 h-12 rounded-full bg-blue-50 text-blue-500 flex items-center justify-center text-2xl">👥</div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div><p class="text-gray-500 text-sm font-bold mb-1">المفعلين (في الكتالوج)</p><h3 class="text-3xl font-black text-green-600">{{ $stats['active'] }}</h3></div>
                <div class="w-12 h-12 rounded-full bg-green-50 text-green-500 flex items-center justify-center text-2xl">✅</div>
            </div>
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-gray-100 flex items-center justify-between">
                <div><p class="text-gray-500 text-sm font-bold mb-1">قيد المراجعة (مخفي)</p><h3 class="text-3xl font-black text-yellow-600">{{ $stats['pending'] }}</h3></div>
                <div class="w-12 h-12 rounded-full bg-yellow-50 text-yellow-500 flex items-center justify-center text-2xl">⏳</div>
            </div>
        </div>

        <div class="bg-white p-4 rounded-t-2xl shadow-sm border border-gray-100 border-b-0 flex flex-col sm:flex-row gap-4 justify-between items-center">
            <div class="relative w-full sm:w-1/2 md:w-1/3">
                <span class="absolute right-3 top-2.5 text-gray-400 text-sm">🔍</span>
                <input type="text" wire:model.live.debounce.300ms="search" class="w-full pr-9 pl-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#bda065] text-sm text-gray-700 transition" placeholder="ابحث بالاسم، الكود، أو التخصص...">
            </div>
            
            <select wire:model.live="statusFilter" class="w-full sm:w-auto px-4 py-2 bg-gray-50 border border-gray-200 rounded-xl focus:outline-none focus:border-[#bda065] text-sm text-gray-700">
                <option value="">جميع الحالات</option>
                <option value="1">المفعلين فقط (نشط)</option>
                <option value="0">قيد المراجعة (مخفي)</option>
            </select>
        </div>

        <div class="bg-white shadow-sm border border-gray-100 rounded-b-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm text-right text-gray-600">
                    <thead class="text-xs text-[#0a3d62] uppercase bg-gray-50 border-b border-gray-100">
                        <tr>
                            <th class="px-6 py-4 font-bold">المرشح والكود</th>
                            <th class="px-6 py-4 font-bold">التخصص والخبرة</th>
                            <th class="px-6 py-4 font-bold">بيانات الاتصال</th>
                            <th class="px-6 py-4 font-bold">حالة الكتالوج</th>
                            <th class="px-6 py-4 font-bold text-center">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse($candidates as $candidate)
                            <tr wire:key="candidate-{{ $candidate->id }}" class="hover:bg-blue-50/30 transition duration-150">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-[#0a3d62] text-base">{{ $candidate->full_name }}</div>
                                    <div class="font-mono text-xs text-[#bda065] mt-0.5">{{ $candidate->candidate_code }}</div>
                                    <div class="text-[10px] text-gray-400 mt-1">سجل في: {{ $candidate->created_at->format('Y-m-d') }}</div>
                                </td>
                                
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-800">{{ $candidate->professional_title }}</div>
                                    <div class="text-xs text-gray-500 mt-0.5">{{ $candidate->general_specialty }} • {{ $candidate->years_of_experience }} سنوات</div>
                                    <div class="text-xs text-gray-400 mt-1">🌍 {{ $candidate->nationality }}</div>
                                </td>
                                
                                <td class="px-6 py-4">
                                    <div class="text-xs flex items-center gap-1.5 mb-1"><span class="text-gray-400">✉️</span> {{ $candidate->email }}</div>
                                    <div class="text-xs flex items-center gap-1.5 font-mono" dir="ltr"><span class="text-gray-400">📞</span> {{ $candidate->phone }}</div>
                                </td>
                                
                                <td class="px-6 py-4">
                                        <button type="button" wire:click="toggleStatus({{ $candidate->id }})" 
                                            wire:loading.attr="disabled"
                                            wire:target="toggleStatus({{ $candidate->id }})"
                                            class="relative inline-flex items-center h-6 rounded-full w-11 transition-colors duration-300 focus:outline-none {{ $candidate->is_active ? 'bg-green-500' : 'bg-gray-300' }} disabled:opacity-50">
                                        <span class="inline-block w-4 h-4 transform bg-white rounded-full transition-transform duration-300 {{ $candidate->is_active ? '-translate-x-6' : '-translate-x-1' }}"></span>
                                    </button>
                                    <span class="text-xs font-bold ml-2 {{ $candidate->is_active ? 'text-green-600' : 'text-gray-400' }}">
                                        {{ $candidate->is_active ? 'نشط' : 'مخفي' }}
                                    </span>
                                </td>
                                
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @if($candidate->summary_cv_path)
                                            <a href="{{ route('admin.candidates.summary', $candidate) }}" target="_blank" rel="noopener" class="text-emerald-600 hover:text-emerald-800 bg-emerald-50 p-2 rounded-lg transition" title="عرض ملخص السيرة الذاتية" aria-label="عرض ملخص السيرة الذاتية">
                                                📋
                                            </a>
                                        @endif

                                        @if($candidate->original_cv_path)
                                            <a href="{{ route('admin.candidates.original-cv', $candidate) }}" target="_blank" rel="noopener" class="text-blue-500 hover:text-blue-700 bg-blue-50 p-2 rounded-lg transition" title="عرض السيرة الأصلية">
                                                📄
                                            </a>
                                        @endif
                                        
                                        <button onclick="confirm('هل أنت متأكد من حذف هذا المرشح نهائياً؟ لن يمكنك التراجع.') || event.stopImmediatePropagation()" wire:click="deleteCandidate({{ $candidate->id }})" class="text-red-500 hover:text-red-700 bg-red-50 p-2 rounded-lg transition" title="حذف المرشح">
                                            🗑️
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
                                    <div class="text-4xl mb-3">📭</div>
                                    <p class="font-bold text-lg text-[#0a3d62]">لا يوجد مرشحين حالياً</p>
                                    <p class="text-sm">لم يقم أحد بالتسجيل بعد، أو لم يعثر البحث على نتائج.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-t border-gray-100 bg-gray-50">
                {{ $candidates->links() }}
            </div>
        </div>

    </div>
</div>