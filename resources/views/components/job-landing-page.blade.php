<div class="min-h-screen bg-[#f4f7f6] font-sans antialiased pb-24 lg:pb-0" dir="rtl">
    
    <div class="bg-[#0a3d62] relative pt-12 pb-32 lg:pt-16 lg:pb-40 overflow-hidden">
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#bda065 1px, transparent 1px); background-size: 30px 30px;"></div>
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-[#bda065] rounded-full blur-[120px] opacity-20 transform translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-wrap items-center gap-3 mb-8">
                <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full bg-green-500/20 border border-green-400/30 text-green-400 text-[10px] font-black tracking-widest">
                    <span class="relative flex h-2 w-2">
                      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                      <span class="relative inline-flex rounded-full h-2 w-2 bg-green-500"></span>
                    </span>
                    توظيف عاجل
                </span>
                <span class="inline-flex items-center gap-1.5 py-1 px-3 rounded-full bg-white/10 border border-white/20 text-white text-[10px] font-bold">
                    <svg class="w-3.5 h-3.5 text-[#bda065]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    سرية بيانات تامة (ملف أعمى)
                </span>
            </div>

            <h1 class="text-3xl md:text-5xl font-black text-white mb-6 leading-tight drop-shadow-md">
                {{ $job->title }}
            </h1>
            
            <p class="text-gray-300 font-medium text-sm md:text-base max-w-2xl leading-relaxed">
                فرصة حصرية عبر منصة روافد. قدم سيرتك الذاتية الآن، وسيقوم نظامنا بتشفير بياناتك الشخصية وعرض كفاءتك على المستشفى المباشر.
            </p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20 -mt-20 lg:-mt-24 mb-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 md:gap-4">
            
            <div class="bg-white rounded-2xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-navy/5 flex flex-col items-center text-center group hover:-translate-y-1 transition-transform">
                <div class="w-10 h-10 rounded-full bg-blue-50 text-blue-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg></div>
                <span class="text-[10px] font-bold text-gray-400 mb-1">موقع العمل</span>
                <span class="text-sm font-black text-[#0a3d62]">{{ $job->country }}</span>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-navy/5 flex flex-col items-center text-center group hover:-translate-y-1 transition-transform">
                <div class="w-10 h-10 rounded-full bg-[#bda065]/10 text-[#bda065] flex items-center justify-center mb-3 group-hover:scale-110 transition-transform"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                <span class="text-[10px] font-bold text-gray-400 mb-1">التخصص المطلوب</span>
                <span class="text-sm font-black text-[#0a3d62]">{{ $job->specialty }}</span>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-navy/5 flex flex-col items-center text-center group hover:-translate-y-1 transition-transform">
                <div class="w-10 h-10 rounded-full bg-green-50 text-green-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg></div>
                <span class="text-[10px] font-bold text-gray-400 mb-1">العرض المالي</span>
                <span class="text-sm font-black text-green-700">{{ $job->salary_range ?: 'يحدد بعد المقابلة' }}</span>
            </div>

            <div class="bg-white rounded-2xl p-4 md:p-5 border border-gray-100 shadow-xl shadow-navy/5 flex flex-col items-center text-center group hover:-translate-y-1 transition-transform relative overflow-hidden">
                <div class="absolute -right-2 -top-2 w-12 h-12 bg-purple-50 rounded-full blur-xl"></div>
                <div class="w-10 h-10 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center mb-3 group-hover:scale-110 transition-transform relative z-10"><svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg></div>
                <span class="text-[10px] font-bold text-gray-400 mb-1 relative z-10">وقت التقديم</span>
                <span class="text-sm font-black text-purple-700 relative z-10">أقل من دقيقة</span>
            </div>

        </div>
    </div>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
        <div class="bg-white rounded-[2rem] p-8 md:p-12 border border-gray-100 shadow-sm">
            
            <h3 class="text-xl font-black text-[#0a3d62] mb-6 flex items-center gap-2">
                <span class="w-2 h-6 bg-[#bda065] rounded-full inline-block"></span>
                التفاصيل والمتطلبات
            </h3>

            <div class="prose prose-lg text-gray-600 leading-loose font-medium mb-12 max-w-none">
                {!! nl2br(e($job->description)) !!}
            </div>

            <div class="bg-gradient-to-r from-gray-50 to-white rounded-2xl p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-6 border border-gray-200 relative overflow-hidden">
                <svg class="absolute -left-10 -bottom-10 w-40 h-40 text-gray-100 transform -rotate-12 pointer-events-none" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
                
                <div class="relative z-10 text-center md:text-right">
                    <h4 class="text-xl font-black text-[#0a3d62] mb-2">مستعد لهذه الفرصة؟</h4>
                    <p class="text-sm text-gray-500 font-bold mb-3">ارفع سيرتك الذاتية (PDF)، وسيقوم الذكاء الاصطناعي باستخراج مهاراتك وتشفير اسمك تلقائياً للتقديم السريع.</p>
                    <div class="flex items-center justify-center md:justify-start gap-4 text-[10px] font-bold text-gray-400">
                        <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-[#bda065]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> بدون إنشاء حساب معقد</span>
                        <span class="flex items-center gap-1"><svg class="w-3.5 h-3.5 text-[#bda065]" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg> سرية تامة 100%</span>
                    </div>
                </div>
                
                <a href="{{ route('candidate.register', ['job_id' => $job->id]) }}" class="hidden md:flex shrink-0 bg-gradient-to-l from-[#0a3d62] to-[#0d4e7d] text-white hover:shadow-xl hover:shadow-[#0a3d62]/20 px-8 py-4 rounded-xl font-black text-center transition-all transform hover:-translate-y-1 items-center justify-center gap-3 relative z-10">
                    تقديم السيرة الذاتية الآن
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                </a>
            </div>

        </div>
    </div>

    <div class="md:hidden fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 p-4 pb-6 z-50 shadow-[0_-10px_30px_rgba(0,0,0,0.05)] animate-[slideUp_0.5s_ease-out]">
        <a href="{{ route('candidate.register', ['job_id' => $job->id]) }}" class="w-full flex items-center justify-center gap-2 bg-[#0a3d62] text-white px-6 py-3.5 rounded-xl font-black shadow-lg active:scale-95 transition-transform">
            تقديم سريع للوظيفة
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        </a>
    </div>

    <style>
        @keyframes slideUp {
            from { transform: translateY(100%); }
            to { transform: translateY(0); }
        }
    </style>
</div>