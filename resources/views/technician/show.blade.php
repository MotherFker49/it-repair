<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <div class="flex items-center gap-2 mb-1">
                    <a href="{{ route('technician.index') }}" class="text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 text-sm">งานซ่อม</a>
                    <span class="text-gray-300 dark:text-gray-600">/</span>
                    <span class="text-sm text-gray-600 dark:text-gray-400 font-mono">{{ $repair->ticket_no }}</span>
                </div>
                <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100">รายละเอียดงานซ่อม</h2>
            </div>
            <a href="{{ route('technician.search') }}"
               class="flex items-center gap-2 bg-gray-100 dark:bg-gray-700 hover:bg-gray-200 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-200 px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                🔍 ค้นหางานซ่อม
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-5">

            @if (session('success'))
                <div class="bg-green-50 dark:bg-green-900/30 border border-green-200 dark:border-green-700 text-green-800 dark:text-green-300 px-5 py-3.5 rounded-xl flex items-center gap-3 text-sm font-medium">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ session('success') }}
                </div>
            @endif

            {{-- ======= SECTION 1: ข้อมูลงานซ่อม ======= --}}
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700 flex items-center justify-between">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">ข้อมูลงานซ่อม</h3>
                    <div class="flex items-center gap-2">
                        @switch($repair->status)
                            @case('new')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300">ใหม่</span>
                                @break
                            @case('assigned')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300">รับงานแล้ว</span>
                                @break
                            @case('in_progress')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300">กำลังซ่อม</span>
                                @break
                            @case('done')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300">เสร็จแล้ว</span>
                                @break
                            @case('cancelled')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 dark:bg-red-900/40 text-red-600 dark:text-red-400">ยกเลิก</span>
                                @break
                        @endswitch
                        @switch($repair->priority)
                            @case('urgent')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-800">🔴 เร่งด่วนที่สุด</span>
                                @break
                            @case('high')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-50 dark:bg-orange-900/30 text-orange-600 dark:text-orange-400 border border-orange-200 dark:border-orange-800">🟠 ด่วนมาก</span>
                                @break
                            @case('medium')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-50 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400 border border-yellow-200 dark:border-yellow-800">🟡 ด่วน</span>
                                @break
                            @case('low')
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-50 dark:bg-gray-700 text-gray-500 dark:text-gray-400 border border-gray-200 dark:border-gray-600">🟢 ปกติ</span>
                                @break
                        @endswitch
                    </div>
                </div>

                <div class="px-6 py-5 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide mb-1">เลขที่ใบแจ้งซ่อม</p>
                        <p class="font-mono font-bold text-blue-700 dark:text-blue-400 text-lg">{{ $repair->ticket_no }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide mb-1">วันที่แจ้ง</p>
                        <p class="text-gray-900 dark:text-gray-100">{{ $repair->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide mb-1">ผู้แจ้งซ่อม</p>
                        <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $repair->reporter_name ?? $repair->user->name ?? 'ไม่ระบุ' }}</p>
                        @if($repair->reporter_phone)
                            <p class="text-sm text-gray-500 dark:text-gray-400">{{ $repair->reporter_phone }}</p>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide mb-1">แผนก / สถานที่</p>
                        <p class="text-gray-900 dark:text-gray-100">{{ $repair->department ?? $repair->equipment->location ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide mb-1">อุปกรณ์</p>
                        <p class="text-gray-900 dark:text-gray-100 font-medium">{{ $repair->equipment->name }}</p>
                        <p class="text-sm font-mono text-gray-500 dark:text-gray-400">{{ $repair->equipment->asset_code }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide mb-1">ช่างผู้รับผิดชอบ</p>
                        @if($repair->technician)
                            <p class="text-purple-700 dark:text-purple-400 font-medium">{{ $repair->technician->name }}</p>
                        @else
                            <p class="text-gray-400 dark:text-gray-500">ยังไม่ได้รับมอบหมาย</p>
                        @endif
                    </div>
                    <div class="sm:col-span-2">
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide mb-1">อาการ / ปัญหา</p>
                        <div class="bg-gray-50 dark:bg-gray-700/50 rounded-xl px-4 py-3 text-sm text-gray-700 dark:text-gray-300 leading-relaxed">{{ $repair->description }}</div>
                    </div>
                    @if($repair->image_path)
                    <div class="sm:col-span-2">
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide mb-2">รูปภาพประกอบ</p>
                        <a href="{{ asset('storage/'.$repair->image_path) }}" target="_blank">
                            <img src="{{ asset('storage/'.$repair->image_path) }}" alt="repair image"
                                 class="max-h-48 rounded-xl border border-gray-200 dark:border-gray-700 object-cover hover:opacity-80 transition-opacity">
                        </a>
                    </div>
                    @endif
                </div>

                @if($repair->solution || $repair->root_cause || $repair->parts_used || $repair->repair_type || $repair->start_repair_at)
                <div class="px-6 py-5 border-t border-gray-100 dark:border-gray-700 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="sm:col-span-2">
                        <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide mb-2">ข้อมูลการซ่อม</p>
                    </div>
                    @if($repair->repair_type)
                    <div>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">รูปแบบการซ่อม</p>
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-sm font-medium
                            {{ $repair->repair_type === 'on_site' ? 'bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400' :
                               ($repair->repair_type === 'bring_in' ? 'bg-orange-50 dark:bg-orange-900/30 text-orange-700 dark:text-orange-400' :
                               'bg-purple-50 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400') }}">
                            {{ $repair->repairTypeLabel() }}
                        </span>
                    </div>
                    @endif
                    @if($repair->start_repair_at)
                    <div>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">เวลาซ่อม</p>
                        <p class="text-sm text-gray-700 dark:text-gray-300">
                            {{ $repair->start_repair_at->format('d/m/Y H:i') }}
                            @if($repair->finish_repair_at)
                                — {{ $repair->finish_repair_at->format('H:i') }}
                                <span class="text-green-600 dark:text-green-400 font-medium ml-1">({{ $repair->repairDuration() }})</span>
                            @endif
                        </p>
                    </div>
                    @endif
                    @if($repair->root_cause)
                    <div class="sm:col-span-2">
                        <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">สาเหตุที่แท้จริง</p>
                        <p class="text-sm text-gray-700 dark:text-gray-300 bg-amber-50 dark:bg-amber-900/20 rounded-xl px-4 py-3 leading-relaxed">{{ $repair->root_cause }}</p>
                    </div>
                    @endif
                    @if($repair->solution)
                    <div class="sm:col-span-2">
                        <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">วิธีแก้ไข / บันทึกการซ่อม</p>
                        <p class="text-sm text-gray-700 dark:text-gray-300 bg-green-50 dark:bg-green-900/20 rounded-xl px-4 py-3 leading-relaxed">{{ $repair->solution }}</p>
                    </div>
                    @endif
                    @if($repair->parts_used)
                    <div class="sm:col-span-2">
                        <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">อะไหล่ / วัสดุที่ใช้</p>
                        <p class="text-sm text-gray-700 dark:text-gray-300 bg-gray-50 dark:bg-gray-700/50 rounded-xl px-4 py-3 leading-relaxed">{{ $repair->parts_used }}</p>
                    </div>
                    @endif
                    @if($repair->resolved_at)
                    <div>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mb-1">วันที่ซ่อมเสร็จ</p>
                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $repair->resolved_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                </div>
                @endif

                @if($repair->isRated())
                <div class="px-6 py-4 border-t border-gray-100 dark:border-gray-700 bg-yellow-50/50 dark:bg-yellow-900/10">
                    <p class="text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wide mb-2">คะแนนความพึงพอใจ</p>
                    <div class="flex items-center gap-3">
                        <div class="flex items-center gap-0.5">
                            @for($i = 1; $i <= 5; $i++)
                                <span class="text-xl {{ $i <= $repair->rating ? 'text-yellow-400' : 'text-gray-200 dark:text-gray-600' }}">★</span>
                            @endfor
                        </div>
                        <span class="font-semibold text-yellow-700 dark:text-yellow-400">{{ $repair->rating }}/5 — {{ $repair->ratingLabel() }}</span>
                    </div>
                    @if($repair->rating_comment)
                        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 italic">"{{ $repair->rating_comment }}"</p>
                    @endif
                </div>
                @endif
            </div>

            {{-- ======= SECTION 2: ฟอร์มอัปเดต ======= --}}
            @if($repair->status !== 'done' && $repair->status !== 'cancelled')
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">อัปเดตสถานะงานซ่อม</h3>
                </div>
                <form action="{{ route('technician.status', $repair) }}" method="POST" class="px-6 py-5 space-y-4">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">สถานะ <span class="text-red-500">*</span></label>
                            <select name="status"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="assigned"    {{ $repair->status=='assigned'    ? 'selected' : '' }}>รับงานแล้ว</option>
                                <option value="in_progress" {{ $repair->status=='in_progress' ? 'selected' : '' }}>กำลังซ่อม</option>
                                <option value="done"        {{ $repair->status=='done'        ? 'selected' : '' }}>เสร็จแล้ว</option>
                                <option value="cancelled"   {{ $repair->status=='cancelled'   ? 'selected' : '' }}>ยกเลิก</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">รูปแบบการซ่อม</label>
                            <select name="repair_type"
                                    class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                                <option value="">— เลือกรูปแบบ —</option>
                                <option value="on_site"  {{ $repair->repair_type=='on_site'  ? 'selected' : '' }}>ซ่อมที่จุด</option>
                                <option value="bring_in" {{ $repair->repair_type=='bring_in' ? 'selected' : '' }}>นำเข้าซ่อม</option>
                                <option value="remote"   {{ $repair->repair_type=='remote'   ? 'selected' : '' }}>ซ่อมทางไกล</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">เวลาเริ่มซ่อม</label>
                            <input type="datetime-local" name="start_repair_at"
                                   value="{{ $repair->start_repair_at ? $repair->start_repair_at->format('Y-m-d\TH:i') : '' }}"
                                   class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">เวลาซ่อมเสร็จ</label>
                            <input type="datetime-local" name="finish_repair_at"
                                   value="{{ $repair->finish_repair_at ? $repair->finish_repair_at->format('Y-m-d\TH:i') : '' }}"
                                   class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">สาเหตุที่แท้จริง</label>
                        <textarea name="root_cause" rows="2"
                                  class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500"
                                  placeholder="ระบุสาเหตุที่แท้จริงของปัญหา...">{{ $repair->root_cause }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">วิธีแก้ไข / บันทึกการซ่อม</label>
                        <textarea name="solution" rows="3"
                                  class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500"
                                  placeholder="อธิบายวิธีแก้ไขปัญหา...">{{ $repair->solution }}</textarea>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-600 dark:text-gray-400 mb-1.5">อะไหล่ / วัสดุที่ใช้</label>
                        <textarea name="parts_used" rows="2"
                                  class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 resize-none bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500"
                                  placeholder="เช่น RAM 8GB DDR4, HDD 1TB...">{{ $repair->parts_used }}</textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit"
                                class="bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                            บันทึกข้อมูล
                        </button>
                    </div>
                </form>
            </div>
            @endif

            {{-- ======= SECTION 3: ประวัติการซ่อมอุปกรณ์นี้ ======= --}}
            @php
                $history = $repair->equipment->repairRequests()
                    ->with('technician')
                    ->orderByDesc('created_at')
                    ->get();
            @endphp
            @if($history->count() > 1)
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 dark:border-gray-700">
                    <h3 class="font-semibold text-gray-900 dark:text-gray-100">ประวัติการซ่อม — {{ $repair->equipment->name }}</h3>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">{{ $history->count() }} ครั้ง</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-xs text-gray-400 dark:text-gray-500 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                <th class="px-6 py-3">เลขที่</th>
                                <th class="px-6 py-3">วันที่</th>
                                <th class="px-6 py-3">ปัญหา</th>
                                <th class="px-6 py-3">ช่างซ่อม</th>
                                <th class="px-6 py-3">สถานะ</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($history as $h)
                            <tr class="{{ $h->id === $repair->id ? 'bg-blue-50 dark:bg-blue-900/20' : 'hover:bg-gray-50 dark:hover:bg-gray-700/50' }} transition-colors">
                                <td class="px-6 py-3">
                                    @if($h->id !== $repair->id)
                                        <a href="{{ route('technician.show', $h) }}" class="font-mono text-blue-600 dark:text-blue-400 hover:underline">{{ $h->ticket_no }}</a>
                                    @else
                                        <span class="font-mono font-bold text-blue-700 dark:text-blue-300">{{ $h->ticket_no }} ←</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-gray-500 dark:text-gray-400">{{ $h->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-3 text-gray-700 dark:text-gray-300">{{ Str::limit($h->description, 40) }}</td>
                                <td class="px-6 py-3 text-gray-600 dark:text-gray-400">{{ $h->technician->name ?? '—' }}</td>
                                <td class="px-6 py-3">
                                    @switch($h->status)
                                        @case('new') <span class="bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 px-2 py-0.5 rounded text-xs">ใหม่</span> @break
                                        @case('assigned') <span class="bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-300 px-2 py-0.5 rounded text-xs">รับงาน</span> @break
                                        @case('in_progress') <span class="bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-300 px-2 py-0.5 rounded text-xs">กำลังซ่อม</span> @break
                                        @case('done') <span class="bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-300 px-2 py-0.5 rounded text-xs">เสร็จ</span> @break
                                        @case('cancelled') <span class="bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-300 px-2 py-0.5 rounded text-xs">ยกเลิก</span> @break
                                    @endswitch
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endif

            <div class="pb-2">
                <a href="{{ route('technician.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 hover:underline">← กลับหน้างานซ่อม</a>
            </div>

        </div>
    </div>
</x-app-layout>
