<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ประเมินความพึงพอใจ — โรงพยาบาลพระปกเกล้า</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-50 min-h-screen flex flex-col font-sans antialiased">

    <div class="h-1 bg-gradient-to-r from-yellow-400 to-blue-600"></div>

    <nav class="bg-white shadow-sm sticky top-0 z-50">
        <div class="max-w-lg mx-auto px-4 py-3.5 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <div class="w-8 h-8 bg-blue-700 rounded-lg flex items-center justify-center shrink-0">
                    <span class="text-white font-bold text-sm">IT</span>
                </div>
                <div>
                    <div class="font-bold text-gray-900 text-sm leading-tight">ระบบแจ้งซ่อม IT</div>
                    <div class="text-xs text-gray-400 leading-none hidden sm:block">โรงพยาบาลพระปกเกล้า</div>
                </div>
            </a>
            <a href="{{ route('track') }}" class="text-sm text-gray-400 hover:text-gray-600 transition-colors">ติดตามสถานะ</a>
        </div>
    </nav>

    {{-- Header --}}
    <div class="bg-gradient-to-br from-blue-700 to-blue-900 text-white py-8">
        <div class="max-w-lg mx-auto px-4 text-center">
            <div class="text-5xl mb-3">⭐</div>
            <h1 class="text-xl font-bold">ประเมินความพึงพอใจ</h1>
            <p class="text-blue-200 text-sm mt-1">งานซ่อมเลขที่ <span class="font-mono font-bold text-white">{{ $repair->ticket_no }}</span></p>
        </div>
    </div>

    <div class="flex-1 max-w-lg mx-auto w-full px-4 py-6 space-y-4">

        @if ($repair->isRated())
        {{-- ประเมินแล้ว --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 text-center">
            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4 text-3xl">⭐</div>
            <h2 class="font-bold text-gray-900 text-lg mb-1">ประเมินแล้ว</h2>
            <p class="text-gray-500 text-sm mb-4">คุณได้ประเมินงานซ่อมนี้เรียบร้อยแล้ว</p>
            <div class="flex justify-center gap-1 mb-2">
                @for ($i = 1; $i <= 5; $i++)
                    <span class="text-3xl {{ $i <= $repair->rating ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                @endfor
            </div>
            <p class="text-sm font-semibold text-gray-700">{{ $repair->ratingLabel() }} ({{ $repair->rating }}/5)</p>
            @if ($repair->rating_comment)
                <p class="mt-3 text-sm text-gray-500 bg-gray-50 rounded-xl px-4 py-3 text-left">"{{ $repair->rating_comment }}"</p>
            @endif
            <a href="{{ route('home') }}" class="mt-5 inline-block text-sm text-blue-600 hover:underline">← กลับหน้าแรก</a>
        </div>

        @else
        {{-- ข้อมูลงานซ่อม --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">
            <h3 class="font-semibold text-gray-900 text-sm mb-3 flex items-center gap-2">
                <span class="w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center text-blue-700 text-xs">📋</span>
                ข้อมูลงานซ่อม
            </h3>
            <div class="space-y-2 text-sm">
                <div class="flex justify-between">
                    <span class="text-gray-500">เลขที่ใบแจ้งซ่อม</span>
                    <span class="font-mono font-bold text-blue-700">{{ $repair->ticket_no }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">อุปกรณ์</span>
                    <span class="font-medium text-gray-800 text-right">{{ $repair->equipment?->name ?? 'ไม่ระบุ' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">สถานที่</span>
                    <span class="font-medium text-gray-800">{{ $repair->department ?? '—' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-500">ช่างผู้ซ่อม</span>
                    <span class="font-medium text-gray-800">{{ $repair->technician?->name ?? 'ไม่ระบุ' }}</span>
                </div>
                @if ($repair->resolved_at)
                <div class="flex justify-between">
                    <span class="text-gray-500">วันที่เสร็จ</span>
                    <span class="font-medium text-gray-800">{{ $repair->resolved_at->format('d/m/Y') }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- ฟอร์มประเมิน --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5">

            @if (session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('rating.store', $repair) }}" method="POST">
                @csrf

                {{-- ส่วนดาว --}}
                <div class="mb-6 text-center">
                    <p class="font-semibold text-gray-800 mb-4">คุณพอใจกับการให้บริการมากแค่ไหน?</p>

                    <div class="flex justify-center gap-2 mb-3">
                        @for ($i = 1; $i <= 5; $i++)
                        <button type="button" class="star-btn text-5xl text-gray-300 transition-colors leading-none focus:outline-none"
                                data-value="{{ $i }}">★</button>
                        @endfor
                    </div>

                    <p id="rating-label" class="text-sm font-medium text-gray-500 h-5"></p>
                    <input type="hidden" name="rating" id="rating-input" value="">

                    @error('rating')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- ความคิดเห็น --}}
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">
                        ความคิดเห็นเพิ่มเติม <span class="text-gray-400 font-normal">(ถ้ามี)</span>
                    </label>
                    <textarea name="rating_comment" rows="3"
                              class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 resize-none"
                              placeholder="แสดงความคิดเห็นเพิ่มเติม...">{{ old('rating_comment') }}</textarea>
                </div>

                <button type="submit"
                        class="w-full bg-blue-700 hover:bg-blue-800 text-white py-3 rounded-xl font-semibold text-sm transition-colors shadow-sm mb-3">
                    ส่งคะแนน
                </button>
            </form>

            <a href="{{ route('home') }}"
               class="block w-full text-center bg-gray-100 hover:bg-gray-200 text-gray-600 py-3 rounded-xl font-semibold text-sm transition-colors">
                🏠 กลับหน้าแรก
            </a>
        </div>
        @endif

    </div>

    <footer class="py-6 text-center text-xs text-gray-400">
        © {{ date('Y') }} โรงพยาบาลพระปกเกล้า · กลุ่มงานเทคโนโลยีสารสนเทศ
    </footer>

    <script>
        const stars = document.querySelectorAll('.star-btn');
        const ratingInput = document.getElementById('rating-input');
        const ratingLabel = document.getElementById('rating-label');
        const labels = ['', 'ไม่พอใจ', 'ควรปรับปรุง', 'พอใช้', 'ดี', 'ดีมาก'];

        stars.forEach((star, index) => {
            star.addEventListener('click', () => {
                const value = index + 1;
                ratingInput.value = value;
                ratingLabel.textContent = labels[value];
                ratingLabel.className = 'text-sm font-semibold h-5 ' + (value >= 4 ? 'text-green-600' : value === 3 ? 'text-amber-500' : 'text-red-500');
                stars.forEach((s, i) => {
                    s.classList.toggle('text-yellow-400', i <= index);
                    s.classList.toggle('text-gray-300', i > index);
                });
            });

            star.addEventListener('mouseover', () => {
                stars.forEach((s, i) => {
                    s.classList.toggle('text-yellow-300', i <= index);
                    if (i > index) s.classList.add('text-gray-300');
                });
            });

            star.addEventListener('mouseout', () => {
                const current = parseInt(ratingInput.value) || 0;
                stars.forEach((s, i) => {
                    s.classList.remove('text-yellow-300');
                    s.classList.toggle('text-yellow-400', i < current);
                    s.classList.toggle('text-gray-300', i >= current);
                });
            });
        });
    </script>

</body>
</html>
