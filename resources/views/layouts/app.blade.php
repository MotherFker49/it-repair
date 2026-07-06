<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ระบบแจ้งซ่อม IT') }}</title>
    <style>[x-cloak]{display:none!important}</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f8fafc] font-sans antialiased" x-data="{ sidebarOpen: false }">

<div class="flex h-screen overflow-hidden">

    {{-- ===== MOBILE OVERLAY ===== --}}
    <div x-cloak
         x-show="sidebarOpen"
         x-transition:enter="transition-opacity duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="sidebarOpen = false"
         class="fixed inset-0 bg-black/40 z-20 lg:hidden"></div>

    {{-- ===== SIDEBAR ===== --}}
    <aside class="fixed top-0 left-0 bottom-0 w-60 bg-[#1e3a5f] z-30 flex flex-col
                  transition-transform duration-200 ease-in-out lg:translate-x-0"
           :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'">

        {{-- Logo --}}
        <div class="py-4 px-5 border-b border-blue-800/60 shrink-0">
            <a href="{{ route('dashboard') }}" class="flex items-center gap-3" @click="sidebarOpen = false">
                <div class="w-9 h-9 bg-[#2563eb] rounded-xl flex items-center justify-center shrink-0 shadow-sm">
                    <span class="text-white text-base leading-none">🔧</span>
                </div>
                <div>
                    <div class="text-white font-bold text-sm leading-tight">ระบบแจ้งซ่อม IT</div>
                    <div class="text-blue-300 text-xs leading-none mt-0.5">โรงพยาบาลพระปกเกล้า</div>
                </div>
            </a>
        </div>

        {{-- Nav Menu --}}
        <nav class="flex-1 px-3 py-4 overflow-y-auto space-y-0.5">

            {{-- OVERVIEW --}}
            <p class="text-blue-400 text-xs uppercase tracking-wider px-4 pt-1 pb-1.5 font-medium">Overview</p>

            <a href="{{ route('home') }}" @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors
                      {{ request()->routeIs('home') ? 'bg-[#2563eb] text-white shadow-sm' : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                หน้าแรก
            </a>

            <a href="{{ route('dashboard') }}" @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors
                      {{ request()->routeIs('dashboard') ? 'bg-[#2563eb] text-white shadow-sm' : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                Dashboard
            </a>

            {{-- TECHNICIAN --}}
            <p class="text-blue-400 text-xs uppercase tracking-wider px-4 pt-5 pb-1.5 font-medium">Technician</p>

            <a href="{{ route('technician.index') }}" @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors
                      {{ request()->routeIs('technician.index') || request()->routeIs('technician.show') ? 'bg-[#2563eb] text-white shadow-sm' : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                งานซ่อม
            </a>

            <a href="{{ route('technician.search') }}" @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors
                      {{ request()->routeIs('technician.search') ? 'bg-[#2563eb] text-white shadow-sm' : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                ค้นหางานซ่อม
            </a>

            {{-- MANAGEMENT --}}
            <p class="text-blue-400 text-xs uppercase tracking-wider px-4 pt-5 pb-1.5 font-medium">Management</p>

            <a href="{{ route('repairs.index') }}" @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors
                      {{ request()->routeIs('repairs.*') ? 'bg-[#2563eb] text-white shadow-sm' : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                ใบแจ้งซ่อมทั้งหมด
            </a>

            <a href="{{ route('equipments.index') }}" @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors
                      {{ request()->routeIs('equipments.*') ? 'bg-[#2563eb] text-white shadow-sm' : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                ทะเบียนอุปกรณ์
            </a>

            {{-- QUICK --}}
            <p class="text-blue-400 text-xs uppercase tracking-wider px-4 pt-5 pb-1.5 font-medium">Quick</p>

            <a href="{{ route('public.repair') }}" @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors
                      {{ request()->routeIs('public.repair') ? 'bg-[#2563eb] text-white shadow-sm' : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                แจ้งซ่อมใหม่
            </a>

            <a href="{{ route('track') }}" @click="sidebarOpen = false"
               class="flex items-center gap-3 px-4 py-2.5 text-sm rounded-lg transition-colors
                      {{ request()->routeIs('track*') ? 'bg-[#2563eb] text-white shadow-sm' : 'text-blue-200 hover:bg-blue-800/60 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
                ติดตามสถานะ
            </a>

        </nav>

        {{-- User + Logout --}}
        <div class="p-4 border-t border-blue-800/60 shrink-0">
            <div class="flex items-center gap-2.5 mb-3">
                <div class="w-8 h-8 bg-[#2563eb] rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0">
                    {{ mb_substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="min-w-0 flex-1">
                    <div class="text-white text-xs font-semibold truncate">{{ Auth::user()->name }}</div>
                    <span class="inline-block bg-white/10 text-blue-200 text-xs px-1.5 py-0.5 rounded mt-0.5">
                        👨‍💼 Admin
                    </span>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-2 text-blue-300 hover:text-white text-xs px-2 py-1.5 rounded-lg hover:bg-blue-800/60 mb-1 transition-colors w-full">
                <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                ตั้งค่าโปรไฟล์
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-2 text-blue-300 hover:text-white text-xs px-2 py-1.5 rounded-lg hover:bg-blue-800/60 transition-colors">
                    <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    ออกจากระบบ
                </button>
            </form>
        </div>

    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <main class="lg:ml-60 flex-1 flex flex-col overflow-hidden min-w-0">

        {{-- Header --}}
        <header class="bg-white border-b border-gray-200 h-14 flex items-center justify-between px-4 sm:px-6 shrink-0 shadow-sm">
            <div class="flex items-center gap-3">
                {{-- Mobile hamburger --}}
                <button @click="sidebarOpen = !sidebarOpen"
                        class="lg:hidden p-1.5 rounded-lg text-gray-400 hover:bg-gray-100 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
                {{-- Page title --}}
                <div class="font-semibold text-[#1e293b] text-sm">
                    {{ $header ?? 'ระบบแจ้งซ่อม IT' }}
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-1 rounded-full font-semibold hidden sm:inline">
                    👨‍💼 Admin
                </span>
                <span class="text-sm text-[#64748b] hidden sm:block">{{ Auth::user()->name }}</span>
            </div>
        </header>

        {{-- Page Content --}}
        <div class="flex-1 overflow-auto bg-[#f8fafc]">
            {{ $slot }}
        </div>

    </main>

</div>
</body>
</html>
