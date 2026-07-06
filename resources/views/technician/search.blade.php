<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">ค้นหางานซ่อม</h2>
            <a href="{{ route('technician.index') }}"
               class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                ← งานซ่อมทั้งหมด
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-5">

            {{-- Search Form --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-5">
                <form method="GET" action="{{ route('technician.search') }}" class="space-y-4">
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-1">
                            <input type="text" name="q" value="{{ $q }}"
                                   placeholder="ค้นหาเลขที่ ชื่อผู้แจ้ง แผนก อาการ วิธีแก้ไข ชื่ออุปกรณ์..."
                                   class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500">
                        </div>
                        <button type="submit"
                                class="flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors whitespace-nowrap">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            ค้นหา
                        </button>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-4 gap-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">สถานะ</label>
                            <select name="status"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">ทุกสถานะ</option>
                                <option value="new"         {{ $status === 'new'         ? 'selected' : '' }}>ใหม่</option>
                                <option value="assigned"    {{ $status === 'assigned'    ? 'selected' : '' }}>รับงานแล้ว</option>
                                <option value="in_progress" {{ $status === 'in_progress' ? 'selected' : '' }}>กำลังซ่อม</option>
                                <option value="done"        {{ $status === 'done'        ? 'selected' : '' }}>เสร็จแล้ว</option>
                                <option value="cancelled"   {{ $status === 'cancelled'   ? 'selected' : '' }}>ยกเลิก</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">ช่างผู้รับผิดชอบ</label>
                            <select name="technician_id"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">ทุกช่าง</option>
                                @foreach($technicians as $tech)
                                    <option value="{{ $tech->id }}" {{ $techId == $tech->id ? 'selected' : '' }}>{{ $tech->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">วันที่แจ้ง (จาก)</label>
                            <input type="date" name="date_from" value="{{ $dateFrom }}"
                                   class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-500 dark:text-gray-400 mb-1">วันที่แจ้ง (ถึง)</label>
                            <input type="date" name="date_to" value="{{ $dateTo }}"
                                   class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        </div>
                    </div>

                    @if($q || $status || $techId || $dateFrom || $dateTo)
                    <div>
                        <a href="{{ route('technician.search') }}" class="text-xs text-gray-400 dark:text-gray-500 hover:text-red-500 dark:hover:text-red-400 underline">ล้างตัวกรอง</a>
                    </div>
                    @endif
                </form>
            </div>

            {{-- Results --}}
            @if($q || $status || $techId || $dateFrom || $dateTo)
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">ผลการค้นหา</h3>
                    <span class="text-sm text-gray-400 dark:text-gray-500">{{ $repairs->total() }} รายการ</span>
                </div>

                @if($repairs->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-xs text-gray-400 dark:text-gray-500 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                <th class="px-5 py-3">เลขที่</th>
                                <th class="px-5 py-3">อุปกรณ์</th>
                                <th class="px-5 py-3">แผนก</th>
                                <th class="px-5 py-3">ผู้แจ้ง</th>
                                <th class="px-5 py-3">อาการ</th>
                                <th class="px-5 py-3">ช่าง</th>
                                <th class="px-5 py-3">วันที่</th>
                                <th class="px-5 py-3">สถานะ</th>
                                <th class="px-5 py-3"></th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($repairs as $repair)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <td class="px-5 py-3">
                                    <span class="font-mono font-bold text-blue-700 dark:text-blue-400 text-xs">{{ $repair->ticket_no }}</span>
                                </td>
                                <td class="px-5 py-3">
                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $repair->equipment->name }}</p>
                                    <p class="text-xs font-mono text-gray-400 dark:text-gray-500">{{ $repair->equipment->asset_code }}</p>
                                </td>
                                <td class="px-5 py-3 text-gray-600 dark:text-gray-400 text-xs">{{ $repair->department ?? $repair->equipment->location ?? '—' }}</td>
                                <td class="px-5 py-3 text-gray-600 dark:text-gray-400 text-xs">{{ $repair->reporter_name ?? $repair->user->name ?? '—' }}</td>
                                <td class="px-5 py-3 text-gray-700 dark:text-gray-300">{{ Str::limit($repair->description, 40) }}</td>
                                <td class="px-5 py-3 text-purple-700 dark:text-purple-400 text-xs">{{ $repair->technician->name ?? '—' }}</td>
                                <td class="px-5 py-3 text-gray-400 dark:text-gray-500 text-xs whitespace-nowrap">{{ $repair->created_at->format('d/m/Y') }}</td>
                                <td class="px-5 py-3">
                                    @switch($repair->status)
                                        @case('new') <span class="bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 px-2 py-0.5 rounded text-xs">ใหม่</span> @break
                                        @case('assigned') <span class="bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 px-2 py-0.5 rounded text-xs">รับงาน</span> @break
                                        @case('in_progress') <span class="bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 px-2 py-0.5 rounded text-xs">กำลังซ่อม</span> @break
                                        @case('done') <span class="bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 px-2 py-0.5 rounded text-xs">เสร็จ</span> @break
                                        @case('cancelled') <span class="bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 px-2 py-0.5 rounded text-xs">ยกเลิก</span> @break
                                    @endswitch
                                </td>
                                <td class="px-5 py-3">
                                    <a href="{{ route('technician.show', $repair) }}"
                                       class="inline-flex items-center gap-1 text-xs text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">
                                        ดูรายละเอียด
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-5 py-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $repairs->links() }}
                </div>
                @else
                <div class="py-16 text-center">
                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <p class="text-gray-400 dark:text-gray-500 font-medium">ไม่พบงานซ่อมที่ค้นหา</p>
                    <p class="text-gray-300 dark:text-gray-600 text-sm mt-1">ลองเปลี่ยนคำค้นหาหรือตัวกรอง</p>
                </div>
                @endif
            </div>
            @else
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-dashed border-gray-200 dark:border-gray-700 p-16 text-center">
                <div class="w-16 h-16 bg-blue-50 dark:bg-blue-900/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-400 dark:text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <p class="text-gray-500 dark:text-gray-400 font-medium">พิมพ์คำค้นหาหรือเลือกตัวกรองด้านบน</p>
                <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">ค้นหาได้จากเลขที่ ชื่อผู้แจ้ง แผนก อาการ หรืออุปกรณ์</p>
            </div>
            @endif

        </div>
    </div>
</x-app-layout>
