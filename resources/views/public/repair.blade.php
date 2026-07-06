@if($layout === 'admin')

<x-app-layout>
    <x-slot name="header">แจ้งซ่อมอุปกรณ์ IT</x-slot>
    <div class="p-6">
        <div class="max-w-2xl mx-auto">
            @include('public.repair-content')
        </div>
    </div>
</x-app-layout>

@elseif($layout === 'technician')

<x-technician-layout>
    <x-slot name="header">แจ้งซ่อมอุปกรณ์ IT</x-slot>
    <div class="max-w-2xl mx-auto">
        @include('public.repair-content')
    </div>
</x-technician-layout>

@elseif($layout === 'user')

<x-user-layout>
    <x-slot name="header">แจ้งซ่อมอุปกรณ์ IT</x-slot>
    <div class="max-w-2xl mx-auto">
        @include('public.repair-content')
    </div>
</x-user-layout>

@else

{{-- Standalone fallback --}}
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>แจ้งซ่อมอุปกรณ์ IT — โรงพยาบาลพระปกเกล้า</title>
    <script>if (localStorage.getItem('darkMode') === 'true') { document.documentElement.classList.add('dark'); }</script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen transition-colors duration-200">

    <div class="h-1 bg-gradient-to-r from-blue-600 to-blue-800"></div>

    <nav class="bg-white dark:bg-gray-800 shadow-sm sticky top-0 z-50 transition-colors duration-200">
        <div class="max-w-2xl mx-auto px-4 py-3.5 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-700 rounded-lg flex items-center justify-center shrink-0">
                    <span class="text-white font-bold text-sm">IT</span>
                </div>
                <div>
                    <div class="font-bold text-gray-900 dark:text-gray-100 text-sm leading-tight">ระบบแจ้งซ่อม IT</div>
                    <div class="text-xs text-gray-400 dark:text-gray-500 leading-none hidden sm:block">โรงพยาบาลพระปกเกล้า</div>
                </div>
            </a>
            <div class="flex items-center gap-3 text-sm">
                <a href="{{ route('login') }}" class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">เจ้าหน้าที่</a>
                <button onclick="toggleDarkMode()"
                        class="p-2 rounded-lg bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors duration-200 text-base leading-none">
                    <span class="dark-icon">🌙</span>
                </button>
            </div>
        </div>
    </nav>

    <div class="bg-gradient-to-r from-blue-700 to-blue-800 text-white py-8 px-4">
        <div class="max-w-2xl mx-auto text-center">
            <div class="w-12 h-12 bg-white/15 rounded-2xl flex items-center justify-center mx-auto mb-3">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <h1 class="text-xl font-bold">แจ้งซ่อมอุปกรณ์ IT</h1>
            <p class="text-blue-200 text-sm mt-1">กรอกข้อมูลด้านล่าง เจ้าหน้าที่จะรับเรื่องและดำเนินการให้เร็วที่สุด</p>
        </div>
    </div>

    <div class="max-w-2xl mx-auto px-4 py-6">
        @include('public.repair-content')
    </div>

<script>
function toggleDarkMode() {
    const isDark = document.documentElement.classList.toggle('dark');
    localStorage.setItem('darkMode', isDark);
    document.querySelectorAll('.dark-icon').forEach(icon => {
        icon.textContent = isDark ? '☀️' : '🌙';
    });
}
document.addEventListener('DOMContentLoaded', () => {
    const isDark = document.documentElement.classList.contains('dark');
    document.querySelectorAll('.dark-icon').forEach(icon => {
        icon.textContent = isDark ? '☀️' : '🌙';
    });
});
</script>
</body>
</html>

@endif
