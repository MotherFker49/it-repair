<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ขอบคุณสำหรับการประเมิน — โรงพยาบาลพระปกเกล้า</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex flex-col font-sans antialiased">

    <div class="h-1 bg-gradient-to-r from-yellow-400 to-green-500"></div>

    <nav class="bg-white shadow-sm">
        <div class="max-w-lg mx-auto px-4 py-3.5 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-700 rounded-lg flex items-center justify-center shrink-0">
                    <span class="text-white font-bold text-sm">IT</span>
                </div>
                <div class="font-bold text-gray-900 text-sm">ระบบแจ้งซ่อม IT</div>
            </a>
        </div>
    </nav>

    <div class="flex-1 flex items-center justify-center px-4 py-12">
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-8 max-w-sm w-full text-center">

            {{-- Icon --}}
            <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-5 text-4xl shadow-inner">
                ⭐
            </div>

            <h1 class="text-xl font-bold text-gray-900 mb-2">ขอบคุณสำหรับการประเมิน!</h1>
            <p class="text-gray-500 text-sm mb-6">ความคิดเห็นของคุณมีคุณค่าสำหรับการปรับปรุงบริการ</p>

            {{-- คะแนนดาว --}}
            <div class="bg-gray-50 rounded-xl p-4 mb-6">
                <p class="text-xs text-gray-400 mb-2 font-medium">คะแนนที่ให้</p>
                <div class="flex justify-center gap-1 mb-1.5">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="text-3xl {{ $i <= $repair->rating ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                    @endfor
                </div>
                <p class="text-sm font-bold {{ $repair->rating >= 4 ? 'text-green-600' : ($repair->rating === 3 ? 'text-amber-500' : 'text-red-500') }}">
                    {{ $repair->ratingLabel() }} ({{ $repair->rating }}/5)
                </p>
                @if ($repair->rating_comment)
                    <p class="mt-3 text-sm text-gray-500 text-left bg-white rounded-lg px-3 py-2 border border-gray-100">
                        "{{ $repair->rating_comment }}"
                    </p>
                @endif
            </div>

            {{-- ข้อมูลงาน --}}
            <p class="text-xs text-gray-400 mb-6">
                งานซ่อมเลขที่ <span class="font-mono font-bold text-gray-600">{{ $repair->ticket_no }}</span>
            </p>

            {{-- ปุ่ม --}}
            <div class="space-y-2">
                <a href="{{ route('home') }}"
                   class="block w-full bg-blue-700 hover:bg-blue-800 text-white py-3 rounded-xl font-semibold text-sm transition-colors">
                    🏠 กลับหน้าแรก
                </a>
                <a href="{{ route('public.repair') }}"
                   class="block w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-xl font-semibold text-sm transition-colors">
                    🔧 แจ้งซ่อมใหม่
                </a>
            </div>

        </div>
    </div>

    <footer class="py-6 text-center text-xs text-gray-400">
        © {{ date('Y') }} โรงพยาบาลพระปกเกล้า · กลุ่มงานเทคโนโลยีสารสนเทศ
    </footer>

</body>
</html>
