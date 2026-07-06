<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            แจ้งซ่อมอุปกรณ์
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('repairs.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- เลือกอุปกรณ์ -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">อุปกรณ์ที่ต้องการซ่อม</label>
                        <select name="equipment_id" class="w-full border-gray-300 rounded-lg shadow-sm">
                            <option value="">-- เลือกอุปกรณ์ --</option>
                            @foreach ($equipments as $eq)
                                <option value="{{ $eq->id }}">{{ $eq->asset_code }} — {{ $eq->name }}</option>
                            @endforeach
                        </select>
                        @error('equipment_id')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- ระดับความเร่งด่วน -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">ความเร่งด่วน</label>
                        <select name="priority" class="w-full border-gray-300 rounded-lg shadow-sm">
                            <option value="low">ปกติ</option>
                            <option value="medium" selected>ด่วน</option>
                            <option value="high">ด่วนมาก</option>
                            <option value="urgent">เร่งด่วนที่สุด</option>
                        </select>
                    </div>

                    <!-- รายละเอียด -->
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">อธิบายปัญหา</label>
                        <textarea name="description" rows="4" class="w-full border-gray-300 rounded-lg shadow-sm"
                                  placeholder="เช่น จอค้าง เปิดไม่ติด เสียงดัง...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- แนบรูป -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">แนบรูปภาพ (ถ้ามี)</label>
                        <input type="file" name="image" accept="image/*" class="w-full text-sm">
                        @error('image')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex gap-3">
                        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                            ส่งใบแจ้งซ่อม
                        </button>
                        <a href="{{ route('dashboard') }}" class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300">
                            ยกเลิก
                        </a>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>