<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                แก้ไขใบแจ้งซ่อม {{ $repair->ticket_no }}
            </h2>
            <a href="{{ route('repairs.show', $repair) }}" class="text-sm text-gray-500 hover:underline">
                &larr; กลับ
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg text-sm">
                    <ul class="list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form action="{{ route('repairs.status', $repair) }}" method="POST">
                    @csrf
                    @method('PATCH')

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">สถานะ</label>
                        <select name="status" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="new"         {{ $repair->status=='new'         ? 'selected':'' }}>ใหม่</option>
                            <option value="assigned"    {{ $repair->status=='assigned'    ? 'selected':'' }}>รับงานแล้ว</option>
                            <option value="in_progress" {{ $repair->status=='in_progress' ? 'selected':'' }}>กำลังซ่อม</option>
                            <option value="done"        {{ $repair->status=='done'        ? 'selected':'' }}>เสร็จแล้ว</option>
                            <option value="cancelled"   {{ $repair->status=='cancelled'   ? 'selected':'' }}>ยกเลิก</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">มอบหมายให้ช่าง</label>
                        <select name="technician_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- ยังไม่มอบหมาย --</option>
                            @foreach ($technicians as $tech)
                                <option value="{{ $tech->id }}" {{ $repair->technician_id == $tech->id ? 'selected' : '' }}>
                                    {{ $tech->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-1">วิธีแก้ไข / บันทึกการซ่อม</label>
                        <textarea name="solution" rows="4"
                                  class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500"
                                  placeholder="อธิบายวิธีแก้ไขปัญหา...">{{ old('solution', $repair->solution) }}</textarea>
                    </div>

                    <div class="flex gap-3">
                        <button type="submit"
                                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition-colors">
                            บันทึก
                        </button>
                        <a href="{{ route('repairs.show', $repair) }}"
                           class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 transition-colors">
                            ยกเลิก
                        </a>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
