{{-- ใบแจ้งซ่อมของตัวเอง (เฉพาะ login เป็น user) --}}
@if(isset($myRepairs) && $myRepairs->count() > 0)
<div class="mb-6">
    <h2 class="font-semibold text-gray-800 dark:text-gray-100 mb-3 flex items-center gap-2">
        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        ใบแจ้งซ่อมของฉัน
        <span class="bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400 text-xs px-2 py-0.5 rounded-full font-semibold">{{ $myRepairs->count() }} รายการ</span>
    </h2>
    <div class="space-y-3">
        @foreach($myRepairs as $r)
        <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-4 cursor-pointer hover:border-blue-300 dark:hover:border-blue-600 hover:shadow-md transition-all"
             onclick="showDetail('{{ ltrim($r->ticket_no, '#') }}')">
            <div class="flex items-center justify-between mb-2">
                <span class="font-mono font-bold text-blue-600 dark:text-blue-400 text-sm">{{ $r->ticket_no }}</span>
                @switch($r->status)
                    @case('new')
                        <span class="bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-400 px-2 py-0.5 rounded-full text-xs font-medium">🆕 ใหม่</span>
                        @break
                    @case('assigned')
                        <span class="bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-400 px-2 py-0.5 rounded-full text-xs font-medium">👤 รับงานแล้ว</span>
                        @break
                    @case('in_progress')
                        <span class="bg-amber-100 dark:bg-amber-900/40 text-amber-700 dark:text-amber-400 px-2 py-0.5 rounded-full text-xs font-medium">🔧 กำลังซ่อม</span>
                        @break
                    @case('done')
                        <span class="bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400 px-2 py-0.5 rounded-full text-xs font-medium">✅ เสร็จแล้ว</span>
                        @break
                    @case('cancelled')
                        <span class="bg-red-100 dark:bg-red-900/40 text-red-700 dark:text-red-400 px-2 py-0.5 rounded-full text-xs font-medium">❌ ยกเลิก</span>
                        @break
                @endswitch
            </div>
            <div class="text-sm font-medium text-gray-800 dark:text-gray-100">{{ $r->equipment->name ?? '—' }}</div>
            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1 flex flex-wrap gap-x-3 gap-y-1">
                @if($r->equipment && $r->equipment->location)
                <span>📍 {{ $r->equipment->location }}</span>
                @endif
                <span>🕐 {{ $r->created_at->format('d/m/Y H:i') }}</span>
                @if($r->technician)
                <span>👨‍🔧 {{ $r->technician->name }}</span>
                @endif
            </div>
            @if($r->status === 'done' && !$r->isRated())
            <div class="mt-2">
                <span class="text-xs text-yellow-600 dark:text-yellow-400 bg-yellow-50 dark:bg-yellow-900/30 px-2 py-0.5 rounded border border-yellow-200 dark:border-yellow-800">⭐ รอการประเมิน</span>
            </div>
            @elseif($r->status === 'done' && $r->isRated())
            <div class="mt-2 flex items-center gap-0.5">
                @for($i = 1; $i <= 5; $i++)
                    <span class="text-xs {{ $i <= $r->rating ? 'text-yellow-400' : 'text-gray-200 dark:text-gray-600' }}">★</span>
                @endfor
                <span class="text-xs text-gray-400 dark:text-gray-500 ml-1">{{ $r->ratingLabel() }}</span>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>

<div class="border-t border-gray-200 dark:border-gray-700 my-5"></div>
<p class="text-xs text-gray-400 dark:text-gray-500 mb-3 text-center">หรือค้นหาด้วยเลขที่ใบแจ้งซ่อม</p>

@elseif(isset($myRepairs) && $myRepairs->count() === 0)
<div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-100 dark:border-gray-700 shadow-sm p-8 text-center mb-6">
    <div class="text-4xl mb-3">📋</div>
    <div class="text-gray-600 dark:text-gray-300 font-medium">ยังไม่มีใบแจ้งซ่อม</div>
    <div class="text-gray-400 dark:text-gray-500 text-sm mt-1 mb-4">คุณยังไม่ได้แจ้งซ่อมอุปกรณ์ใดๆ</div>
    <a href="{{ route('user.repair.create') }}"
       class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-medium transition-colors">
        ➕ แจ้งซ่อมใหม่
    </a>
</div>
<div class="border-t border-gray-200 dark:border-gray-700 my-5"></div>
<p class="text-xs text-gray-400 dark:text-gray-500 mb-3 text-center">หรือค้นหาด้วยเลขที่ใบแจ้งซ่อม</p>
@endif

{{-- Search Form --}}
<div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-5 mb-5 transition-colors duration-200">
    <form action="{{ route('track.search') }}" method="POST" id="search-form">
        @csrf
        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
            เลขที่ใบแจ้งซ่อม
        </label>
        <div class="flex gap-2">
            <div class="relative flex-1">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <span class="text-gray-400 dark:text-gray-500 font-mono text-sm">#</span>
                </div>
                <input type="text" name="ticket_no"
                       value="{{ old('ticket_no', isset($ticket) ? ltrim($ticket, '#') : '') }}"
                       class="w-full border border-gray-300 dark:border-gray-600 rounded-xl pl-8 pr-4 py-3 text-base font-mono focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500"
                       placeholder="เช่น 0001">
            </div>
            <button type="submit"
                    class="bg-blue-700 hover:bg-blue-800 text-white px-6 py-3 rounded-xl font-semibold text-sm transition-colors flex items-center gap-2 whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                ค้นหา
            </button>
        </div>
        @error('ticket_no')
            <p class="text-red-500 dark:text-red-400 text-xs mt-2 flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                {{ $message }}
            </p>
        @enderror
    </form>
</div>

{{-- Results --}}
@if(isset($ticket))
    @if(isset($repair))
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm overflow-hidden transition-colors duration-200">

        {{-- Status Hero --}}
        @php
            $statusConfig = [
                'new'         => ['icon' => '🕐', 'label' => 'รอดำเนินการ',   'sub' => 'เจ้าหน้าที่รับเรื่องแล้ว กำลังมอบหมายช่าง', 'color' => 'blue'],
                'assigned'    => ['icon' => '👨‍🔧', 'label' => 'รับงานแล้ว',  'sub' => 'ช่างรับงานแล้ว กำลังเตรียมดำเนินการ',         'color' => 'purple'],
                'in_progress' => ['icon' => '🔧', 'label' => 'กำลังซ่อม',    'sub' => 'ช่างกำลังดำเนินการซ่อมอยู่',                  'color' => 'amber'],
                'done'        => ['icon' => '✅', 'label' => 'ซ่อมเสร็จแล้ว!','sub' => 'ดำเนินการเสร็จสิ้น กรุณารับอุปกรณ์คืน',    'color' => 'green'],
                'cancelled'   => ['icon' => '❌', 'label' => 'ยกเลิก',        'sub' => 'ใบแจ้งซ่อมนี้ถูกยกเลิก',                     'color' => 'red'],
            ];
            $sc = $statusConfig[$repair->status] ?? $statusConfig['new'];
            $heroBg = [
                'blue'   => 'bg-blue-50 dark:bg-blue-900/20 border-b border-blue-100 dark:border-blue-900',
                'purple' => 'bg-purple-50 dark:bg-purple-900/20 border-b border-purple-100 dark:border-purple-900',
                'amber'  => 'bg-amber-50 dark:bg-amber-900/20 border-b border-amber-100 dark:border-amber-900',
                'green'  => 'bg-green-50 dark:bg-green-900/20 border-b border-green-100 dark:border-green-900',
                'red'    => 'bg-red-50 dark:bg-red-900/20 border-b border-red-100 dark:border-red-900',
            ];
            $labelColor = [
                'blue'   => 'text-blue-700 dark:text-blue-400',
                'purple' => 'text-purple-700 dark:text-purple-400',
                'amber'  => 'text-amber-700 dark:text-amber-400',
                'green'  => 'text-green-700 dark:text-green-400',
                'red'    => 'text-red-700 dark:text-red-400',
            ];
        @endphp

        <div class="{{ $heroBg[$sc['color']] }} p-8 text-center">
            <div class="text-5xl mb-3">{{ $sc['icon'] }}</div>
            <div class="text-xl font-bold {{ $labelColor[$sc['color']] }}">{{ $sc['label'] }}</div>
            <div class="text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $sc['sub'] }}</div>
            <div class="mt-3 inline-flex items-center gap-1.5 text-xs font-mono font-bold text-gray-600 dark:text-gray-300 bg-white dark:bg-gray-800 px-3 py-1.5 rounded-full border border-gray-200 dark:border-gray-600 shadow-sm">
                <svg class="w-3.5 h-3.5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                </svg>
                {{ $repair->ticket_no }}
            </div>
        </div>

        {{-- Timeline --}}
        @php
            $steps      = ['new' => 0, 'assigned' => 1, 'in_progress' => 2, 'done' => 3];
            $current    = $steps[$repair->status] ?? 0;
            $isCancelled = $repair->status === 'cancelled';
        @endphp
        <div class="px-6 py-5 border-b border-gray-100 dark:border-gray-700">
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-4">ความคืบหน้า</p>
            <div class="flex items-center">
                @foreach(['ได้รับเรื่อง', 'รับงาน', 'กำลังซ่อม', 'เสร็จสิ้น'] as $i => $step)
                    <div class="flex flex-col items-center flex-1">
                        <div class="w-9 h-9 rounded-full flex items-center justify-center text-sm font-bold mb-2 transition-all
                            {{ $isCancelled ? 'bg-gray-100 dark:bg-gray-700 text-gray-300 dark:text-gray-600'
                                            : ($current >= $i ? 'bg-blue-600 text-white shadow-md shadow-blue-200 dark:shadow-blue-900'
                                                              : 'bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500') }}">
                            @if(!$isCancelled && $current > $i)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                                </svg>
                            @elseif(!$isCancelled && $current === $i)
                                <div class="w-2.5 h-2.5 bg-white rounded-full"></div>
                            @else
                                <span class="text-xs">{{ $i + 1 }}</span>
                            @endif
                        </div>
                        <div class="text-xs text-center font-medium
                            {{ $isCancelled ? 'text-gray-300 dark:text-gray-600'
                                            : ($current >= $i ? 'text-blue-600 dark:text-blue-400'
                                                              : 'text-gray-400 dark:text-gray-500') }}">
                            {{ $step }}
                        </div>
                    </div>
                    @if($i < 3)
                        <div class="flex-1 h-0.5 mb-5 {{ !$isCancelled && $current > $i ? 'bg-blue-500' : 'bg-gray-200 dark:bg-gray-700' }}"></div>
                    @endif
                @endforeach
            </div>
        </div>

        {{-- Details --}}
        <div class="p-6 space-y-0 text-sm">
            <div class="flex justify-between items-start py-2.5 border-b border-gray-50 dark:border-gray-700">
                <span class="text-gray-500 dark:text-gray-400 font-medium shrink-0 mr-4">อุปกรณ์</span>
                <span class="text-gray-900 dark:text-gray-100 font-semibold text-right">{{ $repair->equipment->name }}</span>
            </div>
            <div class="flex justify-between items-start py-2.5 border-b border-gray-50 dark:border-gray-700">
                <span class="text-gray-500 dark:text-gray-400 font-medium shrink-0 mr-4">หน่วยงาน</span>
                <span class="text-gray-700 dark:text-gray-300 text-right">{{ $repair->department ?? $repair->equipment->location ?? '—' }}</span>
            </div>
            @if($repair->reporter_name)
            <div class="flex justify-between items-start py-2.5 border-b border-gray-50 dark:border-gray-700">
                <span class="text-gray-500 dark:text-gray-400 font-medium shrink-0 mr-4">ผู้แจ้ง</span>
                <span class="text-gray-700 dark:text-gray-300 text-right">
                    {{ $repair->reporter_name }}
                    @if($repair->reporter_phone)
                        <span class="text-gray-400 dark:text-gray-500 text-xs ml-1">({{ $repair->reporter_phone }})</span>
                    @endif
                </span>
            </div>
            @endif
            <div class="flex justify-between items-start py-2.5 border-b border-gray-50 dark:border-gray-700">
                <span class="text-gray-500 dark:text-gray-400 font-medium shrink-0 mr-4">ช่างผู้รับผิดชอบ</span>
                <span class="text-right">
                    @if($repair->technician)
                        <span class="text-purple-700 dark:text-purple-400 font-medium">{{ $repair->technician->name }}</span>
                    @else
                        <span class="text-gray-400 dark:text-gray-500">ยังไม่มอบหมาย</span>
                    @endif
                </span>
            </div>
            <div class="flex justify-between items-start py-2.5 border-b border-gray-50 dark:border-gray-700">
                <span class="text-gray-500 dark:text-gray-400 font-medium shrink-0 mr-4">วันที่แจ้ง</span>
                <span class="text-gray-700 dark:text-gray-300">{{ $repair->created_at->format('d/m/Y H:i') }}</span>
            </div>
            @if($repair->resolved_at)
            <div class="flex justify-between items-start py-2.5 border-b border-gray-50 dark:border-gray-700">
                <span class="text-gray-500 dark:text-gray-400 font-medium shrink-0 mr-4">วันที่เสร็จ</span>
                <span class="text-green-600 dark:text-green-400 font-semibold">{{ $repair->resolved_at->format('d/m/Y H:i') }}</span>
            </div>
            @endif
            <div class="flex justify-between items-start py-2.5">
                <span class="text-gray-500 dark:text-gray-400 font-medium shrink-0 mr-4">ความเร่งด่วน</span>
                @switch($repair->priority)
                    @case('low')    <span class="text-gray-600 dark:text-gray-300">🟢 ปกติ</span> @break
                    @case('medium') <span class="text-yellow-700 dark:text-yellow-500">🟡 ด่วน</span> @break
                    @case('high')   <span class="text-orange-700 dark:text-orange-400">🟠 ด่วนมาก</span> @break
                    @case('urgent') <span class="text-red-700 dark:text-red-400 font-bold">🔴 เร่งด่วนที่สุด</span> @break
                @endswitch
            </div>

            @if($repair->solution)
            <div class="mt-2 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-xl p-4">
                <div class="flex items-center gap-2 mb-2">
                    <svg class="w-4 h-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-sm font-semibold text-green-700 dark:text-green-400">วิธีแก้ไข</span>
                </div>
                <p class="text-sm text-green-800 dark:text-green-300 leading-relaxed">{{ $repair->solution }}</p>
            </div>
            @endif

            {{-- Rating --}}
            @if($repair->status === 'done')
            <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                @if($repair->isRated())
                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-xl p-4 text-center">
                        <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 mb-2">คะแนนที่ให้ไว้</p>
                        <div class="flex justify-center gap-1 mb-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <span class="text-2xl {{ $i <= $repair->rating ? 'text-yellow-400' : 'text-gray-200 dark:text-gray-600' }}">★</span>
                            @endfor
                        </div>
                        <p class="text-sm font-bold text-gray-700 dark:text-gray-300">{{ $repair->ratingLabel() }} ({{ $repair->rating }}/5)</p>
                        @if($repair->rating_comment)
                            <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">"{{ $repair->rating_comment }}"</p>
                        @endif
                    </div>
                @else
                    <a href="{{ route('rating.show', ltrim($repair->ticket_no, '#')) }}"
                       class="flex items-center justify-center gap-2 w-full bg-yellow-400 hover:bg-yellow-500 text-yellow-900 font-bold py-3 rounded-xl text-sm transition-colors shadow-sm">
                        ⭐ ประเมินความพึงพอใจ
                    </a>
                @endif
            </div>
            @endif
        </div>
    </div>

    @else
    <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-12 text-center transition-colors duration-200">
        <div class="w-16 h-16 bg-gray-100 dark:bg-gray-700 rounded-2xl flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-300 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
        </div>
        <p class="text-gray-600 dark:text-gray-300 font-semibold">ไม่พบเลขที่ใบแจ้งซ่อม</p>
        <p class="text-gray-400 dark:text-gray-500 text-sm mt-1">กรุณาตรวจสอบเลขที่อีกครั้ง เช่น #0001</p>
    </div>
    @endif
@endif

{{-- Footer links สำหรับ standalone เท่านั้น --}}
@if(($layout ?? 'standalone') === 'standalone')
<div class="flex flex-col sm:flex-row justify-center items-center gap-3 mt-6 text-sm">
    <a href="{{ route('public.repair') }}"
       class="flex items-center gap-1.5 text-blue-600 dark:text-blue-400 hover:text-blue-800 dark:hover:text-blue-300 font-medium transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
        </svg>
        แจ้งซ่อมรายการใหม่
    </a>
    <span class="text-gray-200 dark:text-gray-700 hidden sm:block">|</span>
    <a href="{{ route('home') }}"
       class="flex items-center gap-1.5 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
        </svg>
        กลับหน้าแรก
    </a>
</div>
@endif

<script>
function showDetail(ticket) {
    document.querySelector('input[name="ticket_no"]').value = ticket;
    document.getElementById('search-form').submit();
}
</script>
