<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบแจ้งซ่อม IT — ผู้ใช้งาน</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 font-sans antialiased">
<div class="flex h-screen overflow-hidden">

    <!-- Sidebar น้ำเงิน User -->
    <aside class="w-56 bg-blue-800 fixed h-full flex flex-col z-30 shrink-0">

        <!-- Logo -->
        <div class="p-4 border-b border-blue-700">
            <a href="{{ route('user.dashboard') }}" class="flex items-center gap-2.5">
                <div class="w-9 h-9 bg-blue-600 rounded-xl flex items-center justify-center shrink-0">
                    <span class="text-white text-base">🏥</span>
                </div>
                <div>
                    <div class="text-white font-semibold text-sm leading-tight">ระบบแจ้งซ่อม IT</div>
                    <div class="text-blue-300 text-xs">สำหรับผู้ใช้งาน</div>
                </div>
            </a>
        </div>

        <!-- Nav -->
        <nav class="flex-1 p-3 space-y-1 overflow-y-auto">
            <p class="text-blue-400 text-xs uppercase tracking-wider px-3 pt-2 pb-1">เมนูหลัก</p>

            <a href="{{ route('user.dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                      {{ request()->routeIs('user.dashboard') ? 'bg-blue-600 text-white shadow-sm' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                ใบแจ้งซ่อมของฉัน
            </a>

            <a href="{{ route('user.repair.create') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium transition-colors
                      {{ request()->routeIs('user.repair.create') ? 'bg-blue-600 text-white shadow-sm' : 'text-blue-200 hover:bg-blue-700 hover:text-white' }}">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                แจ้งซ่อมใหม่
            </a>

            <p class="text-blue-400 text-xs uppercase tracking-wider px-3 pt-4 pb-1">ลิงก์ด่วน</p>

            <a href="{{ route('track') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-blue-200 hover:bg-blue-700 hover:text-white transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                ติดตามสถานะ
            </a>

            <a href="{{ route('home') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-blue-200 hover:bg-blue-700 hover:text-white transition-colors">
                <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
                หน้าแรก
            </a>
        </nav>

        <!-- User Info + Logout -->
        <div class="p-4 border-t border-blue-700">
            <div class="flex items-center gap-2.5 mb-3">
                <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-bold shrink-0">
                    {{ mb_substr(Auth::user()->name, 0, 1) }}
                </div>
                <div class="min-w-0">
                    <div class="text-white text-xs font-semibold truncate">{{ Auth::user()->name }}</div>
                    <div class="text-blue-400 text-xs">ผู้ใช้งานทั่วไป</div>
                </div>
            </div>
            <a href="{{ route('profile.edit') }}"
               class="flex items-center gap-2 text-blue-300 hover:text-white text-xs px-2 py-1.5 rounded-lg hover:bg-blue-700 mb-1 transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                ตั้งค่าโปรไฟล์
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="w-full flex items-center gap-2 text-blue-300 hover:text-white text-xs px-2 py-1.5 rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    ออกจากระบบ
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="ml-56 flex-1 flex flex-col overflow-hidden min-w-0">

        <!-- Top Bar -->
        <div class="bg-white border-b border-gray-200 px-6 h-14 flex items-center justify-between shrink-0 shadow-sm">
            <div class="text-gray-800 font-semibold text-sm">
                {{ $header ?? 'แจ้งซ่อมอุปกรณ์ IT' }}
            </div>
            <div class="flex items-center gap-3">
                <span class="bg-blue-100 text-blue-700 text-xs px-2.5 py-1 rounded-full font-semibold">
                    👤 ผู้ใช้งาน
                </span>
                <span class="text-sm text-gray-600 hidden sm:block">{{ Auth::user()->name }}</span>
            </div>
        </div>

        <!-- Page Content -->
        <div class="flex-1 overflow-auto bg-gray-50 p-6">
            {{ $slot }}
        </div>
    </main>
</div>
</body>
</html>
