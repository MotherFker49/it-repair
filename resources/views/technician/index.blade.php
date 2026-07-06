<x-app-layout>
    <x-slot name="header">งานซ่อมทั้งหมด</x-slot>

    <div class="p-6">

        @if (session('success'))
            <div class="mb-5 bg-green-50 border border-green-200 text-green-800 px-5 py-3.5 rounded-xl flex items-center gap-3 text-sm font-medium">
                <svg class="w-5 h-5 text-green-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- Status Filter Tabs --}}
        @php
            $filters = [
                'all'         => ['label' => 'ทั้งหมด',   'count' => $counts['all'],         'bg' => 'bg-[#1e3a5f]',   'text' => 'text-[#1e3a5f]',   'ring' => 'ring-[#1e3a5f]'],
                'new'         => ['label' => 'ใหม่',       'count' => $counts['new'],         'bg' => 'bg-blue-600',    'text' => 'text-blue-700',    'ring' => 'ring-blue-500'],
                'assigned'    => ['label' => 'รับงานแล้ว', 'count' => $counts['assigned'],    'bg' => 'bg-purple-600',  'text' => 'text-purple-700',  'ring' => 'ring-purple-500'],
                'in_progress' => ['label' => 'กำลังซ่อม', 'count' => $counts['in_progress'], 'bg' => 'bg-amber-500',   'text' => 'text-amber-700',   'ring' => 'ring-amber-500'],
                'done'        => ['label' => 'เสร็จแล้ว', 'count' => $counts['done'],        'bg' => 'bg-green-600',   'text' => 'text-green-700',   'ring' => 'ring-green-500'],
            ];
            $url = ['all' => route('technician.index')];
            foreach(['new','assigned','in_progress','done'] as $s) {
                $url[$s] = route('technician.index', ['status' => $s]);
            }
        @endphp

        <div class="flex flex-wrap gap-2 mb-5 pb-1">
            @foreach($filters as $key => $f)
                <a href="{{ $url[$key] }}"
                   class="flex items-center gap-2 px-4 py-2 rounded-xl text-sm font-semibold transition-all shadow-sm whitespace-nowrap border
                          {{ $status == $key
                              ? $f['bg'] . ' text-white border-transparent'
                              : 'bg-white ' . $f['text'] . ' border-gray-200 hover:border-gray-300 hover:shadow' }}">
                    {{ $f['label'] }}
                    <span class="inline-flex items-center justify-center min-w-[1.25rem] h-5 px-1.5 rounded-full text-xs
                                 {{ $status == $key ? 'bg-white/25 text-white' : 'bg-gray-100 text-gray-600' }}">
                        {{ $f['count'] }}
                    </span>
                </a>
            @endforeach
        </div>

        {{-- Repair Cards --}}
        <div class="space-y-3">
            @forelse ($repairs as $repair)
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden hover:border-[#93c5fd] hover:shadow-md transition-all">
                <div class="p-5">
                    <div class="flex flex-wrap justify-between items-start gap-3">

                        {{-- Left Info --}}
                        <div class="flex-1 min-w-0">

                            {{-- Badges row --}}
                            <div class="flex flex-wrap items-center gap-2 mb-3">
                                <span class="font-mono font-bold text-[#2563eb] text-sm">{{ $repair->ticket_no }}</span>

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

                                @switch($repair->priority)
                                    @case('urgent')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-red-50 text-red-600 border border-red-200">🔴 เร่งด่วนที่สุด</span>
                                        @break
                                    @case('high')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-orange-50 text-orange-600 border border-orange-200">🟠 ด่วนมาก</span>
                                        @break
                                    @case('medium')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-50 text-yellow-700 border border-yellow-200">🟡 ด่วน</span>
                                        @break
                                    @case('low')
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-50 text-gray-500 border border-gray-200">🟢 ปกติ</span>
                                        @break
                                @endswitch

                                @if($repair->status === 'done')
                                    @if($repair->isRated())
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-semibold bg-yellow-50 border border-yellow-200 text-yellow-700">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <span class="{{ $i <= $repair->rating ? 'text-yellow-400' : 'text-gray-300' }}">★</span>
                                            @endfor
                                            <span class="ml-0.5">{{ $repair->rating }}/5</span>
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-400 border border-gray-200">
                                            รอประเมิน
                                        </span>
                                    @endif
                                @endif
                            </div>

                            {{-- Equipment name --}}
                            <div class="font-semibold text-[#1e293b] mb-1">
                                {{ $repair->equipment->name }}
                                <span class="font-mono text-gray-400 text-xs font-normal ml-1">({{ $repair->equipment->asset_code }})</span>
                            </div>

                            {{-- Location & Reporter --}}
                            <div class="flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-gray-500 mb-3">
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    </svg>
                                    {{ $repair->department ?? $repair->equipment->location ?? '—' }}
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    {{ $repair->reporter_name ?? $repair->user->name ?? 'ไม่ระบุ' }}
                                    @if($repair->reporter_phone)
                                        <span class="text-gray-400">({{ $repair->reporter_phone }})</span>
                                    @endif
                                </span>
                                <span class="flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    {{ $repair->created_at->diffForHumans() }}
                                </span>
                            </div>

                            {{-- Description --}}
                            <div class="text-sm text-gray-600 bg-[#f8fafc] rounded-xl px-4 py-3 leading-relaxed border border-gray-100">
                                {{ Str::limit($repair->description, 120) }}
                            </div>

                            @if($repair->technician)
                            <div class="mt-2.5 flex items-center gap-1.5 text-xs text-purple-700">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                ช่างผู้รับผิดชอบ: <span class="font-semibold">{{ $repair->technician->name }}</span>
                            </div>
                            @endif
                        </div>

                        {{-- Right Buttons --}}
                        <div class="flex flex-col gap-2 min-w-[140px]">
                            @if($repair->status === 'new' && !$repair->technician_id)
                            <form action="{{ route('technician.accept', $repair) }}" method="POST">
                                @csrf
                                <button type="submit"
                                        class="w-full flex items-center justify-center gap-1.5 bg-[#2563eb] hover:bg-[#1d4ed8] text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    รับงานนี้
                                </button>
                            </form>
                            @endif

                            @if($repair->status !== 'done' && $repair->status !== 'cancelled')
                            <button onclick="toggleUpdate({{ $repair->id }})"
                                    class="w-full flex items-center justify-center gap-1.5 bg-white border border-gray-300 hover:bg-gray-50 hover:border-gray-400 text-gray-700 px-4 py-2.5 rounded-xl text-sm font-medium transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                อัปเดตสถานะ
                            </button>
                            @endif

                            @if($repair->image_path)
                            <a href="{{ asset('storage/'.$repair->image_path) }}" target="_blank"
                               class="w-full flex items-center justify-center gap-1.5 bg-white border border-gray-200 hover:bg-gray-50 text-gray-500 px-4 py-2.5 rounded-xl text-sm transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                ดูรูปภาพ
                            </a>
                            @endif

                            <a href="{{ route('technician.show', $repair) }}"
                               class="w-full flex items-center justify-center gap-1.5 bg-white border border-gray-200 hover:bg-blue-50 hover:border-[#93c5fd] text-gray-500 hover:text-[#2563eb] px-4 py-2.5 rounded-xl text-sm transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                ดูรายละเอียด
                            </a>
                        </div>
                    </div>

                    {{-- Inline Update Form (hidden) --}}
                    <div id="update-{{ $repair->id }}" class="hidden mt-4 pt-4 border-t border-gray-100">
                        <form action="{{ route('technician.status', $repair) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 mb-3">
                                <div>
                                    <label class="block text-xs font-semibold text-gray-600 mb-1.5">สถานะ</label>
                                    <select name="status"
                                            class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2563eb] focus:border-[#2563eb] bg-white text-gray-900">
                                        <option value="assigned"    {{ $repair->status=='assigned'    ? 'selected' : '' }}>รับงานแล้ว</option>
                                        <option value="in_progress" {{ $repair->status=='in_progress' ? 'selected' : '' }}>กำลังซ่อม</option>
                                        <option value="done"        {{ $repair->status=='done'        ? 'selected' : '' }}>เสร็จแล้ว</option>
                                        <option value="cancelled"   {{ $repair->status=='cancelled'   ? 'selected' : '' }}>ยกเลิก</option>
                                    </select>
                                </div>
                                <div class="flex items-end">
                                    <button type="submit"
                                            class="w-full bg-green-600 hover:bg-green-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition-colors">
                                        บันทึก
                                    </button>
                                </div>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-600 mb-1.5">วิธีแก้ไข / บันทึกการซ่อม</label>
                                <textarea name="solution" rows="2"
                                          class="w-full border border-gray-300 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-[#2563eb] focus:border-[#2563eb] resize-none bg-white text-gray-900 placeholder-gray-400"
                                          placeholder="อธิบายวิธีแก้ไขปัญหา...">{{ $repair->solution }}</textarea>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-16 text-center">
                <div class="w-16 h-16 bg-gray-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
                <p class="text-gray-400 font-medium">ไม่มีงานในสถานะนี้</p>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        <div class="mt-5">{{ $repairs->links() }}</div>

    </div>

<script>
function toggleUpdate(id) {
    const el = document.getElementById('update-' + id);
    el.classList.toggle('hidden');
}
</script>
</x-app-layout>
