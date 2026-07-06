<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            รายการแจ้งซ่อม
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4 flex flex-wrap gap-2">
                <a href="{{ route('home') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-600 px-4 py-2 rounded-lg text-sm font-semibold transition-colors">
                    🏠 หน้าแรก
                </a>
                <a href="{{ route('repairs.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700">
                    + แจ้งซ่อมใหม่
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-gray-500 border-b">
                                <th class="pb-2">เลขที่</th>
                                <th class="pb-2">อุปกรณ์</th>
                                <th class="pb-2">ผู้แจ้ง</th>
                                <th class="pb-2">ช่าง</th>
                                <th class="pb-2">ความเร่งด่วน</th>
                                <th class="pb-2">สถานะ</th>
                                <th class="pb-2">วันที่แจ้ง</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($repairs as $repair)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2">
                                    <a href="{{ route('repairs.show', $repair) }}" class="text-blue-600 hover:underline">
                                        {{ $repair->ticket_no }}
                                    </a>
                                </td>
                                <td class="py-2">{{ $repair->equipment->name }}</td>
                                <td class="py-2">{{ $repair->user->name }}</td>
                                <td class="py-2">{{ $repair->technician->name ?? '-' }}</td>
                                <td class="py-2">
                                    @switch($repair->priority)
                                        @case('low')
                                            <span class="text-gray-500">ปกติ</span>
                                            @break
                                        @case('medium')
                                            <span class="text-blue-600">ด่วน</span>
                                            @break
                                        @case('high')
                                            <span class="text-orange-500">ด่วนมาก</span>
                                            @break
                                        @case('urgent')
                                            <span class="text-red-600 font-semibold">เร่งด่วนที่สุด</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="py-2">
                                    @switch($repair->status)
                                        @case('new')
                                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">ใหม่</span>
                                            @break
                                        @case('assigned')
                                            <span class="bg-purple-100 text-purple-700 px-2 py-1 rounded text-xs">รับงานแล้ว</span>
                                            @break
                                        @case('in_progress')
                                            <span class="bg-yellow-100 text-yellow-700 px-2 py-1 rounded text-xs">กำลังซ่อม</span>
                                            @break
                                        @case('done')
                                            <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs">เสร็จแล้ว</span>
                                            @break
                                        @case('cancelled')
                                            <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs">ยกเลิก</span>
                                            @break
                                    @endswitch
                                </td>
                                <td class="py-2 text-gray-500">{{ $repair->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            @empty
                            <tr><td colspan="7" class="py-4 text-center text-gray-400">ยังไม่มีรายการแจ้งซ่อม</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $repairs->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>