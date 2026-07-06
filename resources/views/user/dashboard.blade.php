<x-user-layout>
    <x-slot name="header">ใบแจ้งซ่อมของฉัน</x-slot>

    <div class="max-w-5xl mx-auto space-y-5">

        {{-- Stats --}}
        <div class="grid grid-cols-3 gap-4">
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 text-center hover:shadow-md transition-shadow">
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                    <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                </div>
                <div class="text-3xl font-bold text-[#2563eb]">{{ $stats['new'] }}</div>
                <div class="text-xs text-gray-400 mt-1 font-medium">รอดำเนินการ</div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 text-center hover:shadow-md transition-shadow">
                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                    <div class="w-3 h-3 bg-amber-500 rounded-full animate-pulse"></div>
                </div>
                <div class="text-3xl font-bold text-amber-500">{{ $stats['in_progress'] }}</div>
                <div class="text-xs text-gray-400 mt-1 font-medium">กำลังซ่อม</div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-5 text-center hover:shadow-md transition-shadow">
                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                    <div class="w-3 h-3 bg-green-500 rounded-full"></div>
                </div>
                <div class="text-3xl font-bold text-green-600">{{ $stats['done'] }}</div>
                <div class="text-xs text-gray-400 mt-1 font-medium">เสร็จแล้ว</div>
            </div>
        </div>

        {{-- Header + Button --}}
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-[#1e293b] text-base">ประวัติการแจ้งซ่อม</h2>
            <a href="{{ route('user.repair.create') }}"
               class="inline-flex items-center gap-2 bg-[#2563eb] hover:bg-[#1d4ed8] text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                แจ้งซ่อมใหม่
            </a>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            @if($repairs->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="text-left text-xs text-gray-400 bg-[#f8fafc] border-b border-gray-100 uppercase tracking-wide font-semibold">
                            <th class="px-5 py-3.5">เลขที่</th>
                            <th class="px-5 py-3.5">อุปกรณ์</th>
                            <th class="px-5 py-3.5 hidden sm:table-cell">สถานที่</th>
                            <th class="px-5 py-3.5 hidden md:table-cell">ช่างซ่อม</th>
                            <th class="px-5 py-3.5">สถานะ</th>
                            <th class="px-5 py-3.5 hidden sm:table-cell">วันที่แจ้ง</th>
                            <th class="px-5 py-3.5"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($repairs as $repair)
                        <tr class="hover:bg-blue-50/40 transition-colors">
                            <td class="px-5 py-3.5">
                                <a href="{{ route('user.repair.show', $repair) }}"
                                   class="font-mono font-bold text-[#2563eb] hover:text-[#1d4ed8] hover:underline text-xs bg-blue-50 px-2 py-0.5 rounded-lg">
                                    {{ $repair->ticket_no }}
                                </a>
                            </td>
                            <td class="px-5 py-3.5">
                                <p class="font-medium text-[#1e293b]">{{ $repair->equipment->name }}</p>
                                <p class="text-xs text-gray-400 font-mono">{{ $repair->equipment->asset_code }}</p>
                            </td>
                            <td class="px-5 py-3.5 text-gray-500 text-xs hidden sm:table-cell">{{ $repair->department ?? '—' }}</td>
                            <td class="px-5 py-3.5 text-purple-700 text-xs hidden md:table-cell">{{ $repair->technician->name ?? '—' }}</td>
                            <td class="px-5 py-3.5">
                                @switch($repair->status)
                                    @case('new')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">ใหม่</span>
                                        @break
                                    @case('assigned')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">รับงานแล้ว</span>
                                        @break
                                    @case('in_progress')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">กำลังซ่อม</span>
                                        @break
                                    @case('done')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">เสร็จแล้ว</span>
                                        @break
                                    @case('cancelled')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600">ยกเลิก</span>
                                        @break
                                @endswitch
                            </td>
                            <td class="px-5 py-3.5 text-gray-400 text-xs whitespace-nowrap hidden sm:table-cell">{{ $repair->created_at->format('d/m/Y') }}</td>
                            <td class="px-5 py-3.5">
                                <a href="{{ route('user.repair.show', $repair) }}"
                                   class="inline-flex items-center gap-1 text-xs text-[#2563eb] hover:text-[#1d4ed8] font-medium">
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
            <div class="px-5 py-4 border-t border-gray-100">
                {{ $repairs->links() }}
            </div>
            @else
            <div class="py-20 text-center">
                <div class="w-16 h-16 bg-blue-50 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-[#1e293b] font-semibold mb-1">ยังไม่มีประวัติการแจ้งซ่อม</p>
                <p class="text-gray-400 text-sm mb-5">เริ่มแจ้งซ่อมอุปกรณ์ IT ของคุณได้เลย</p>
                <a href="{{ route('user.repair.create') }}"
                   class="inline-flex items-center gap-2 bg-[#2563eb] hover:bg-[#1d4ed8] text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition-colors shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    แจ้งซ่อมใหม่
                </a>
            </div>
            @endif
        </div>

    </div>
</x-user-layout>
