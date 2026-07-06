@auth
    @if(Auth::user()->hasRole('admin'))
        <script>window.location="{{ route('dashboard') }}"</script>
    @elseif(Auth::user()->hasRole('technician'))
        <script>window.location="{{ route('technician.index') }}"</script>
    @elseif(Auth::user()->hasRole('user'))
        <script>window.location="{{ route('user.dashboard') }}"</script>
    @endif
@endauth
<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ระบบแจ้งซ่อมอุปกรณ์ IT — โรงพยาบาลพระปกเกล้า</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f8fafc] min-h-screen font-sans antialiased">

{{-- ===== 1. TOP BAR ===== --}}
<div class="bg-[#1e3a5f] h-8 flex items-center">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 w-full flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="text-sm leading-none">🏥</span>
            <span class="text-white text-sm font-medium tracking-wide">โรงพยาบาลพระปกเกล้า</span>
        </div>
        <span class="text-[#93c5fd] text-xs hidden sm:block">สายด่วน IT: 039-XXXXXX</span>
    </div>
</div>

{{-- ===== 2. NAVBAR ===== --}}
<nav class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 h-14 flex items-center justify-between">
        <div class="flex items-center gap-2.5">
            <div class="w-8 h-8 bg-[#2563eb] rounded-lg flex items-center justify-center shrink-0 shadow-sm">
                <span class="text-white text-sm leading-none">🔧</span>
            </div>
            <div>
                <div class="font-bold text-[#1e3a5f] text-sm leading-tight">ระบบแจ้งซ่อมอุปกรณ์ IT</div>
                <div class="text-[#64748b] text-xs leading-none hidden sm:block">โรงพยาบาลพระปกเกล้า</div>
            </div>
        </div>
        <a href="{{ route('login') }}"
           class="bg-blue-700 hover:bg-blue-800 text-white px-4 py-1.5 rounded text-sm font-medium transition-colors shadow-sm">
            เข้าสู่ระบบ
        </a>
    </div>
</nav>

{{-- ===== 3. HERO SECTION ===== --}}
<div class="bg-gradient-to-br from-[#1e3a5f] to-[#1d4ed8]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">

            {{-- ซ้าย: ข้อความ --}}
            <div>
                <span class="inline-block bg-blue-800/50 text-blue-200 rounded-full text-xs px-3 py-1 mb-6 border border-blue-700/50">
                    โรงพยาบาลพระปกเกล้า · จังหวัดจันทบุรี
                </span>
                <h1 class="text-4xl sm:text-5xl font-bold text-white leading-tight mb-4">
                    ระบบแจ้งซ่อม<br>
                    <span class="text-[#93c5fd]">อุปกรณ์ IT</span>
                </h1>
                <p class="text-blue-200 text-sm leading-relaxed mb-8 max-w-sm">
                    บริหารจัดการงานซ่อมอุปกรณ์ IT อย่างเป็นระบบ<br>
                    ติดตามสถานะแบบ Real-time ทุกที่ทุกเวลา
                </p>
                <div class="flex flex-col sm:flex-row gap-3">
                    @auth
                    <a href="{{ route('public.repair') }}"
                       class="inline-flex items-center justify-center gap-2 bg-white text-blue-800 font-semibold px-6 py-2.5 rounded-lg hover:bg-blue-50 transition-colors shadow-md">
                        🔧 แจ้งซ่อมเลย
                    </a>
                    <a href="{{ route('track') }}"
                       class="inline-flex items-center justify-center gap-2 border border-white/50 text-white px-6 py-2.5 rounded-lg hover:bg-white/10 hover:border-white transition-colors">
                        🔍 ติดตามสถานะ
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center gap-2 bg-white text-blue-800 font-semibold px-6 py-2.5 rounded-lg hover:bg-blue-50 transition-colors shadow-md">
                        🔧 แจ้งซ่อมเลย
                    </a>
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center justify-center gap-2 border border-white/50 text-white px-6 py-2.5 rounded-lg hover:bg-white/10 hover:border-white transition-colors">
                        🔍 ติดตามสถานะ
                    </a>
                    @endauth
                </div>
            </div>

            {{-- ขวา: mockup card --}}
            <div class="hidden lg:block">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-5 border border-white/20 shadow-2xl">

                    {{-- mock browser bar --}}
                    <div class="bg-black/20 rounded-xl px-3 py-2 mb-4 flex items-center gap-2">
                        <div class="flex gap-1.5">
                            <div class="w-2.5 h-2.5 rounded-full bg-red-400/80"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-yellow-400/80"></div>
                            <div class="w-2.5 h-2.5 rounded-full bg-green-400/80"></div>
                        </div>
                        <div class="flex-1 bg-white/10 rounded-md text-center text-white/50 text-xs py-0.5 mx-2">
                            it-repair.ppkhos.go.th/dashboard
                        </div>
                    </div>

                    {{-- mock title --}}
                    <div class="text-white/70 text-xs font-medium mb-3 flex items-center gap-2">
                        <span class="w-1.5 h-1.5 bg-green-400 rounded-full animate-pulse"></span>
                        Dashboard ระบบแจ้งซ่อม IT
                    </div>

                    {{-- mock stats --}}
                    <div class="grid grid-cols-3 gap-2.5 mb-4">
                        <div class="bg-blue-500/30 rounded-xl p-3 text-center border border-blue-400/30">
                            <div class="text-white font-bold text-xl leading-none mb-1">12</div>
                            <div class="text-blue-200 text-xs">งานใหม่</div>
                        </div>
                        <div class="bg-yellow-500/25 rounded-xl p-3 text-center border border-yellow-400/30">
                            <div class="text-white font-bold text-xl leading-none mb-1">5</div>
                            <div class="text-yellow-200 text-xs">กำลังซ่อม</div>
                        </div>
                        <div class="bg-green-500/25 rounded-xl p-3 text-center border border-green-400/30">
                            <div class="text-white font-bold text-xl leading-none mb-1">48</div>
                            <div class="text-green-200 text-xs">เสร็จแล้ว</div>
                        </div>
                    </div>

                    {{-- mock table --}}
                    <div class="bg-black/20 rounded-xl overflow-hidden">
                        <div class="px-3 py-2 border-b border-white/10">
                            <span class="text-white/70 text-xs font-medium">รายการงานซ่อมล่าสุด</span>
                        </div>
                        <div class="divide-y divide-white/10">
                            <div class="px-3 py-2.5 flex items-center justify-between">
                                <div>
                                    <div class="text-white text-xs font-medium">REP-2568-001</div>
                                    <div class="text-blue-300 text-xs mt-0.5">คอมพิวเตอร์ไม่เปิด · ห้องบัตร ชั้น 2</div>
                                </div>
                                <span class="bg-blue-500/50 text-blue-100 text-xs px-2 py-0.5 rounded-full whitespace-nowrap">ใหม่</span>
                            </div>
                            <div class="px-3 py-2.5 flex items-center justify-between">
                                <div>
                                    <div class="text-white text-xs font-medium">REP-2568-002</div>
                                    <div class="text-blue-300 text-xs mt-0.5">เครื่องพิมพ์กระดาษติด · งานเภสัช</div>
                                </div>
                                <span class="bg-yellow-500/50 text-yellow-100 text-xs px-2 py-0.5 rounded-full whitespace-nowrap">กำลังซ่อม</span>
                            </div>
                            <div class="px-3 py-2.5 flex items-center justify-between">
                                <div>
                                    <div class="text-white text-xs font-medium">REP-2568-003</div>
                                    <div class="text-blue-300 text-xs mt-0.5">เน็ตหลุดบ่อย · สำนักงาน IT</div>
                                </div>
                                <span class="bg-green-500/50 text-green-100 text-xs px-2 py-0.5 rounded-full whitespace-nowrap">เสร็จแล้ว</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

{{-- ===== 4. STATS BAR ===== --}}
<div class="bg-[#1e3a5f] border-y border-blue-800/60">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-5">
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-0 text-center divide-x divide-blue-800/60">
            <div class="px-4 py-1">
                <div class="text-white font-bold text-xl">รวดเร็ว</div>
                <div class="text-[#93c5fd] text-xs mt-0.5">ช่างดำเนินการทันที</div>
            </div>
            <div class="px-4 py-1">
                <div class="text-white font-bold text-xl">24/7</div>
                <div class="text-[#93c5fd] text-xs mt-0.5">ออนไลน์ตลอดเวลา</div>
            </div>
            <div class="px-4 py-1">
                <div class="text-white font-bold text-xl">ครอบคลุม</div>
                <div class="text-[#93c5fd] text-xs mt-0.5">ทุกหน่วยงาน</div>
            </div>
            <div class="px-4 py-1">
                <div class="text-white font-bold text-xl">Real-time</div>
                <div class="text-[#93c5fd] text-xs mt-0.5">ติดตามได้ทันที</div>
            </div>
        </div>
    </div>
</div>

{{-- ===== 5. FEATURE CARDS ===== --}}
<div class="bg-[#f8fafc] py-16 px-4">
    <div class="max-w-5xl mx-auto">

        <div class="text-center mb-10">
            <h2 class="text-2xl font-bold text-[#1e293b] mb-2">บริการของเรา</h2>
            <p class="text-[#64748b] text-sm">เลือกบริการที่ต้องการด้านล่าง</p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

            {{-- Card 1: แจ้งซ่อม --}}
            @auth
            <a href="{{ route('public.repair') }}"
               class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col hover:shadow-md hover:border-blue-200 transition-all duration-200">
            @else
            <a href="{{ route('login') }}"
               class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col hover:shadow-md hover:border-blue-200 transition-all duration-200">
            @endauth
                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:bg-blue-600 group-hover:scale-105 transition-all duration-200">
                    🔧
                </div>
                <h3 class="font-semibold text-[#1e293b] text-base mb-2">แจ้งซ่อมอุปกรณ์</h3>
                <p class="text-[#64748b] text-sm leading-relaxed flex-1">
                    กรอกแบบฟอร์มง่ายๆ พร้อมแนบรูปภาพ ระบบจะแจ้งช่างทันที
                </p>
                <div class="mt-4 text-blue-600 text-sm font-medium group-hover:underline">
                    เริ่มแจ้งซ่อม →
                </div>
            </a>

            {{-- Card 2: ติดตามสถานะ --}}
            @auth
            <a href="{{ route('track') }}"
               class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col hover:shadow-md hover:border-green-200 transition-all duration-200">
            @else
            <a href="{{ route('login') }}"
               class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col hover:shadow-md hover:border-green-200 transition-all duration-200">
            @endauth
                <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:bg-green-600 group-hover:scale-105 transition-all duration-200">
                    🔍
                </div>
                <h3 class="font-semibold text-[#1e293b] text-base mb-2">ติดตามสถานะ</h3>
                <p class="text-[#64748b] text-sm leading-relaxed flex-1">
                    ตรวจสอบความคืบหน้าการซ่อม ด้วยเลขที่ใบแจ้งซ่อม
                </p>
                <div class="mt-4 text-green-600 text-sm font-medium group-hover:underline">
                    ตรวจสอบสถานะ →
                </div>
            </a>

            {{-- Card 3: เจ้าหน้าที่ --}}
            <a href="{{ route('login') }}"
               class="group bg-white rounded-xl shadow-sm border border-gray-100 p-6 flex flex-col hover:shadow-md hover:border-purple-200 transition-all duration-200">
                <div class="w-12 h-12 bg-purple-100 rounded-xl flex items-center justify-center text-2xl mb-4 group-hover:bg-purple-600 group-hover:scale-105 transition-all duration-200">
                    👨‍💻
                </div>
                <h3 class="font-semibold text-[#1e293b] text-base mb-2">สำหรับเจ้าหน้าที่</h3>
                <p class="text-[#64748b] text-sm leading-relaxed flex-1">
                    ช่าง IT และผู้ดูแลระบบ จัดการงานซ่อมได้ครบถ้วน
                </p>
                <div class="mt-4 text-purple-600 text-sm font-medium group-hover:underline">
                    เข้าสู่ระบบ →
                </div>
            </a>

        </div>
    </div>
</div>

{{-- ===== 6. HOW TO USE ===== --}}
<div class="bg-blue-900 py-16 px-4">
    <div class="max-w-5xl mx-auto">

        <div class="text-center mb-12">
            <h2 class="text-2xl font-bold text-white mb-2">วิธีใช้งาน</h2>
            <p class="text-blue-300 text-sm">3 ขั้นตอนง่ายๆ</p>
        </div>

        <div class="flex flex-col sm:flex-row items-start sm:items-start gap-6 sm:gap-0">

            {{-- Step 1 --}}
            <div class="flex-1 flex flex-col items-center text-center px-6">
                <div class="w-14 h-14 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-xl mb-4 shadow-lg">
                    1
                </div>
                <h3 class="font-semibold text-white mb-2">เข้าสู่ระบบ</h3>
                <p class="text-blue-300 text-sm leading-relaxed">
                    Login ด้วย account<br>ของโรงพยาบาล
                </p>
            </div>

            {{-- Arrow --}}
            <div class="hidden sm:flex items-start justify-center pt-5 text-blue-400 text-2xl font-light select-none shrink-0">
                →
            </div>
            <div class="flex sm:hidden w-full justify-center text-blue-400 text-xl">↓</div>

            {{-- Step 2 --}}
            <div class="flex-1 flex flex-col items-center text-center px-6">
                <div class="w-14 h-14 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-xl mb-4 shadow-lg">
                    2
                </div>
                <h3 class="font-semibold text-white mb-2">แจ้งซ่อม</h3>
                <p class="text-blue-300 text-sm leading-relaxed">
                    กรอกข้อมูลอุปกรณ์<br>และปัญหาที่พบ
                </p>
            </div>

            {{-- Arrow --}}
            <div class="hidden sm:flex items-start justify-center pt-5 text-blue-400 text-2xl font-light select-none shrink-0">
                →
            </div>
            <div class="flex sm:hidden w-full justify-center text-blue-400 text-xl">↓</div>

            {{-- Step 3 --}}
            <div class="flex-1 flex flex-col items-center text-center px-6">
                <div class="w-14 h-14 bg-blue-500 rounded-full flex items-center justify-center text-white font-bold text-xl mb-4 shadow-lg">
                    3
                </div>
                <h3 class="font-semibold text-white mb-2">ติดตามสถานะ</h3>
                <p class="text-blue-300 text-sm leading-relaxed">
                    ตรวจสอบความคืบหน้า<br>ได้ทันที
                </p>
            </div>

        </div>
    </div>
</div>

{{-- ===== 7. FOOTER ===== --}}
<footer class="bg-[#0f172a]">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-12">

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-8 mb-8">

            {{-- คอลัมน์ 1 --}}
            <div>
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-9 h-9 bg-blue-700 rounded-xl flex items-center justify-center text-lg shrink-0">
                        🏥
                    </div>
                    <span class="font-bold text-white text-sm">ระบบแจ้งซ่อม IT</span>
                </div>
                <p class="text-gray-400 text-sm leading-relaxed">
                    โรงพยาบาลพระปกเกล้า<br>
                    กลุ่มงานเทคโนโลยีสารสนเทศ<br>
                    จังหวัดจันทบุรี
                </p>
            </div>

            {{-- คอลัมน์ 2 --}}
            <div>
                <h4 class="font-semibold text-white mb-4 text-sm">ลิงก์ด่วน</h4>
                <div class="space-y-2.5">
                    @auth
                    <a href="{{ route('public.repair') }}"
                       class="flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors">
                        <span class="text-blue-400 text-base leading-none">›</span> แจ้งซ่อมอุปกรณ์
                    </a>
                    <a href="{{ route('track') }}"
                       class="flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors">
                        <span class="text-blue-400 text-base leading-none">›</span> ติดตามสถานะ
                    </a>
                    @else
                    <a href="{{ route('login') }}"
                       class="flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors">
                        <span class="text-blue-400 text-base leading-none">›</span> แจ้งซ่อมอุปกรณ์
                    </a>
                    <a href="{{ route('login') }}"
                       class="flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors">
                        <span class="text-blue-400 text-base leading-none">›</span> ติดตามสถานะ
                    </a>
                    @endauth
                    <a href="{{ route('login') }}"
                       class="flex items-center gap-2 text-sm text-gray-400 hover:text-white transition-colors">
                        <span class="text-blue-400 text-base leading-none">›</span> เข้าสู่ระบบเจ้าหน้าที่
                    </a>
                </div>
            </div>

            {{-- คอลัมน์ 3 --}}
            <div>
                <h4 class="font-semibold text-white mb-4 text-sm">ติดต่อ IT</h4>
                <div class="space-y-2.5 text-sm text-gray-400">
                    <p class="flex items-center gap-2">
                        <span class="text-base leading-none">📞</span>
                        <span>โทร: 039-XXXXXX ต่อ XXXX</span>
                    </p>
                    <p class="flex items-center gap-2">
                        <span class="text-base leading-none">📧</span>
                        <span>it@ppkhos.go.th</span>
                    </p>
                    <p class="flex items-center gap-2">
                        <span class="text-base leading-none">🕐</span>
                        <span>เวลาทำการ: 08:30 – 16:30 น.</span>
                    </p>
                </div>
            </div>

        </div>

        <div class="border-t border-gray-800 pt-6">
            <p class="text-gray-500 text-xs text-center">
                © 2568 โรงพยาบาลพระปกเกล้า จังหวัดจันทบุรี · กลุ่มงานเทคโนโลยีสารสนเทศ
            </p>
        </div>

    </div>
</footer>

</body>
</html>
