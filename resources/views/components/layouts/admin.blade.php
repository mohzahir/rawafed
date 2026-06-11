<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>إدارة روافد | Admin Panel</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700;900&display=swap" rel="stylesheet">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        body { font-family: 'Cairo', sans-serif; }
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    </style>
</head>
<body class="bg-[#f4f7f6] text-gray-800 antialiased" x-data="{ mobileMenuOpen: false }">

    <div class="lg:hidden bg-[#0a3d62] text-white flex justify-between items-center p-4 shadow-md sticky top-0 z-40">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 rounded-lg bg-gradient-to-br from-[#bda065] to-[#9c814b] flex items-center justify-center font-black text-xl">ر</div>
            <span class="font-black text-lg tracking-wide">إدارة روافد</span>
        </div>
        <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-300 hover:text-white focus:outline-none">
            <svg class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
        </button>
    </div>

    <div class="flex h-screen overflow-hidden">
        
        <aside 
            :class="mobileMenuOpen ? 'translate-x-0' : 'translate-x-full lg:translate-x-0'"
            class="fixed lg:static inset-y-0 right-0 w-64 bg-[#0a3d62] text-white flex flex-col shadow-2xl lg:shadow-none z-50 transition-transform duration-300 ease-in-out shrink-0"
        >
            <div class="p-6 flex items-center gap-3 border-b border-white/10">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-[#bda065] to-[#9c814b] flex items-center justify-center font-black text-2xl shadow-[0_0_15px_rgba(189,160,101,0.4)]">ر</div>
                <div class="flex flex-col">
                    <span class="font-black text-xl tracking-wide leading-tight">روافد<span class="text-[#bda065]">.</span></span>
                    <span class="text-[10px] font-bold text-gray-400 tracking-widest uppercase">Admin Panel</span>
                </div>
                <button @click="mobileMenuOpen = false" class="mr-auto lg:hidden text-gray-400 hover:text-white">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            <nav class="flex-1 overflow-y-auto p-4 space-y-2 custom-scrollbar">
                
                <p class="px-4 text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 mt-4">التحليلات والمبيعات</p>
                
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#bda065] text-white shadow-lg' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                    <span class="text-sm font-bold">نظرة عامة</span>
                </a>

                <a href="{{ route('admin.requests') }}" class="flex items-center justify-between px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.requests') ? 'bg-[#bda065] text-white shadow-lg' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    <div class="flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        <span class="text-sm font-bold">طلبات المستشفيات</span>
                    </div>
                </a>

                <p class="px-4 text-[10px] font-black text-gray-400 uppercase tracking-widest mb-2 mt-8">الكوادر والوظائف</p>

                <a href="{{ route('admin.jobs') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.jobs') ? 'bg-[#bda065] text-white shadow-lg' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span class="text-sm font-bold">إعلانات الوظائف</span>
                </a>

                <a href="{{ route('admin.import') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl transition-all {{ request()->routeIs('admin.import') ? 'bg-[#bda065] text-white shadow-lg' : 'text-gray-300 hover:bg-white/5 hover:text-white' }}">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                    <span class="text-sm font-bold">استيراد السير الذاتية</span>
                </a>

            </nav>

            <div class="p-4 border-t border-white/10 space-y-2">
                <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-gray-400 hover:bg-white/5 hover:text-white transition-colors">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    <span class="text-sm font-bold">زيارة الموقع</span>
                </a>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 rounded-xl text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        <span class="text-sm font-bold">تسجيل الخروج</span>
                    </button>
                </form>
            </div>
        </aside>

        <div x-show="mobileMenuOpen" @click="mobileMenuOpen = false" x-cloak class="fixed inset-0 bg-black/50 z-40 lg:hidden"></div>

        <main class="flex-1 overflow-y-auto w-full bg-[#f8fafc]">
            {{ $slot }}
        </main>

    </div>

    @livewireScripts
</body>
</html>