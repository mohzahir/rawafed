<div class="bg-[#f8fafc] py-6 font-sans antialiased" dir="rtl">
    <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="mb-8 flex flex-col md:flex-row md:items-end justify-between gap-4 border-b border-gray-200 pb-6">
            <div>
                <span class="text-[#bda065] font-black text-sm tracking-widest uppercase mb-1 block">إدارة المبيعات (CRM)</span>
                <h1 class="text-3xl font-black text-[#0a3d62] mb-2">طلبات المستشفيات (Leads)</h1>
                <p class="text-gray-500 text-sm">شاهد طلبات التوظيف، حمل السير الذاتية الأصلية، وتواصل مع الجهات.</p>
            </div>
            
            <div class="flex bg-white rounded-xl shadow-sm border border-gray-200 p-1">
                <button wire:click="$set('statusFilter', '')" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ $statusFilter === '' ? 'bg-[#0a3d62] text-white' : 'text-gray-500 hover:bg-gray-50' }}">الكل</button>
                <button wire:click="$set('statusFilter', 'pending')" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ $statusFilter === 'pending' ? 'bg-yellow-500 text-white' : 'text-gray-500 hover:bg-gray-50' }}">الجديدة</button>
                <button wire:click="$set('statusFilter', 'contacted')" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ $statusFilter === 'contacted' ? 'bg-blue-500 text-white' : 'text-gray-500 hover:bg-gray-50' }}">تم التواصل</button>
                <button wire:click="$set('statusFilter', 'closed')" class="px-4 py-2 rounded-lg text-sm font-bold transition-colors {{ $statusFilter === 'closed' ? 'bg-green-500 text-white' : 'text-gray-500 hover:bg-gray-50' }}">مغلقة/مكتملة</button>
            </div>
        </div>

        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto custom-scrollbar">
                <table class="w-full text-right border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="p-5 text-sm font-black text-[#0a3d62] whitespace-nowrap">الجهة الطالبة (المستشفى)</th>
                            <th class="p-5 text-sm font-black text-[#0a3d62] whitespace-nowrap">المرشح المطلوب</th>
                            <th class="p-5 text-sm font-black text-[#0a3d62] whitespace-nowrap">ملاحظات الموعد</th>
                            <th class="p-5 text-sm font-black text-[#0a3d62] whitespace-nowrap text-center">الحالة</th>
                            <th class="p-5 text-sm font-black text-[#0a3d62] whitespace-nowrap text-center">الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($requests as $request)
                            <tr class="hover:bg-blue-50/30 transition-colors group">
                                <td class="p-5 align-top">
                                    <div class="flex flex-col">
                                        <span class="font-black text-gray-800 text-base mb-1">{{ $request->hospital_name }}</span>
                                        <span class="text-xs font-bold text-gray-500 mb-0.5">بواسطة: {{ $request->hr_contact_name }}</span>
                                        <a href="mailto:{{ $request->hr_email }}" class="text-xs font-bold text-blue-600 hover:underline" dir="ltr">{{ $request->hr_email }}</a>
                                        <span class="text-[10px] text-gray-400 mt-2">{{ $request->created_at->locale('ar')->diffForHumans() }}</span>
                                    </div>
                                </td>

                                <td class="p-5 align-top">
                                    @if($request->candidate)
                                        <div class="flex flex-col bg-gray-50 p-3 rounded-xl border border-gray-100 w-max">
                                            <div class="flex items-center gap-2 mb-1.5">
                                                <span class="text-xs font-black text-[#0a3d62] bg-white px-2 py-0.5 rounded border border-gray-200">#{{ $request->candidate->candidate_code }}</span>
                                                <span class="text-xs font-bold text-gray-800">{{ $request->candidate->full_name }}</span>
                                            </div>
                                            <span class="text-[11px] font-bold text-[#bda065]">{{ $request->candidate->professional_title }}</span>
                                            <span class="text-[11px] text-gray-500 line-clamp-1 max-w-[200px]">{{ $request->candidate->general_specialty }}</span>
                                        </div>
                                    @else
                                        <span class="text-xs text-red-500 font-bold bg-red-50 px-2 py-1 rounded">تم حذف بيانات المرشح</span>
                                    @endif
                                </td>

                                <td class="p-5 align-top">
                                    <p class="text-xs text-gray-600 font-medium max-w-[200px] leading-relaxed">
                                        {{ $request->notes ?: 'لا توجد ملاحظات إضافية.' }}
                                    </p>
                                </td>

                                <td class="p-5 align-top text-center">
                                    <div class="relative inline-block text-left" x-data="{ open: false }">
                                        <button @click="open = !open" @click.away="open = false" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-black transition-colors
                                            {{ $request->status == 'pending' ? 'bg-yellow-50 text-yellow-700 border border-yellow-200' : '' }}
                                            {{ $request->status == 'contacted' ? 'bg-blue-50 text-blue-700 border border-blue-200' : '' }}
                                            {{ $request->status == 'closed' ? 'bg-green-50 text-green-700 border border-green-200' : '' }}
                                        ">
                                            {{ $request->status == 'pending' ? 'طلب جديد' : ($request->status == 'contacted' ? 'تم التواصل' : 'مكتمل') }}
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                        </button>
                                        
                                        <div x-show="open" x-cloak class="absolute left-0 mt-2 w-32 bg-white border border-gray-100 rounded-xl shadow-xl z-10 overflow-hidden">
                                            <button wire:click="updateStatus({{ $request->id }}, 'pending')" class="w-full text-right px-4 py-2 text-xs font-bold text-gray-700 hover:bg-gray-50 border-b border-gray-50">طلب جديد</button>
                                            <button wire:click="updateStatus({{ $request->id }}, 'contacted')" class="w-full text-right px-4 py-2 text-xs font-bold text-gray-700 hover:bg-gray-50 border-b border-gray-50">تم التواصل</button>
                                            <button wire:click="updateStatus({{ $request->id }}, 'closed')" class="w-full text-right px-4 py-2 text-xs font-bold text-gray-700 hover:bg-gray-50">مكتمل</button>
                                        </div>
                                    </div>
                                </td>

                                <td class="p-5 align-top text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        @if($request->candidate && $request->candidate->original_cv_path)
                                            <a href="{{ Storage::url($request->candidate->original_cv_path) }}" target="_blank" class="bg-[#0a3d62] text-white hover:bg-[#082d49] px-4 py-2 rounded-xl text-xs font-black shadow-md flex items-center gap-1.5 transition-transform hover:-translate-y-0.5" title="عرض السيرة الذاتية الأصلية (التي تحتوي على الاسم والرقم)">
                                                <svg class="w-4 h-4 text-[#bda065]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                الـ CV الأصلي
                                            </a>
                                        @else
                                            <span class="text-xs text-gray-400 font-bold">لا يوجد ملف</span>
                                        @endif
                                        
                                        <button wire:click="deleteRequest({{ $request->id }})" onclick="confirm('هل أنت متأكد من حذف هذا الطلب؟') || event.stopImmediatePropagation()" class="w-8 h-8 rounded-full bg-gray-50 text-gray-400 hover:text-red-500 hover:bg-red-50 flex items-center justify-center transition-colors">
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="p-12 text-center">
                                    <div class="flex flex-col items-center justify-center text-gray-400">
                                        <svg class="w-16 h-16 mb-4 text-gray-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                        <p class="text-lg font-black text-gray-400 mb-1">لا توجد طلبات حالياً</p>
                                        <p class="text-sm">بمجرد أن تقوم المستشفيات بطلب كفاءات، ستظهر هنا.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="p-4 border-t border-gray-100">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
    
    <script>
        window.addEventListener('alert-success', event => {
            alert(event.detail.message); // يمكنك تبديله بالـ Toast الأنيق الذي برمجناه سابقاً إذا أردت
        });
    </script>
</div>