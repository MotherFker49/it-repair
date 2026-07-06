<x-user-layout>
    <x-slot name="header">รายละเอียดใบแจ้งซ่อม {{ $repair->ticket_no }}</x-slot>

    <div class="max-w-2xl mx-auto space-y-5">

        {{-- ข้อมูลหลัก --}}
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                <div>
                    <span class="font-mono font-bold text-blue-700 text-lg">{{ $repair->ticket_no }}</span>
                    <span class="ml-2 text-sm text-gray-400">· {{ $repair->created_at->format('d/m/Y H:i') }}</span>
                </div>
                <div class="flex items-center gap-2">
                    @switch($repair->status)
                        @case('new')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">ใหม่</span>
                            @break
                        @case('assigned')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">รับงานแล้ว</span>
                            @break
                        @case('in_progress')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">กำลังซ่อม</span>
                            @break
                        @case('done')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">เสร็จแล้ว</span>
                            @break
                        @case('cancelled')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-600">ยกเลิก</span>
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
                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-500 border border-gray-200">🟢 ปกติ</span>
                            @break
                    @endswitch
                </div>
            </div>

            <div class="px-6 py-5 grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-xs text-gray-400 mb-1">อุปกรณ์</p>
                    <p class="font-semibold text-gray-900">{{ $repair->equipment->name }}</p>
                    <p class="text-xs text-gray-400 font-mono">{{ $repair->equipment->asset_code }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">สถานที่</p>
                    <p class="font-medium text-gray-900">{{ $repair->department ?? $repair->equipment->location ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-xs text-gray-400 mb-1">ช่างผู้รับผิดชอบ</p>
                    @if($repair->technician)
                        <p class="font-medium text-purple-700">{{ $repair->technician->name }}</p>
                    @else
                        <p class="text-gray-400">รอมอบหมาย</p>
                    @endif
                </div>
                <div class="col-span-2">
                    <p class="text-xs text-gray-400 mb-2">อาการ / ปัญหา</p>
                    <div class="bg-gray-50 rounded-xl px-4 py-3 text-gray-700 leading-relaxed">{{ $repair->description }}</div>
                </div>
                @if($repair->solution)
                <div class="col-span-2">
                    <p class="text-xs text-gray-400 mb-2">วิธีแก้ไข</p>
                    <div class="bg-green-50 border border-green-100 rounded-xl px-4 py-3 text-gray-700 leading-relaxed">{{ $repair->solution }}</div>
                </div>
                @endif
            </div>

            @if($repair->image_path)
            <div class="px-6 pb-5">
                <p class="text-xs text-gray-400 mb-2">รูปภาพประกอบ</p>
                <a href="{{ asset('storage/'.$repair->image_path) }}" target="_blank">
                    <img src="{{ asset('storage/'.$repair->image_path) }}" alt="repair"
                         class="max-h-48 rounded-xl border border-gray-200 object-cover hover:opacity-80 transition-opacity">
                </a>
            </div>
            @endif
        </div>

        {{-- Progress Timeline --}}
        @php
            $statusOrder = ['new' => 1, 'assigned' => 2, 'in_progress' => 3, 'done' => 4];
            $currentStep = $statusOrder[$repair->status] ?? 0;
            $isCancelled = $repair->status === 'cancelled';
            $steps = [
                ['step' => 1, 'label' => 'แจ้งซ่อมแล้ว',   'sub' => $repair->created_at->format('d/m/Y H:i')],
                ['step' => 2, 'label' => 'ช่างรับงาน',       'sub' => $repair->technician?->name ?? 'รอมอบหมาย'],
                ['step' => 3, 'label' => 'กำลังดำเนินการ',   'sub' => $repair->start_repair_at?->format('d/m/Y H:i') ?? ''],
                ['step' => 4, 'label' => 'ซ่อมเสร็จแล้ว',   'sub' => $repair->resolved_at?->format('d/m/Y H:i') ?? ''],
            ];
        @endphp

        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            <h3 class="font-semibold text-gray-900 mb-5 text-sm">ความคืบหน้า</h3>

            @if($isCancelled)
            <div class="flex items-center gap-3 bg-red-50 border border-red-200 rounded-xl px-4 py-3">
                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center shrink-0">
                    <svg class="w-4 h-4 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-red-700 text-sm">ใบแจ้งซ่อมถูกยกเลิก</p>
                    <p class="text-xs text-red-500">ติดต่อฝ่าย IT หากต้องการข้อมูลเพิ่มเติม</p>
                </div>
            </div>
            @else
            <div class="flex items-start gap-0">
                @foreach($steps as $s)
                @php
                    $done   = $currentStep > $s['step'];
                    $active = $currentStep === $s['step'];
                @endphp
                <div class="flex flex-col items-center flex-1">
                    {{-- Circle --}}
                    <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0 z-10
                        {{ $done   ? 'bg-green-500 text-white' :
                           ($active ? 'bg-blue-600 text-white ring-4 ring-blue-100' :
                                      'bg-gray-100 text-gray-400') }}">
                        @if($done)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                            </svg>
                        @elseif($active)
                            <div class="w-2.5 h-2.5 bg-white rounded-full"></div>
                        @else
                            <span class="text-xs font-bold">{{ $s['step'] }}</span>
                        @endif
                    </div>
                    {{-- Label --}}
                    <div class="mt-2 text-center px-1">
                        <p class="text-xs font-semibold {{ $done || $active ? 'text-gray-900' : 'text-gray-400' }}">{{ $s['label'] }}</p>
                        @if($s['sub'])
                            <p class="text-xs text-gray-400 mt-0.5">{{ $s['sub'] }}</p>
                        @endif
                    </div>
                </div>
                {{-- Connector --}}
                @if(!$loop->last)
                <div class="flex-1 h-0.5 mt-4 {{ $currentStep > $s['step'] ? 'bg-green-400' : 'bg-gray-200' }}"></div>
                @endif
                @endforeach
            </div>
            @endif
        </div>

        {{-- Rating --}}
        @if($repair->status === 'done')
        <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6">
            @if($repair->isRated())
            <h3 class="font-semibold text-gray-900 mb-3 text-sm">คะแนนความพึงพอใจของคุณ</h3>
            <div class="flex items-center gap-2">
                @for($i = 1; $i <= 5; $i++)
                    <span class="text-xl {{ $i <= $repair->rating ? 'text-yellow-400' : 'text-gray-200' }}">★</span>
                @endfor
                <span class="font-semibold text-yellow-700 ml-1">{{ $repair->rating }}/5 — {{ $repair->ratingLabel() }}</span>
            </div>
            @if($repair->rating_comment)
                <p class="mt-2 text-sm text-gray-500 italic">"{{ $repair->rating_comment }}"</p>
            @endif
            @else
            <div class="text-center py-2">
                <p class="text-sm text-gray-600 mb-3">การซ่อมเสร็จสิ้นแล้ว — กรุณาประเมินความพึงพอใจ</p>
                <a href="{{ route('rating.show', $repair->ticket_no) }}"
                   class="inline-flex items-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-yellow-900 px-5 py-2.5 rounded-xl text-sm font-bold transition-colors shadow-sm">
                    ⭐ ประเมินความพึงพอใจ
                </a>
            </div>
            @endif
        </div>
        @endif

        {{-- Actions --}}
        <div class="flex items-center justify-between pb-2">
            <a href="{{ route('user.dashboard') }}" class="text-sm text-gray-500 hover:text-gray-700 hover:underline">
                ← กลับหน้าหลัก
            </a>
            <a href="{{ route('user.repair.create') }}"
               class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white px-4 py-2 rounded-xl text-sm font-semibold transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                แจ้งซ่อมใหม่
            </a>
        </div>

    </div>
</x-user-layout>
