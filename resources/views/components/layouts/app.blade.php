<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'روافد للمواهب الطبية | Rawafed Medical Talent' }}</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800;900&display=swap" rel="stylesheet">
    
    <script src="https://cdn.tailwindcss.com"></script>
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Tajawal', 'sans-serif'],
                    },
                    colors: {
                        navy: '#0a3d62',
                        gold: '#bda065',
                        goldlight: '#9c814b'
                    }
                }
            }
        }
    </script>
    
    <style>
        /* إعدادات السكرول بار */
        .custom-scrollbar::-webkit-scrollbar { width: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #bda065; border-radius: 10px; }
        
        /* تأثيرات إضافية */
        .glass-nav {
            background: rgba(10, 61, 98, 0.98);
            backdrop-filter: blur(10px);
        }
    </style>
    @livewireStyles
</head>
<body class="font-sans antialiased text-gray-800 bg-[#f8fafc] selection:bg-gold selection:text-navy flex flex-col min-h-screen">

    <nav class="glass-nav sticky top-0 w-full z-50 border-b border-white/10 shadow-lg shadow-navy/10 transition-all duration-300">
        <div class="max-w-[1400px] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                
                <a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0">
                    <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-gold to-goldlight flex items-center justify-center text-white font-extrabold text-2xl shadow-[0_0_15px_rgba(189,160,101,0.4)] group-hover:scale-105 group-hover:rotate-3 transition transform duration-300">ر</div>
                    <span class="text-2xl md:text-3xl font-extrabold text-white tracking-wide">روافد<span class="text-gold">.</span></span>
                </a>
                
                <div class="hidden lg:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-sm font-bold {{ request()->routeIs('home') ? 'text-gold' : 'text-gray-300 hover:text-white' }} transition duration-300 relative group">
                        الرئيسية
                        <span class="absolute -bottom-2 left-0 h-0.5 bg-gold transition-all duration-300 {{ request()->routeIs('home') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                    </a>
                    
                    <a href="{{ route('catalog') }}" class="text-sm font-bold {{ request()->routeIs('catalog') ? 'text-gold' : 'text-gray-300 hover:text-white' }} transition duration-300 relative group">
                        تصفح الكفاءات (للمستشفيات)
                        <span class="absolute -bottom-2 left-0 h-0.5 bg-gold transition-all duration-300 {{ request()->routeIs('catalog') ? 'w-full' : 'w-0 group-hover:w-full' }}"></span>
                    </a>

                    @auth
                        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-gray-300 hover:text-white transition duration-300 relative group flex items-center gap-1">
                            <svg class="w-4 h-4 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            لوحة الإدارة
                        </a>
                    @endauth
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('candidate.register') }}" class="hidden sm:flex items-center gap-2 bg-transparent border-2 border-gold text-gold hover:bg-gold hover:text-navy font-black py-2 px-6 rounded-xl transition-all duration-300 text-sm shadow-[0_0_0_0_rgba(189,160,101,0)] hover:shadow-[0_0_20px_rgba(189,160,101,0.3)] transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        انضم ككادر طبي
                    </a>

                    <button id="mobile-menu-btn" class="lg:hidden text-white hover:text-gold transition focus:outline-none">
                        <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <div id="mobile-menu" class="hidden lg:hidden bg-navy border-t border-white/10 absolute w-full left-0 shadow-2xl">
            <div class="px-4 pt-2 pb-6 space-y-2 flex flex-col">
                <a href="{{ route('home') }}" class="block px-4 py-3 text-base font-bold {{ request()->routeIs('home') ? 'bg-gold/10 text-gold' : 'text-gray-200 hover:bg-white/5 hover:text-gold' }} rounded-xl transition">الرئيسية</a>
                <a href="{{ route('catalog') }}" class="block px-4 py-3 text-base font-bold {{ request()->routeIs('catalog') ? 'bg-gold/10 text-gold' : 'text-gray-200 hover:bg-white/5 hover:text-gold' }} rounded-xl transition">الكتالوج الأعمى</a>
                
                @auth
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-3 text-base font-bold text-gray-200 hover:bg-white/5 hover:text-gold rounded-xl transition flex items-center gap-2">
                        <svg class="w-5 h-5 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        لوحة الإدارة
                    </a>
                @endauth

                <div class="border-t border-white/10 my-2 pt-4">
                    <a href="{{ route('candidate.register') }}" class="flex justify-center items-center gap-2 bg-gold text-navy font-black py-3 px-6 rounded-xl transition w-full shadow-lg">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                        تسجيل الكوادر الطبية
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-1 flex flex-col">
        {{ $slot }}
    </main>

    <div class="mt-auto">
        <div class="bg-gradient-to-r from-gold to-goldlight text-navy relative overflow-hidden">
            <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#0a3d62 1px, transparent 1px); background-size: 20px 20px;"></div>
            <div class="max-w-[1400px] mx-auto px-6 py-10 lg:py-14 relative z-10 flex flex-col md:flex-row items-center justify-between gap-6 text-center md:text-right">
                <div>
                    <h3 class="text-2xl md:text-3xl font-black mb-2">مستعد لتوظيف أفضل الكفاءات الطبية؟</h3>
                    <p class="text-navy/80 font-bold text-sm md:text-base">تصفح الكتالوج الأعمى الآن أو تواصل مع خبرائنا لاحتياجات التوظيف الخاصة.</p>
                </div>
                <div class="flex gap-4 shrink-0">
                    <a href="{{ route('catalog') }}" class="bg-navy text-white hover:bg-gray-900 px-8 py-3.5 rounded-xl font-black transition-all shadow-xl hover:-translate-y-1">تصفح الكفاءات</a>
                </div>
            </div>
        </div>

        <footer class="bg-navy text-white pt-20 pb-8 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-full opacity-[0.03] pointer-events-none flex items-center justify-center">
                <svg class="w-96 h-96" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            </div>

            <div class="max-w-[1400px] mx-auto px-6 grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-12 lg:gap-8 border-b border-white/10 pb-16 mb-8 relative z-10">
                
                <div class="xl:col-span-1">
                    <a href="/" class="flex items-center gap-3 mb-6">
                        <div class="w-8 h-8 rounded border-2 border-gold flex items-center justify-center text-gold text-lg font-extrabold">ر</div>
                        <span class="text-2xl font-black text-white tracking-wide">روافد<span class="text-gold">.</span></span>
                    </a>
                    <p class="text-gray-400 text-sm leading-relaxed mb-6 font-medium">
                        شريكك الاستراتيجي الموثوق للتوظيف الطبي الشامل في المملكة العربية السعودية والخليج. نربط الكفاءات الطبية الاستثنائية بأرقى المنشآت الصحية بسرية تامة واحترافية عالية.
                    </p>
                    <div class="text-xs font-black bg-white/5 border border-white/10 inline-flex py-2 px-4 rounded-lg text-gold gap-3">
                        <span>🇸🇦 الرياض</span>
                        <span class="text-white/20">|</span>
                        <span>🇰🇼 الكويت</span>
                        <span class="text-white/20">|</span>
                        <span>🇸🇩 الخرطوم</span>
                    </div>
                </div>

                <div>
                    <h4 class="text-lg font-black mb-6 text-white flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-gold rounded-full inline-block"></span>
                        للمنشآت الصحية
                    </h4>
                    <ul class="space-y-4 text-sm font-bold text-gray-400">
                        <li><a href="{{ route('catalog') }}" class="hover:text-gold transition flex items-center gap-2 group"><svg class="w-4 h-4 opacity-0 -mr-6 group-hover:opacity-100 group-hover:mr-0 transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> الكتالوج الأعمى للكفاءات</a></li>
                        <li><a href="#" class="hover:text-gold transition flex items-center gap-2 group"><svg class="w-4 h-4 opacity-0 -mr-6 group-hover:opacity-100 group-hover:mr-0 transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> طلب حملة توظيف مخصصة</a></li>
                        <li><a href="#" class="hover:text-gold transition flex items-center gap-2 group"><svg class="w-4 h-4 opacity-0 -mr-6 group-hover:opacity-100 group-hover:mr-0 transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> أسعار الباقات والعقود</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-black mb-6 text-white flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-gold rounded-full inline-block"></span>
                        للكوادر الطبية
                    </h4>
                    <ul class="space-y-4 text-sm font-bold text-gray-400">
                        <li><a href="{{ route('candidate.register') }}" class="hover:text-gold transition flex items-center gap-2 group"><svg class="w-4 h-4 opacity-0 -mr-6 group-hover:opacity-100 group-hover:mr-0 transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> تسجيل السيرة الذاتية مجاناً</a></li>
                        <li><a href="#" class="hover:text-gold transition flex items-center gap-2 group"><svg class="w-4 h-4 opacity-0 -mr-6 group-hover:opacity-100 group-hover:mr-0 transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> الدليل الإرشادي لاختبارات البرومترك</a></li>
                        <li><a href="#" class="hover:text-gold transition flex items-center gap-2 group"><svg class="w-4 h-4 opacity-0 -mr-6 group-hover:opacity-100 group-hover:mr-0 transition-all duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg> سياسة الخصوصية وسرية البيانات</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="text-lg font-black mb-6 text-white flex items-center gap-2">
                        <span class="w-1.5 h-4 bg-gold rounded-full inline-block"></span>
                        الدعم المباشر
                    </h4>
                    <ul class="space-y-4 text-sm font-bold text-gray-400">
                        <li>
                            <a href="mailto:rawafed.medical.talent@gmail.com" class="flex items-start gap-3 hover:text-white transition group">
                                <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-gold group-hover:bg-gold group-hover:text-navy transition-colors shrink-0">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-gray-500 uppercase tracking-widest mb-0.5">البريد الإلكتروني</span>
                                    <span dir="ltr">rawafed.medical.talent@gmail.com</span>
                                </div>
                            </a>
                        </li>
                        <li>
                            <a href="https://wa.me/249909590325" target="_blank" class="flex items-start gap-3 hover:text-white transition group">
                                <div class="w-10 h-10 rounded-xl bg-white/5 flex items-center justify-center text-gold group-hover:bg-green-500 group-hover:text-white transition-colors shrink-0">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.323-.297-.124-1.758-.871-2.03-.97-.272-.099-.47-.148-.668.148-.198.297-.769.97-.942 1.168-.173.198-.347.223-.644.099-.297-.124-1.255-.462-2.39-1.475-.88-.788-1.474-1.761-1.648-2.059-.173-.297-.018-.458.13-.582.134-.111.297-.347.446-.52.149-.174.198-.298.297-.495.099-.198.05-.371-.025-.495-.075-.124-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-[10px] text-gray-500 uppercase tracking-widest mb-0.5">واتساب الإدارة</span>
                                    <span dir="ltr" class="font-bold">+249 909 590 325</span>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>

            </div>
            
            <div class="text-center px-6 relative z-10">
                <p class="text-xs text-gray-500 font-bold">
                    © {{ date('Y') }} روافد للمواهب الطبية. تم التطوير لتلبية احتياجات القطاع الصحي في دول الخليج.
                </p>
            </div>
        </footer>
    </div>

    <script>
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                // تأثير نزول ناعم
                menu.classList.add('animate-[slideDown_0.3s_ease-out]');
            } else {
                menu.classList.add('hidden');
                menu.classList.remove('animate-[slideDown_0.3s_ease-out]');
            }
        });
    </script>
    
    <style>
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>

    @livewireScripts
</body>
</html>