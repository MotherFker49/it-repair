<x-app-layout>
    <x-slot name="header">ภาพรวมระบบแจ้งซ่อม</x-slot>

    <div class="p-6 space-y-6">

        {{-- Stat Cards --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-4">

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide">รอดำเนินการ</div>
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                        <div class="w-2.5 h-2.5 bg-blue-500 rounded-full"></div>
                    </div>
                </div>
                <div class="text-3xl font-bold text-blue-600">{{ $stats['new'] }}</div>
                <div class="mt-3 w-full bg-gray-100 rounded-full h-1.5">
                    <div class="bg-blue-500 h-1.5 rounded-full transition-all"
                         style="width: {{ $stats['total'] ? min(100, $stats['new'] / $stats['total'] * 100) : 0 }}%"></div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide">รับงานแล้ว</div>
                    <div class="w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                        <div class="w-2.5 h-2.5 bg-amber-500 rounded-full"></div>
                    </div>
                </div>
                <div class="text-3xl font-bold text-amber-500">{{ $stats['assigned'] }}</div>
                <div class="mt-3 w-full bg-gray-100 rounded-full h-1.5">
                    <div class="bg-amber-400 h-1.5 rounded-full transition-all"
                         style="width: {{ $stats['total'] ? min(100, $stats['assigned'] / $stats['total'] * 100) : 0 }}%"></div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide">กำลังซ่อม</div>
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                        <div class="w-2.5 h-2.5 bg-orange-500 rounded-full animate-pulse"></div>
                    </div>
                </div>
                <div class="text-3xl font-bold text-orange-500">{{ $stats['in_progress'] }}</div>
                <div class="mt-3 w-full bg-gray-100 rounded-full h-1.5">
                    <div class="bg-orange-400 h-1.5 rounded-full transition-all"
                         style="width: {{ $stats['total'] ? min(100, $stats['in_progress'] / $stats['total'] * 100) : 0 }}%"></div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5 hover:shadow-md transition-shadow">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide">เสร็จแล้ว</div>
                    <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                        <div class="w-2.5 h-2.5 bg-green-500 rounded-full"></div>
                    </div>
                </div>
                <div class="text-3xl font-bold text-green-600">{{ $stats['done'] }}</div>
                <div class="mt-3 w-full bg-gray-100 rounded-full h-1.5">
                    <div class="bg-green-500 h-1.5 rounded-full transition-all"
                         style="width: {{ $stats['total'] ? min(100, $stats['done'] / $stats['total'] * 100) : 0 }}%"></div>
                </div>
            </div>

            @php $avgRating = \App\Models\RepairRequest::whereNotNull('rating')->avg('rating'); @endphp
            <div class="bg-white rounded-xl border border-yellow-200 shadow-sm p-5 hover:shadow-md transition-shadow col-span-2 sm:col-span-1">
                <div class="flex items-center justify-between mb-3">
                    <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide">คะแนนเฉลี่ย</div>
                    <div class="w-8 h-8 bg-yellow-100 rounded-lg flex items-center justify-center text-base leading-none">⭐</div>
                </div>
                <div class="text-3xl font-bold text-yellow-500">
                    {{ $avgRating ? number_format($avgRating, 1) : '—' }}
                    <span class="text-sm font-normal text-gray-400">/5.0</span>
                </div>
                <div class="mt-3 flex gap-0.5">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="text-sm {{ $avgRating && $i <= round($avgRating) ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                    @endfor
                </div>
            </div>

        </div>

        {{-- Total + Quick Links row --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-[#1e3a5f] rounded-xl p-5 text-white">
                <div class="text-xs font-semibold text-blue-300 uppercase tracking-wide mb-2">งานซ่อมทั้งหมด</div>
                <div class="text-4xl font-bold">{{ $stats['total'] }}</div>
                <div class="text-blue-300 text-xs mt-1">รายการในระบบ</div>
            </div>
            <div class="sm:col-span-2 bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                <div class="text-xs font-semibold text-gray-400 uppercase tracking-wide mb-3">ทางลัด</div>
                <div class="flex flex-wrap gap-2">
                    <a href="{{ route('technician.index') }}"
                       class="inline-flex items-center gap-1.5 bg-[#1e3a5f] text-white text-xs px-3 py-2 rounded-lg hover:bg-[#1d4ed8] transition-colors font-medium shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        งานซ่อมทั้งหมด
                    </a>
                    <a href="{{ route('equipments.index') }}"
                       class="inline-flex items-center gap-1.5 bg-white border border-gray-200 text-gray-700 text-xs px-3 py-2 rounded-lg hover:bg-gray-50 transition-colors font-medium shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        ทะเบียนอุปกรณ์
                    </a>
                    <a href="{{ route('public.repair') }}"
                       class="inline-flex items-center gap-1.5 bg-blue-50 border border-blue-200 text-blue-700 text-xs px-3 py-2 rounded-lg hover:bg-blue-100 transition-colors font-medium">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        แจ้งซ่อมใหม่
                    </a>
                    <a href="{{ route('technician.search') }}"
                       class="inline-flex items-center gap-1.5 bg-white border border-gray-200 text-gray-700 text-xs px-3 py-2 rounded-lg hover:bg-gray-50 transition-colors font-medium shadow-sm">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        ค้นหางานซ่อม
                    </a>
                </div>
            </div>
        </div>

        {{-- Recent Repairs Table --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">

            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <h3 class="font-semibold text-[#1e293b] text-sm">งานซ่อมล่าสุด</h3>
                <a href="{{ route('technician.index') }}"
                   class="text-xs text-[#2563eb] hover:text-[#1d4ed8] font-medium transition-colors">ดูทั้งหมด →</a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="bg-[#f8fafc] border-b border-gray-100">
                        <tr class="text-left text-xs font-semibold text-gray-400 uppercase tracking-wide">
                            <th class="px-6 py-3">เลขที่</th>
                            <th class="px-6 py-3">ผู้แจ้ง</th>
                            <th class="px-6 py-3 hidden md:table-cell">อุปกรณ์</th>
                            <th class="px-6 py-3 hidden sm:table-cell">ช่าง</th>
                            <th class="px-6 py-3">สถานะ</th>
                            <th class="px-6 py-3 hidden lg:table-cell">วันที่</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($recent as $repair)
                        <tr class="hover:bg-blue-50/40 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <a href="{{ route('technician.index') }}"
                                   class="font-mono text-xs font-bold text-[#2563eb] hover:text-[#1d4ed8] bg-blue-50 px-2.5 py-1 rounded-lg">
                                    {{ $repair->ticket_no }}
                                </a>
                            </td>
                            <td class="px-6 py-4">
                                <div class="font-medium text-[#1e293b]">{{ $repair->reporter_name ?? $repair->user?->name ?? '—' }}</div>
                                @if($repair->department)
                                    <div class="text-xs text-gray-400 mt-0.5">{{ $repair->department }}</div>
                                @endif
                            </td>
                            <td class="px-6 py-4 hidden md:table-cell text-gray-500">
                                {{ $repair->equipment?->name ?? '—' }}
                            </td>
                            <td class="px-6 py-4 hidden sm:table-cell text-gray-500">
                                {{ $repair->technician?->name ?? 'ยังไม่มอบหมาย' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @switch($repair->status)
                                    @case('new')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                            <div class="w-1.5 h-1.5 bg-blue-500 rounded-full"></div>รอดำเนินการ
                                        </span>
                                        @break
                                    @case('assigned')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">
                                            <div class="w-1.5 h-1.5 bg-amber-500 rounded-full"></div>รับงานแล้ว
                                        </span>
                                        @break
                                    @case('in_progress')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-100 text-orange-700">
                                            <div class="w-1.5 h-1.5 bg-orange-500 rounded-full animate-pulse"></div>กำลังซ่อม
                                        </span>
                                        @break
                                    @case('done')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                            <div class="w-1.5 h-1.5 bg-green-500 rounded-full"></div>เสร็จแล้ว
                                        </span>
                                        @break
                                    @case('cancelled')
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500">
                                            <div class="w-1.5 h-1.5 bg-gray-400 rounded-full"></div>ยกเลิก
                                        </span>
                                        @break
                                @endswitch
                            </td>
                            <td class="px-6 py-4 hidden lg:table-cell text-gray-400 text-xs">
                                {{ $repair->created_at->diffForHumans() }}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-16 text-center">
                                <div class="w-14 h-14 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-3">
                                    <svg class="w-7 h-7 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                </div>
                                <p class="text-gray-400 font-medium text-sm">ยังไม่มีงานซ่อมในระบบ</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>

    </div>
</x-app-layout>
