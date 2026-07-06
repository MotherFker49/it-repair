<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            {{ $equipment->asset_code }} — {{ $equipment->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            <!-- สรุปข้อมูล -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center transition-colors duration-200">
                    <div class="text-3xl font-bold text-blue-600 dark:text-blue-400">{{ $repairCount }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">ครั้งที่ซ่อม</div>
                </div>
                <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 text-center transition-colors duration-200">
                    @if($equipment->isUnderWarranty())
                        <div class="text-3xl font-bold text-green-600 dark:text-green-400">✓</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">อยู่ในประกัน</div>
                    @else
                        <div class="text-3xl font-bold text-gray-400 dark:text-gray-500">✗</div>
                        <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">หมดประกันแล้ว</div>
                    @endif
                </div>
            </div>

            <!-- ข้อมูลอุปกรณ์ -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 mb-6 transition-colors duration-200">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="font-semibold text-lg dark:text-gray-100">ข้อมูลอุปกรณ์</h3>
                    <a href="{{ route('equipments.edit', $equipment) }}" class="text-blue-600 dark:text-blue-400 text-sm hover:underline">แก้ไข</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">รหัสทรัพย์สิน</span>
                        <p class="font-medium font-mono dark:text-gray-100">{{ $equipment->asset_code }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">ชื่ออุปกรณ์</span>
                        <p class="font-medium dark:text-gray-100">{{ $equipment->name }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">ยี่ห้อ/รุ่น</span>
                        <p class="font-medium dark:text-gray-100">{{ $equipment->brand ?? '-' }} {{ $equipment->model ?? '' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">ประเภท</span>
                        <p class="font-medium dark:text-gray-100">
                            @switch($equipment->category)
                                @case('computer') คอมพิวเตอร์ @break
                                @case('printer') เครื่องพิมพ์ @break
                                @case('network') อุปกรณ์เครือข่าย @break
                                @default อื่นๆ
                            @endswitch
                        </p>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">หมายเลขซีเรียล</span>
                        <p class="font-medium font-mono dark:text-gray-100">{{ $equipment->serial_no ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">สถานที่/แผนก</span>
                        <p class="font-medium dark:text-gray-100">{{ $equipment->location ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">ผู้ใช้งาน</span>
                        <p class="font-medium dark:text-gray-100">{{ $equipment->assignedUser->name ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">วันที่ซื้อ</span>
                        <p class="font-medium dark:text-gray-100">{{ $equipment->purchase_date?->format('d/m/Y') ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">ราคาซื้อ</span>
                        <p class="font-medium dark:text-gray-100">{{ $equipment->purchase_price ? number_format($equipment->purchase_price, 2).' บาท' : '-' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">วันหมดประกัน</span>
                        <p class="font-medium {{ $equipment->isUnderWarranty() ? 'text-green-600 dark:text-green-400' : 'text-red-500 dark:text-red-400' }}">
                            {{ $equipment->warranty_expire?->format('d/m/Y') ?? '-' }}
                        </p>
                    </div>
                    <div>
                        <span class="text-gray-500 dark:text-gray-400">สถานะ</span>
                        <p class="font-medium dark:text-gray-100">{{ $equipment->statusLabel() }}</p>
                    </div>
                </div>

                @if($equipment->note)
                <div class="mt-4 pt-4 border-t dark:border-gray-700">
                    <span class="text-gray-500 dark:text-gray-400 text-sm">หมายเหตุ</span>
                    <p class="mt-1 text-sm dark:text-gray-300">{{ $equipment->note }}</p>
                </div>
                @endif
            </div>

            <!-- ประวัติการซ่อม -->
            <div class="bg-white dark:bg-gray-800 shadow-sm sm:rounded-lg p-6 transition-colors duration-200">
                <h3 class="font-semibold text-lg mb-4 dark:text-gray-100">ประวัติการซ่อมและค่าใช้จ่าย</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500 dark:text-gray-400 border-b dark:border-gray-700">
                                <th class="pb-2">เลขที่</th>
                                <th class="pb-2">วันที่แจ้ง</th>
                                <th class="pb-2">ปัญหา</th>
                                <th class="pb-2">ช่างซ่อม</th>
                                <th class="pb-2">วิธีแก้ไข</th>
                                <th class="pb-2">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($equipment->repairRequests as $repair)
                            <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                <td class="py-2">
                                    <a href="{{ route('repairs.show', $repair) }}" class="text-blue-600 dark:text-blue-400 hover:underline">
                                        {{ $repair->ticket_no }}
                                    </a>
                                </td>
                                <td class="py-2 text-gray-500 dark:text-gray-400">{{ $repair->created_at->format('d/m/Y') }}</td>
                                <td class="py-2 dark:text-gray-300">{{ Str::limit($repair->description, 40) }}</td>
                                <td class="py-2 dark:text-gray-300">{{ $repair->technician->name ?? '-' }}</td>
                                <td class="py-2 text-gray-500 dark:text-gray-400">{{ $repair->solution ? Str::limit($repair->solution, 30) : '-' }}</td>
                                <td class="py-2">
                                    @switch($repair->status)
                                        @case('new') <span class="bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 px-2 py-1 rounded text-xs">ใหม่</span> @break
                                        @case('assigned') <span class="bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 px-2 py-1 rounded text-xs">รับงานแล้ว</span> @break
                                        @case('in_progress') <span class="bg-yellow-100 dark:bg-yellow-900/40 text-yellow-700 dark:text-yellow-300 px-2 py-1 rounded text-xs">กำลังซ่อม</span> @break
                                        @case('done') <span class="bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 px-2 py-1 rounded text-xs">เสร็จแล้ว</span> @break
                                        @case('cancelled') <span class="bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 px-2 py-1 rounded text-xs">ยกเลิก</span> @break
                                    @endswitch
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="6" class="py-4 text-center text-gray-400 dark:text-gray-500">ยังไม่มีประวัติการซ่อม</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('equipments.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200 hover:underline">&larr; กลับไปหน้าทะเบียนอุปกรณ์</a>
            </div>

        </div>
    </div>
</x-app-layout>
