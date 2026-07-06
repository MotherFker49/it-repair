<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            ใบแจ้งซ่อม {{ $repair->ticket_no }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <!-- รายละเอียด -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 mb-6">
                <h3 class="font-semibold text-lg mb-4">รายละเอียด</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="text-gray-500">เลขที่ใบแจ้งซ่อม</span>
                        <p class="font-medium">{{ $repair->ticket_no }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">อุปกรณ์</span>
                        <p class="font-medium">
                            <a href="{{ route('equipments.show', $repair->equipment) }}" class="text-blue-600 hover:underline">
                                {{ $repair->equipment->asset_code }} — {{ $repair->equipment->name }}
                            </a>
                        </p>
                    </div>
                    <div>
                        <span class="text-gray-500">ยี่ห้อ/รุ่น</span>
                        <p class="font-medium">{{ $repair->equipment->brand ?? '-' }} {{ $repair->equipment->model ?? '' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">สถานที่</span>
                        <p class="font-medium">{{ $repair->equipment->location ?? '-' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">ผู้แจ้ง</span>
                        <p class="font-medium">
                            {{ $repair->reporter_name ?? $repair->user->name }}
                            @if($repair->reporter_phone)
                                <span class="text-gray-400 text-xs ml-1">({{ $repair->reporter_phone }})</span>
                            @endif
                        </p>
                    </div>
                    @if($repair->department)
                    <div>
                        <span class="text-gray-500">หน่วยงาน/แผนก</span>
                        <p class="font-medium">{{ $repair->department }}</p>
                    </div>
                    @endif
                    <div>
                        <span class="text-gray-500">ช่างผู้รับผิดชอบ</span>
                        <p class="font-medium">{{ $repair->technician->name ?? 'ยังไม่มีผู้รับงาน' }}</p>
                    </div>
                    <div>
                        <span class="text-gray-500">ความเร่งด่วน</span>
                        <p class="font-medium">
                            @switch($repair->priority)
                                @case('low') <span class="text-gray-500">ปกติ</span> @break
                                @case('medium') <span class="text-blue-600">ด่วน</span> @break
                                @case('high') <span class="text-orange-500">ด่วนมาก</span> @break
                                @case('urgent') <span class="text-red-600 font-bold">เร่งด่วนที่สุด</span> @break
                            @endswitch
                        </p>
                    </div>
                    <div>
                        <span class="text-gray-500">วันที่แจ้ง</span>
                        <p class="font-medium">{{ $repair->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @if($repair->resolved_at)
                    <div>
                        <span class="text-gray-500">วันที่ซ่อมเสร็จ</span>
                        <p class="font-medium text-green-600">{{ $repair->resolved_at->format('d/m/Y H:i') }}</p>
                    </div>
                    @endif
                </div>

                <div class="mt-4">
                    <span class="text-gray-500 text-sm">รายละเอียดปัญหา</span>
                    <p class="mt-1">{{ $repair->description }}</p>
                </div>

                @if($repair->solution)
                <div class="mt-4 bg-green-50 border border-green-200 rounded-lg p-4">
                    <span class="text-green-700 text-sm font-medium">วิธีแก้ไข</span>
                    <p class="mt-1 text-green-800">{{ $repair->solution }}</p>
                </div>
                @endif

                @if ($repair->image_path)
                <div class="mt-4">
                    <span class="text-gray-500 text-sm">รูปภาพประกอบ</span>
                    <img src="{{ asset('storage/' . $repair->image_path) }}" class="mt-2 rounded-lg max-w-sm">
                </div>
                @endif

                <div class="mt-4">
                    <span class="text-gray-500 text-sm">สถานะปัจจุบัน</span>
                    <div class="mt-1">
                        @switch($repair->status)
                            @case('new') <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-sm">ใหม่</span> @break
                            @case('assigned') <span class="bg-purple-100 text-purple-700 px-3 py-1 rounded text-sm">รับงานแล้ว</span> @break
                            @case('in_progress') <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded text-sm">กำลังซ่อม</span> @break
                            @case('done') <span class="bg-green-100 text-green-700 px-3 py-1 rounded text-sm">เสร็จแล้ว</span> @break
                            @case('cancelled') <span class="bg-red-100 text-red-700 px-3 py-1 rounded text-sm">ยกเลิก</span> @break
                        @endswitch
                    </div>
                </div>
            </div>

            <!-- ฟอร์มอัปเดตสถานะ -->
            @hasanyrole('admin|technician')
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="font-semibold text-lg mb-4">อัปเดตสถานะ (สำหรับเจ้าหน้าที่)</h3>

                <form action="{{ route('repairs.status', $repair) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">มอบหมายให้ช่าง</label>
                            <select name="technician_id" class="w-full border-gray-300 rounded-lg shadow-sm">
                                <option value="">-- ยังไม่มอบหมาย --</option>
                                @foreach ($technicians as $tech)
                                    <option value="{{ $tech->id }}" {{ $repair->technician_id == $tech->id ? 'selected' : '' }}>
                                        {{ $tech->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">สถานะ</label>
                            <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm">
                                <option value="new" {{ $repair->status=='new'?'selected':'' }}>ใหม่</option>
                                <option value="assigned" {{ $repair->status=='assigned'?'selected':'' }}>รับงานแล้ว</option>
                                <option value="in_progress" {{ $repair->status=='in_progress'?'selected':'' }}>กำลังซ่อม</option>
                                <option value="done" {{ $repair->status=='done'?'selected':'' }}>เสร็จแล้ว</option>
                                <option value="cancelled" {{ $repair->status=='cancelled'?'selected':'' }}>ยกเลิก</option>
                            </select>
                        </div>

                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">วิธีแก้ไข / บันทึกการซ่อม</label>
                        <textarea name="solution" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm"
                                  placeholder="อธิบายวิธีแก้ไขปัญหา...">{{ old('solution', $repair->solution) }}</textarea>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            บันทึกการอัปเดต
                        </button>
                    </div>
                </form>
            </div>
            @endhasanyrole

            <div class="mt-4">
                <a href="{{ route('repairs.index') }}" class="text-gray-600 hover:underline">&larr; กลับไปหน้ารายการ</a>
            </div>

        </div>
    </div>
</x-app-layout>