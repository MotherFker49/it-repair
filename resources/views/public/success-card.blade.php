<div class="bg-white rounded-3xl border border-gray-200 shadow-lg p-8 text-center">

    <div class="w-20 h-20 bg-green-50 rounded-3xl flex items-center justify-center mx-auto mb-5">
        <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
    </div>

    <h1 class="text-xl font-bold text-[#1e293b] mb-2">ส่งใบแจ้งซ่อมสำเร็จ!</h1>
    <p class="text-gray-400 text-sm mb-6 leading-relaxed">
        เจ้าหน้าที่ IT ได้รับแจ้งเตือนแล้ว<br>จะรีบดำเนินการให้โดยเร็วที่สุด
    </p>

    <div class="bg-gradient-to-br from-blue-50 to-[#dbeafe] border border-blue-200 rounded-2xl p-5 mb-6">
        <p class="text-xs font-semibold text-[#2563eb] uppercase tracking-wide mb-2">เลขที่ใบแจ้งซ่อม</p>
        <p class="text-4xl font-bold text-[#1e3a5f] font-mono tracking-wider">{{ $ticket }}</p>
        <p class="text-xs text-blue-500 mt-2">กรุณาจดเลขนี้ไว้สำหรับติดตามสถานะ</p>
    </div>

    <div class="space-y-2.5 text-left mb-5">
        <div class="flex items-start gap-3 text-sm">
            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            <span class="text-gray-600">ระบบบันทึกใบแจ้งซ่อมแล้ว</span>
        </div>
        <div class="flex items-start gap-3 text-sm">
            <div class="w-5 h-5 bg-green-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-3 h-3 text-green-600" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
            </div>
            <span class="text-gray-600">ส่งแจ้งเตือนเจ้าหน้าที่ IT แล้ว</span>
        </div>
        <div class="flex items-start gap-3 text-sm">
            <div class="w-5 h-5 bg-blue-100 rounded-full flex items-center justify-center shrink-0 mt-0.5">
                <svg class="w-3 h-3 text-[#2563eb]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <span class="text-gray-600">รอเจ้าหน้าที่มอบหมายงานช่าง</span>
        </div>
    </div>

    <div class="bg-yellow-50 border border-yellow-200 rounded-xl px-4 py-3 mb-5 flex items-start gap-2.5 text-left">
        <span class="text-lg shrink-0 mt-0.5">⭐</span>
        <p class="text-xs text-yellow-800 leading-relaxed">
            เมื่อช่างซ่อมเสร็จแล้ว คุณสามารถ<strong>ประเมินความพึงพอใจ</strong>ได้ที่หน้าติดตามสถานะ
        </p>
    </div>

    <div class="flex flex-col gap-3">
        <a href="{{ route('track') }}?ticket={{ $ticket }}"
           class="flex items-center justify-center gap-2 w-full bg-[#1e3a5f] hover:bg-[#1d4ed8] text-white py-3.5 rounded-xl font-semibold text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            ติดตามสถานะการซ่อม
        </a>
        <a href="{{ route('public.repair') }}"
           class="flex items-center justify-center gap-2 w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-3.5 rounded-xl font-medium text-sm transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            แจ้งซ่อมรายการใหม่
        </a>
        <a href="{{ route('home') }}"
           class="flex items-center justify-center gap-2 text-gray-400 hover:text-gray-600 text-sm py-2 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            กลับหน้าแรก
        </a>
    </div>

</div>
