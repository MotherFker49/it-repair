<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">ทะเบียนอุปกรณ์ IT</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400 mt-0.5">อุปกรณ์ทั้งหมด {{ $equipments->total() }} รายการ</p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('home') }}"
                   class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors shadow-sm">
                    🏠 หน้าแรก
                </a>
                <a href="{{ route('equipments.import') }}"
                   class="flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    นำเข้า Excel
                </a>
                <a href="{{ route('equipments.create') }}"
                   class="flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    เพิ่มอุปกรณ์
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-5 bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-300 px-5 py-3.5 rounded-xl flex items-center gap-3 text-sm font-medium">
                    <svg class="w-5 h-5 text-green-600 dark:text-green-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            <!-- Table Card -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden transition-colors duration-200">

                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">รายการอุปกรณ์</h3>
                    <div class="flex items-center gap-2 text-xs text-gray-400 dark:text-gray-500">
                        <div class="w-2 h-2 bg-green-400 rounded-full"></div> ใช้งานปกติ
                        <div class="w-2 h-2 bg-amber-400 rounded-full ml-1"></div> กำลังซ่อม
                        <div class="w-2 h-2 bg-gray-300 dark:bg-gray-600 rounded-full ml-1"></div> ไม่ใช้งาน
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="bg-gray-50 dark:bg-gray-700 border-b border-gray-100 dark:border-gray-600">
                            <tr class="text-left text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide">
                                <th class="px-6 py-3">รหัสทรัพย์สิน</th>
                                <th class="px-6 py-3">ชื่ออุปกรณ์</th>
                                <th class="px-6 py-3 hidden md:table-cell">ยี่ห้อ / รุ่น</th>
                                <th class="px-6 py-3 hidden sm:table-cell">ประเภท</th>
                                <th class="px-6 py-3 hidden lg:table-cell">ผู้ใช้งาน / สถานที่</th>
                                <th class="px-6 py-3 hidden md:table-cell">ประกัน</th>
                                <th class="px-6 py-3">สถานะ</th>
                                <th class="px-6 py-3 text-right">จัดการ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @forelse ($equipments as $equipment)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">

                                <!-- Asset Code -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="font-mono text-xs font-bold text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 px-2.5 py-1 rounded-lg">
                                        {{ $equipment->asset_code }}
                                    </span>
                                </td>

                                <!-- Name -->
                                <td class="px-6 py-4">
                                    <a href="{{ route('equipments.show', $equipment) }}"
                                       class="font-semibold text-gray-900 dark:text-gray-100 hover:text-blue-700 dark:hover:text-blue-400 transition-colors">
                                        {{ $equipment->name }}
                                    </a>
                                </td>

                                <!-- Brand/Model -->
                                <td class="px-6 py-4 hidden md:table-cell">
                                    <div class="text-gray-700 dark:text-gray-300">{{ $equipment->brand ?? '—' }}</div>
                                    @if($equipment->model)
                                        <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $equipment->model }}</div>
                                    @endif
                                </td>

                                <!-- Category -->
                                <td class="px-6 py-4 hidden sm:table-cell whitespace-nowrap">
                                    @switch($equipment->category)
                                        @case('computer')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400">
                                                🖥️ คอมพิวเตอร์
                                            </span>
                                            @break
                                        @case('printer')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400">
                                                🖨️ เครื่องพิมพ์
                                            </span>
                                            @break
                                        @case('network')
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-50 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400">
                                                🌐 เครือข่าย
                                            </span>
                                            @break
                                        @default
                                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                                                📦 อื่นๆ
                                            </span>
                                    @endswitch
                                </td>

                                <!-- User / Location -->
                                <td class="px-6 py-4 hidden lg:table-cell">
                                    @if($equipment->assignedUser)
                                        <div class="text-gray-700 dark:text-gray-300 font-medium">{{ $equipment->assignedUser->name }}</div>
                                    @endif
                                    @if($equipment->location)
                                        <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            </svg>
                                            {{ $equipment->location }}
                                        </div>
                                    @endif
                                    @if(!$equipment->assignedUser && !$equipment->location)
                                        <span class="text-gray-300 dark:text-gray-600">—</span>
                                    @endif
                                </td>

                                <!-- Warranty -->
                                <td class="px-6 py-4 hidden md:table-cell whitespace-nowrap">
                                    @if($equipment->warranty_expire)
                                        @if($equipment->isUnderWarranty())
                                            <div class="flex items-center gap-1.5 text-green-600 dark:text-green-400">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="text-xs font-medium">ยังอยู่ในประกัน</span>
                                            </div>
                                            <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 ml-5">ถึง {{ $equipment->warranty_expire->format('d/m/Y') }}</div>
                                        @else
                                            <div class="flex items-center gap-1.5 text-red-500 dark:text-red-400">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                </svg>
                                                <span class="text-xs font-medium">หมดประกันแล้ว</span>
                                            </div>
                                            <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 ml-5">{{ $equipment->warranty_expire->format('d/m/Y') }}</div>
                                        @endif
                                    @else
                                        <span class="text-gray-300 dark:text-gray-600 text-xs">ไม่มีข้อมูล</span>
                                    @endif
                                </td>

                                <!-- Status -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @switch($equipment->status)
                                        @case('active')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400">
                                                <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>
                                                ใช้งานปกติ
                                            </span>
                                            @break
                                        @case('inactive')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-full text-xs font-semibold bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400">
                                                <div class="w-1.5 h-1.5 bg-gray-400 rounded-full"></div>
                                                ไม่ได้ใช้งาน
                                            </span>
                                            @break
                                        @case('maintenance')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-full text-xs font-semibold bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400">
                                                <div class="w-1.5 h-1.5 bg-amber-500 rounded-full animate-pulse"></div>
                                                กำลังซ่อม
                                            </span>
                                            @break
                                        @case('retired')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1.5 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400">
                                                <div class="w-1.5 h-1.5 bg-red-500 rounded-full"></div>
                                                เลิกใช้งาน
                                            </span>
                                            @break
                                    @endswitch
                                </td>

                                <!-- Actions -->
                                <td class="px-6 py-4 whitespace-nowrap text-right">
                                    <div class="flex items-center justify-end gap-2">
                                        <a href="{{ route('equipments.edit', $equipment) }}"
                                           class="flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 hover:bg-blue-50 dark:hover:bg-blue-900/20 rounded-lg transition-colors">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                            แก้ไข
                                        </a>
                                        <form action="{{ route('equipments.destroy', $equipment) }}" method="POST"
                                              onsubmit="return confirm('ยืนยันการลบอุปกรณ์ {{ $equipment->name }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="flex items-center gap-1 px-3 py-1.5 text-xs font-medium text-red-500 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-lg transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                                ลบ
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="px-6 py-16 text-center">
                                    <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
                                        <svg class="w-8 h-8 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17H3a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2h-2"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-400 dark:text-gray-500 font-medium">ยังไม่มีอุปกรณ์ในระบบ</p>
                                    <a href="{{ route('equipments.create') }}"
                                       class="inline-block mt-3 text-sm text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium">เพิ่มอุปกรณ์แรก →</a>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($equipments->hasPages())
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700">
                    {{ $equipments->links() }}
                </div>
                @endif

            </div>

        </div>
    </div>
</x-app-layout>
