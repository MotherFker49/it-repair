<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>เข้าสู่ระบบ — ระบบแจ้งซ่อม IT</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#f8fafc] font-sans antialiased min-h-screen">

<div class="min-h-screen flex">

    {{-- ===== LEFT PANEL (Desktop only) ===== --}}
    <div class="hidden lg:flex lg:w-[420px] xl:w-[480px] bg-[#1e3a5f] flex-col justify-between p-10 shrink-0">

        <div>
            {{-- Logo --}}
            <div class="flex items-center gap-3 mb-10">
                <div class="w-10 h-10 bg-[#2563eb] rounded-xl flex items-center justify-center shadow-sm">
                    <span class="text-white text-lg leading-none">🔧</span>
                </div>
                <div>
                    <div class="text-white font-bold text-base leading-tight">ระบบแจ้งซ่อม IT</div>
                    <div class="text-blue-300 text-xs">โรงพยาบาลพระปกเกล้า</div>
                </div>
            </div>

            {{-- Headline --}}
            <h1 class="text-2xl font-bold text-white mb-3 leading-snug">
                ระบบบริหารจัดการ<br>งานซ่อมอุปกรณ์ IT
            </h1>
            <p class="text-blue-300 text-sm leading-relaxed mb-8">
                จัดการใบแจ้งซ่อม ติดตามสถานะ และบริหารทะเบียนอุปกรณ์ IT ของโรงพยาบาลได้ในที่เดียว
            </p>

            {{-- Feature list --}}
            <div class="space-y-3.5">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-[#2563eb]/30 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-[#93c5fd]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-blue-200 text-sm">แจ้งซ่อมและติดตามสถานะแบบ Real-time</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-[#2563eb]/30 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-[#93c5fd]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <span class="text-blue-200 text-sm">บริหารทะเบียนอุปกรณ์ครบวงจร</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-[#2563eb]/30 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-[#93c5fd]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                    </div>
                    <span class="text-blue-200 text-sm">แจ้งเตือนผ่าน LINE Notify ทันที</span>
                </div>
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 bg-[#2563eb]/30 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 text-[#93c5fd]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <span class="text-blue-200 text-sm">ระบบประเมินความพึงพอใจ</span>
                </div>
            </div>
        </div>

        <div class="text-blue-400 text-xs">
            © {{ date('Y') }} โรงพยาบาลพระปกเกล้า · กลุ่มงานเทคโนโลยีสารสนเทศ
        </div>

    </div>

    {{-- ===== RIGHT PANEL (Login Form) ===== --}}
    <div class="flex-1 flex items-center justify-center p-6 sm:p-10">
        <div class="w-full max-w-sm">

            {{-- Mobile Logo --}}
            <div class="lg:hidden flex items-center gap-2.5 mb-8 justify-center">
                <div class="w-9 h-9 bg-[#1e3a5f] rounded-xl flex items-center justify-center">
                    <span class="text-white leading-none">🔧</span>
                </div>
                <div>
                    <div class="font-bold text-[#1e3a5f] text-sm">ระบบแจ้งซ่อม IT</div>
                    <div class="text-gray-400 text-xs">โรงพยาบาลพระปกเกล้า</div>
                </div>
            </div>

            <h2 class="text-2xl font-bold text-[#1e293b] mb-1">เข้าสู่ระบบ</h2>
            <p class="text-gray-400 text-sm mb-6">กรุณาใส่อีเมลและรหัสผ่านของท่าน</p>

            {{-- Login required banner --}}
            <div class="mb-5 bg-blue-50 border border-blue-200 rounded-xl px-4 py-3">
                <div class="font-semibold text-blue-800 text-sm mb-0.5">🔐 กรุณาเข้าสู่ระบบก่อนใช้งาน</div>
                <div class="text-blue-600 text-xs">ทุกฟีเจอร์ในระบบต้องเข้าสู่ระบบด้วยบัญชีของท่านก่อน</div>
            </div>

            {{-- Session Status --}}
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-[#1e293b] mb-1.5">อีเมล</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}"
                           required autofocus autocomplete="username"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#2563eb] focus:border-[#2563eb] placeholder-gray-300 transition-colors"
                           placeholder="your@email.com">
                    <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
                </div>

                {{-- Password --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-[#1e293b] mb-1.5">รหัสผ่าน</label>
                    <input id="password" type="password" name="password"
                           required autocomplete="current-password"
                           class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-[#2563eb] focus:border-[#2563eb] placeholder-gray-300 transition-colors"
                           placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
                </div>

                {{-- Remember + Forgot --}}
                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-gray-500 cursor-pointer">
                        <input type="checkbox" name="remember"
                               class="rounded border-gray-300 text-[#2563eb] focus:ring-[#2563eb]">
                        จดจำการเข้าสู่ระบบ
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}"
                           class="text-sm text-[#2563eb] hover:text-[#1d4ed8] transition-colors">
                            ลืมรหัสผ่าน?
                        </a>
                    @endif
                </div>

                {{-- Submit --}}
                <button type="submit"
                        class="w-full bg-[#1e3a5f] hover:bg-[#1d4ed8] text-white py-3.5 rounded-xl font-semibold text-sm transition-colors shadow-sm mt-1">
                    เข้าสู่ระบบ
                </button>
            </form>

            {{-- Test Accounts --}}
            <div class="mt-5 bg-[#f8fafc] border border-gray-200 rounded-xl p-4 text-xs">
                <div class="font-semibold text-gray-500 mb-2.5">🔑 บัญชีทดสอบ</div>
                <div class="space-y-2 text-gray-400">
                    <div class="flex items-center gap-2">
                        <span class="bg-[#1e3a5f] text-white px-1.5 py-0.5 rounded font-medium shrink-0">👨‍💼 Admin</span>
                        <span class="font-mono">admin@example.com / password</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="bg-green-700 text-white px-1.5 py-0.5 rounded font-medium shrink-0">🔧 ช่าง</span>
                        <span class="font-mono">tech@example.com / password</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="bg-gray-500 text-white px-1.5 py-0.5 rounded font-medium shrink-0">👤 User</span>
                        <span class="font-mono">user@example.com / password</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>
</body>
</html>
