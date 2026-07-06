@if($layout === 'admin')

<x-app-layout>
    <x-slot name="header">ส่งใบแจ้งซ่อมสำเร็จ</x-slot>
    <div class="p-6 flex justify-center">
        <div class="w-full max-w-sm">
            @include('public.success-card')
        </div>
    </div>
</x-app-layout>

@elseif($layout === 'technician')

<x-technician-layout>
    <x-slot name="header">ส่งใบแจ้งซ่อมสำเร็จ</x-slot>
    <div class="flex justify-center">
        <div class="w-full max-w-sm">
            @include('public.success-card')
        </div>
    </div>
</x-technician-layout>

@elseif($layout === 'user')

<x-user-layout>
    <x-slot name="header">ส่งใบแจ้งซ่อมสำเร็จ</x-slot>
    <div class="flex justify-center">
        <div class="w-full max-w-sm">
            @include('public.success-card')
        </div>
    </div>
</x-user-layout>

@else

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ส่งใบแจ้งซ่อมสำเร็จ — โรงพยาบาลพระปกเกล้า</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f8fafc] min-h-screen flex flex-col">

    <div class="h-1 bg-gradient-to-r from-green-500 to-[#2563eb]"></div>

    <nav class="bg-white shadow-sm">
        <div class="max-w-lg mx-auto px-4 py-3.5 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-8 h-8 bg-[#1e3a5f] rounded-lg flex items-center justify-center shrink-0">
                    <span class="text-white text-sm">🔧</span>
                </div>
                <div class="font-bold text-[#1e293b] text-sm">ระบบแจ้งซ่อม IT</div>
            </a>
            <a href="{{ route('login') }}"
               class="text-xs bg-[#1e3a5f] text-white px-3 py-1.5 rounded-lg hover:bg-[#1d4ed8] transition-colors font-medium">
                เจ้าหน้าที่
            </a>
        </div>
    </nav>

    <div class="flex-1 flex flex-col justify-center py-10 px-4">
        <div class="max-w-sm mx-auto w-full">
            @include('public.success-card')
            <p class="text-center text-xs text-gray-300 mt-5">โรงพยาบาลพระปกเกล้า · กลุ่มงานเทคโนโลยีสารสนเทศ</p>
        </div>
    </div>

</body>
</html>

@endif
