@if($layout === 'admin')

<x-app-layout>
    <x-slot name="header">ติดตามสถานะการซ่อม</x-slot>
    <div class="p-6">
        <div class="max-w-2xl mx-auto">
            @include('public.track-content')
        </div>
    </div>
</x-app-layout>

@elseif($layout === 'technician')

<x-technician-layout>
    <x-slot name="header">ติดตามสถานะการซ่อม</x-slot>
    <div class="max-w-2xl mx-auto">
        @include('public.track-content')
    </div>
</x-technician-layout>

@elseif($layout === 'user')

<x-user-layout>
    <x-slot name="header">ติดตามสถานะการซ่อม</x-slot>
    <div class="max-w-2xl mx-auto">
        @include('public.track-content')
    </div>
</x-user-layout>

@else

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ติดตามสถานะการซ่อม — โรงพยาบาลพระปกเกล้า</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f8fafc] min-h-screen">

    <div class="h-1 bg-gradient-to-r from-[#1e3a5f] to-[#2563eb]"></div>

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-2xl mx-auto px-4 py-3.5 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-8 h-8 bg-[#1e3a5f] rounded-lg flex items-center justify-center shrink-0">
                    <span class="text-white text-sm">🔧</span>
                </div>
                <div>
                    <div class="font-bold text-[#1e293b] text-sm leading-tight">ระบบแจ้งซ่อม IT</div>
                    <div class="text-xs text-gray-400 leading-none hidden sm:block">โรงพยาบาลพระปกเกล้า</div>
                </div>
            </a>
            <div class="flex items-center gap-3 text-sm">
                <a href="{{ route('public.repair') }}"
                   class="flex items-center gap-1.5 text-gray-500 hover:text-[#2563eb] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    <span class="hidden sm:inline">แจ้งซ่อม</span>
                </a>
                <a href="{{ route('login') }}"
                   class="text-xs bg-[#1e3a5f] text-white px-3 py-1.5 rounded-lg hover:bg-[#1d4ed8] transition-colors font-medium">
                    เจ้าหน้าที่
                </a>
            </div>
        </div>
    </nav>

    <div class="bg-gradient-to-r from-[#1e3a5f] to-[#1d4ed8] text-white py-8 px-4">
        <div class="max-w-2xl mx-auto text-center">
            <div class="w-12 h-12 bg-white/15 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold">ติดตามสถานะการซ่อม</h1>
            <p class="text-blue-200 text-sm mt-1">กรอกเลขที่ใบแจ้งซ่อมเพื่อตรวจสอบสถานะ</p>
        </div>
    </div>

    <div class="max-w-2xl mx-auto px-4 py-6">
        @include('public.track-content')
        <p class="text-center text-xs text-gray-300 mt-4">โรงพยาบาลพระปกเกล้า · ระบบแจ้งซ่อม IT</p>
    </div>

</body>
</html>

@endif
