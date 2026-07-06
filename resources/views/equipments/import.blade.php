<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-3">
            <a href="{{ route('equipments.index') }}" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">นำเข้าอุปกรณ์จาก Excel</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">อัปโหลดไฟล์ .xlsx / .xls</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-5 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-300 px-5 py-3.5 rounded-xl flex items-center gap-3 text-sm font-medium">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            @if (session('warning'))
                <div class="mb-5 bg-yellow-50 dark:bg-yellow-900/30 border border-yellow-200 dark:border-yellow-700 text-yellow-800 dark:text-yellow-300 px-5 py-3.5 rounded-xl flex items-center gap-3 text-sm font-medium">
                    <svg class="w-5 h-5 text-yellow-600 dark:text-yellow-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('warning') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-5 bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 px-5 py-4 rounded-xl">
                    <p class="font-semibold text-sm mb-1">เกิดข้อผิดพลาด</p>
                    <ul class="text-sm space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Upload Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6 mb-5">
                <form action="{{ route('equipments.import.store') }}" method="POST" enctype="multipart/form-data" id="import-form">
                    @csrf
                    <div class="mb-5">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                            เลือกไฟล์ Excel
                        </label>
                        <label for="excel-file"
                               class="block border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-8 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all group">
                            <input type="file" name="file" id="excel-file" accept=".xlsx,.xls,.csv" class="sr-only" required>
                            <div id="file-placeholder">
                                <div class="w-14 h-14 bg-green-100 dark:bg-green-900/40 rounded-2xl flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/40 transition-colors">
                                    <svg class="w-7 h-7 text-green-600 dark:text-green-400 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <p class="text-sm font-semibold text-gray-700 dark:text-gray-300 group-hover:text-blue-700 dark:group-hover:text-blue-400 transition-colors">คลิกเพื่อเลือกไฟล์</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">รองรับ .xlsx, .xls</p>
                            </div>
                            <div id="file-chosen" class="hidden">
                                <div class="w-14 h-14 bg-green-100 dark:bg-green-900/40 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-7 h-7 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                </div>
                                <p id="file-name-display" class="text-sm font-semibold text-green-700 dark:text-green-400"></p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">คลิกเพื่อเปลี่ยนไฟล์</p>
                            </div>
                        </label>
                    </div>

                    <button type="submit" id="import-btn"
                            class="w-full bg-blue-700 hover:bg-blue-800 text-white py-3 rounded-xl font-semibold text-sm transition-colors flex items-center justify-center gap-2 shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                        </svg>
                        นำเข้าข้อมูล
                    </button>
                </form>
            </div>

            <!-- Format Guide -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6">
                <h3 class="font-semibold text-gray-900 dark:text-gray-100 mb-3 text-sm">รูปแบบไฟล์ที่รองรับ</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs">
                        <thead>
                            <tr class="bg-gray-50 dark:bg-gray-700">
                                <th class="text-left px-3 py-2 font-semibold text-gray-600 dark:text-gray-300 rounded-l-lg">ชื่อคอลัมน์ (หัวตาราง)</th>
                                <th class="text-left px-3 py-2 font-semibold text-gray-600 dark:text-gray-300">ตัวอย่าง</th>
                                <th class="text-left px-3 py-2 font-semibold text-gray-600 dark:text-gray-300 rounded-r-lg">หมายเหตุ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach([
                                ['รหัส รพจ *', 'PC-001', 'จำเป็น, ใช้ upsert (อัปเดตถ้าซ้ำ)'],
                                ['ชื่ออุปกรณ์ *', 'คอมพิวเตอร์ Dell', 'จำเป็น'],
                                ['ยี่ห้อ', 'Dell', 'ไม่บังคับ'],
                                ['รุ่น', 'OptiPlex 3000', 'ไม่บังคับ'],
                                ['หมายเลขเครื่อง', 'SN12345678', 'Serial number'],
                                ['สถานที่', 'กลุ่มงานการเงิน', 'ชื่อหน่วยงาน'],
                                ['ราคา', '25,000', 'ตัดเครื่องหมายอัตโนมัติ'],
                                ['วันที่ซื้อ', '1/4/68', 'พ.ศ. หรือ ค.ศ.'],
                                ['วันหมดประกัน', '1/4/71', 'พ.ศ. หรือ ค.ศ.'],
                            ] as $col)
                            <tr>
                                <td class="px-3 py-2 text-gray-700 dark:text-gray-300 font-medium">{{ $col[0] }}</td>
                                <td class="px-3 py-2 text-gray-500 dark:text-gray-400">{{ $col[1] }}</td>
                                <td class="px-3 py-2 text-gray-400 dark:text-gray-500">{{ $col[2] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-3">* แถวแรกต้องเป็นหัวคอลัมน์ &nbsp;|&nbsp; ข้อมูลซ้ำ (รหัส รพจ เดิม) จะอัปเดตแทนที่</p>
            </div>

        </div>
    </div>

<script>
document.getElementById('excel-file').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    document.getElementById('file-placeholder').classList.add('hidden');
    document.getElementById('file-chosen').classList.remove('hidden');
    document.getElementById('file-name-display').textContent = file.name;
});

document.getElementById('import-form').addEventListener('submit', function() {
    const btn = document.getElementById('import-btn');
    btn.disabled = true;
    btn.innerHTML = '<svg class="w-4 h-4 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> กำลังนำเข้า...';
});
</script>
</x-app-layout>
