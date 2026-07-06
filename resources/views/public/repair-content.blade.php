
        @if ($errors->any())
            <div class="bg-red-50 dark:bg-red-900/30 border border-red-200 dark:border-red-700 text-red-700 dark:text-red-300 px-5 py-4 rounded-2xl mb-5 flex gap-3">
                <svg class="w-5 h-5 text-red-500 dark:text-red-400 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <p class="font-semibold text-sm mb-1">กรุณาแก้ไขข้อมูลดังนี้</p>
                    <ul class="text-sm space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>• {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('public.repair.store') }}" method="POST" enctype="multipart/form-data" id="repair-form">
            @csrf

            <!-- ส่วนที่ 1: ข้อมูลผู้แจ้ง -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6 mb-5 transition-colors duration-200">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-blue-700 rounded-xl flex items-center justify-center shrink-0">
                        <span class="text-white font-bold text-sm">1</span>
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900 dark:text-gray-100">ข้อมูลผู้แจ้ง</h2>
                        <p class="text-xs text-gray-400 dark:text-gray-500">ข้อมูลสำหรับติดต่อกลับ</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            ชื่อ-นามสกุล <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="reporter_name" value="{{ old('reporter_name') }}"
                               class="w-full border {{ $errors->has('reporter_name') ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 dark:border-gray-600' }} rounded-xl px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500"
                               placeholder="เช่น นางสาวสมหญิง ใจดี">
                    </div>
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            เบอร์โทรศัพท์
                            <span class="text-gray-400 dark:text-gray-500 font-normal text-xs ml-1">(ไม่บังคับ)</span>
                        </label>
                        <input type="tel" name="reporter_phone" value="{{ old('reporter_phone') }}"
                               class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500"
                               placeholder="เช่น 039-123456 หรือ 081-234-5678">
                    </div>
                </div>
            </div>

            <!-- ส่วนที่ 2: สถานที่และอุปกรณ์ -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6 mb-5 transition-colors duration-200">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-blue-700 rounded-xl flex items-center justify-center shrink-0">
                        <span class="text-white font-bold text-sm">2</span>
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900 dark:text-gray-100">สถานที่และอุปกรณ์</h2>
                        <p class="text-xs text-gray-400 dark:text-gray-500">ระบุหน่วยงานและอุปกรณ์ที่ต้องการซ่อม</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <!-- Autocomplete Location -->
                    <div class="relative">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            หน่วยงาน / สถานที่ <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="location" id="location" value="{{ old('location') }}"
                                   class="w-full border {{ $errors->has('location') ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 dark:border-gray-600' }} rounded-xl pl-11 pr-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500"
                                   placeholder="พิมพ์เพื่อค้นหาหน่วยงาน..." autocomplete="off">
                        </div>
                        <div id="location-list"
                             class="hidden absolute z-20 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg max-h-52 overflow-y-auto w-full mt-1.5">
                        </div>
                    </div>

                    <!-- AJAX Equipment Search -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            อุปกรณ์ที่ต้องการซ่อม
                            <span class="text-gray-400 dark:text-gray-500 font-normal text-xs ml-1">(ค้นหาจากระบบ)</span>
                        </label>
                        <input type="hidden" name="equipment_id" id="eq_id">
                        <div class="relative">
                            <input type="text" id="eq_search"
                                   placeholder="พิมพ์รหัส รพจ หรือชื่ออุปกรณ์..."
                                   autocomplete="off"
                                   class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500">
                            <div id="eq_dropdown"
                                 class="hidden absolute z-20 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg max-h-52 overflow-y-auto w-full mt-1.5"></div>
                        </div>
                        <div id="eq_card" class="hidden mt-2 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-xl p-3">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-sm text-gray-900 dark:text-gray-100" id="eq_card_name"></div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-0.5" id="eq_card_details"></div>
                                    <span id="eq_warranty_badge" class="hidden inline-flex items-center gap-1 mt-1 text-xs px-2 py-0.5 rounded-full"></span>
                                </div>
                                <button type="button" onclick="clearEquipment()"
                                        class="text-gray-400 hover:text-red-500 transition-colors ml-2 shrink-0 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Custom Equipment Name -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            หรือระบุชื่ออุปกรณ์เอง
                            <span class="text-gray-400 dark:text-gray-500 font-normal text-xs ml-1">(กรณีไม่พบในรายการ)</span>
                        </label>
                        <input type="text" name="equipment_name" value="{{ old('equipment_name') }}"
                               class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500"
                               placeholder="เช่น คอมพิวเตอร์ตั้งโต๊ะ, เครื่องพิมพ์ Epson, โทรศัพท์">
                    </div>

                    <!-- ยี่ห้อ -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            ยี่ห้อ
                            <span class="text-gray-400 dark:text-gray-500 font-normal text-xs ml-1">(ไม่บังคับ)</span>
                        </label>
                        <select id="brand" name="brand"
                                class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100">
                            <option value="">-- เลือกยี่ห้อ --</option>
                            <optgroup label="🖥️ คอมพิวเตอร์/โน้ตบุ๊ก">
                                <option @selected(old('brand') == 'Dell')>Dell</option>
                                <option @selected(old('brand') == 'HP')>HP</option>
                                <option @selected(old('brand') == 'Lenovo')>Lenovo</option>
                                <option @selected(old('brand') == 'Acer')>Acer</option>
                                <option @selected(old('brand') == 'Asus')>Asus</option>
                            </optgroup>
                            <optgroup label="🖨️ เครื่องพิมพ์/ถ่ายเอกสาร">
                                <option @selected(old('brand') == 'Canon')>Canon</option>
                                <option @selected(old('brand') == 'Epson')>Epson</option>
                                <option @selected(old('brand') == 'Fuji Xerox')>Fuji Xerox</option>
                                <option @selected(old('brand') == 'Brother')>Brother</option>
                                <option @selected(old('brand') == 'Konica Minolta')>Konica Minolta</option>
                                <option @selected(old('brand') == 'Ricoh')>Ricoh</option>
                                <option @selected(old('brand') == 'Sharp')>Sharp</option>
                                <option @selected(old('brand') == 'Samsung')>Samsung</option>
                                <option @selected(old('brand') == 'Star')>Star</option>
                                <option @selected(old('brand') == 'Bixolon')>Bixolon</option>
                                <option @selected(old('brand') == 'Citizen')>Citizen</option>
                            </optgroup>
                            <optgroup label="🌐 อุปกรณ์เครือข่าย">
                                <option @selected(old('brand') == 'Cisco')>Cisco</option>
                                <option @selected(old('brand') == 'D-Link')>D-Link</option>
                                <option @selected(old('brand') == 'Ubiquiti')>Ubiquiti</option>
                                <option @selected(old('brand') == 'Tp-Link')>Tp-Link</option>
                            </optgroup>
                            <optgroup label="🖥️ จอมอนิเตอร์">
                                <option @selected(old('brand') == 'LG')>LG</option>
                                <option @selected(old('brand') == 'Philips')>Philips</option>
                            </optgroup>
                            <optgroup label="🔌 UPS">
                                <option @selected(old('brand') == 'APC')>APC</option>
                                <option @selected(old('brand') == 'Eaton')>Eaton</option>
                                <option @selected(old('brand') == 'CyberPower')>CyberPower</option>
                            </optgroup>
                            <optgroup label="❓ อื่นๆ">
                                <option @selected(old('brand') == 'อื่นๆ (ระบุเอง)')>อื่นๆ (ระบุเอง)</option>
                            </optgroup>
                        </select>
                    </div>

                    <!-- รุ่น (มี autocomplete) -->
                    <div class="relative">
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            รุ่น
                            <span class="text-gray-400 dark:text-gray-500 font-normal text-xs ml-1">(ไม่บังคับ)</span>
                        </label>
                        <input type="text" id="model" name="model" value="{{ old('model') }}"
                               class="w-full border border-gray-300 dark:border-gray-600 rounded-xl px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500"
                               placeholder="เลือกยี่ห้อก่อน หรือพิมพ์รุ่นเอง"
                               autocomplete="off">
                        <div id="model-list"
                             class="hidden absolute z-10 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl shadow-lg max-h-48 overflow-y-auto w-full mt-1.5">
                        </div>
                    </div>
                </div>
            </div>

            <!-- ส่วนที่ 3: รายละเอียดปัญหา -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 shadow-sm p-6 mb-5 transition-colors duration-200">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-blue-700 rounded-xl flex items-center justify-center shrink-0">
                        <span class="text-white font-bold text-sm">3</span>
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900 dark:text-gray-100">รายละเอียดปัญหา</h2>
                        <p class="text-xs text-gray-400 dark:text-gray-500">อธิบายอาการและความเร่งด่วน</p>
                    </div>
                </div>

                <div class="space-y-5">

                    <!-- Priority Cards -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-3">
                            ความเร่งด่วน <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">

                            <label class="priority-label cursor-pointer">
                                <input type="radio" name="priority" value="low" class="sr-only"
                                       {{ old('priority') == 'low' ? 'checked' : '' }}>
                                <div class="priority-card border-2 border-gray-200 dark:border-gray-600 rounded-xl p-3.5 text-center transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                    <div class="text-2xl mb-1.5">🟢</div>
                                    <div class="text-sm font-semibold text-gray-800 dark:text-gray-200">ปกติ</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">ไม่เร่งด่วน</div>
                                </div>
                            </label>

                            <label class="priority-label cursor-pointer">
                                <input type="radio" name="priority" value="medium" class="sr-only"
                                       {{ old('priority', 'medium') == 'medium' ? 'checked' : '' }}>
                                <div class="priority-card border-2 border-gray-200 dark:border-gray-600 rounded-xl p-3.5 text-center transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                    <div class="text-2xl mb-1.5">🟡</div>
                                    <div class="text-sm font-semibold text-gray-800 dark:text-gray-200">ด่วน</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">ควรซ่อมวันนี้</div>
                                </div>
                            </label>

                            <label class="priority-label cursor-pointer">
                                <input type="radio" name="priority" value="high" class="sr-only"
                                       {{ old('priority') == 'high' ? 'checked' : '' }}>
                                <div class="priority-card border-2 border-gray-200 dark:border-gray-600 rounded-xl p-3.5 text-center transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                    <div class="text-2xl mb-1.5">🟠</div>
                                    <div class="text-sm font-semibold text-gray-800 dark:text-gray-200">ด่วนมาก</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">กระทบการทำงาน</div>
                                </div>
                            </label>

                            <label class="priority-label cursor-pointer">
                                <input type="radio" name="priority" value="urgent" class="sr-only"
                                       {{ old('priority') == 'urgent' ? 'checked' : '' }}>
                                <div class="priority-card border-2 border-gray-200 dark:border-gray-600 rounded-xl p-3.5 text-center transition-all hover:border-gray-300 dark:hover:border-gray-500">
                                    <div class="text-2xl mb-1.5">🔴</div>
                                    <div class="text-sm font-semibold text-gray-800 dark:text-gray-200">เร่งด่วนที่สุด</div>
                                    <div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">หยุดให้บริการ</div>
                                </div>
                            </label>

                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            อธิบายปัญหา <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" rows="4"
                                  class="w-full border {{ $errors->has('description') ? 'border-red-400 bg-red-50 dark:bg-red-900/20' : 'border-gray-300 dark:border-gray-600' }} rounded-xl px-4 py-3 text-base focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100 placeholder-gray-400 dark:placeholder-gray-500"
                                  placeholder="เช่น เปิดไม่ติด, จอดำ, พิมพ์ไม่ออก, เน็ตหลุดบ่อย, ช้ามาก...">{{ old('description') }}</textarea>
                    </div>

                    <!-- Image Upload -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                            รูปภาพประกอบ
                            <span class="text-gray-400 dark:text-gray-500 font-normal text-xs ml-1">(ไม่บังคับ, JPG/PNG ไม่เกิน 2MB)</span>
                        </label>
                        <label for="image-input"
                               class="block border-2 border-dashed border-gray-300 dark:border-gray-600 rounded-xl p-6 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-all group">
                            <input type="file" name="image" id="image-input" accept="image/*" capture="environment" class="sr-only">
                            <div id="upload-placeholder">
                                <div class="w-12 h-12 bg-gray-100 dark:bg-gray-700 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-100 dark:group-hover:bg-blue-900/40 transition-colors">
                                    <svg class="w-6 h-6 text-gray-400 dark:text-gray-500 group-hover:text-blue-600 dark:group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-600 dark:text-gray-300 font-medium group-hover:text-blue-700 dark:group-hover:text-blue-400">แตะเพื่อถ่ายรูปหรือเลือกไฟล์</p>
                                <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">รองรับ JPG, PNG</p>
                            </div>
                            <div id="image-preview" class="hidden">
                                <img id="preview-img" class="max-h-40 mx-auto rounded-xl object-cover mb-2">
                                <p id="file-name" class="text-xs text-gray-500 dark:text-gray-400"></p>
                                <p class="text-xs text-blue-600 dark:text-blue-400 mt-1">แตะเพื่อเปลี่ยนรูป</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" id="submit-btn"
                    class="w-full bg-blue-700 hover:bg-blue-800 active:bg-blue-900 text-white py-4 rounded-2xl text-base font-bold transition-colors shadow-md flex items-center justify-center gap-2">
                <svg id="submit-icon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                <span id="submit-text">ส่งใบแจ้งซ่อม</span>
            </button>

            <!-- Back link -->
            <a href="{{ route('home') }}"
               class="flex items-center justify-center gap-2 w-full mt-3 py-3 text-sm text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-200 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                กลับหน้าแรก
            </a>

            <p class="text-center text-xs text-gray-400 dark:text-gray-500 mt-3">
                หลังส่งแบบฟอร์ม เจ้าหน้าที่ IT จะได้รับแจ้งเตือนทันที
            </p>

        </form>

<script>
/* Priority card selection */
function updatePriorityCards() {
    document.querySelectorAll('.priority-label').forEach(label => {
        const radio = label.querySelector('input[type=radio]');
        const card = label.querySelector('.priority-card');
        if (radio.checked) {
            card.classList.add('border-blue-600', 'bg-blue-50', 'dark:bg-blue-900/30', 'shadow-sm');
            card.classList.remove('border-gray-200', 'dark:border-gray-600');
        } else {
            card.classList.remove('border-blue-600', 'bg-blue-50', 'dark:bg-blue-900/30', 'shadow-sm');
            card.classList.add('border-gray-200', 'dark:border-gray-600');
        }
    });
}
document.querySelectorAll('.priority-label input').forEach(radio => {
    radio.addEventListener('change', updatePriorityCards);
});
updatePriorityCards();

/* Image preview */
document.getElementById('image-input').addEventListener('change', function() {
    const file = this.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = e => {
        document.getElementById('preview-img').src = e.target.result;
        document.getElementById('file-name').textContent = file.name + ' (' + (file.size / 1024).toFixed(0) + ' KB)';
        document.getElementById('image-preview').classList.remove('hidden');
        document.getElementById('upload-placeholder').classList.add('hidden');
    };
    reader.readAsDataURL(file);
});

/* Submit loading state */
document.getElementById('repair-form').addEventListener('submit', function() {
    const btn = document.getElementById('submit-btn');
    const icon = document.getElementById('submit-icon');
    const text = document.getElementById('submit-text');
    btn.disabled = true;
    btn.classList.add('opacity-75', 'cursor-not-allowed');
    icon.outerHTML = '<svg id="submit-icon" class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';
    text.textContent = 'กำลังส่ง...';
});

/* ======= Brand/Model Autocomplete ======= */
const brandModels = {
    "Dell": ["OptiPlex 3000","OptiPlex 5000","OptiPlex 7000","Latitude 3540","Latitude 5540","Latitude 7440","E2422H","P2422H","U2422H","PowerEdge T40","PowerEdge T140"],
    "HP": ["ProDesk 400 G9","ProDesk 600 G9","ProBook 440 G10","EliteBook 840 G10","LaserJet Pro M404dn","LaserJet Pro M428fdw","P24h G5","E24 G5","Aruba 1920S-24G","Aruba 2530-24G"],
    "Lenovo": ["ThinkCentre M70s","ThinkCentre M90s","ThinkPad E14","ThinkPad L14","ThinkPad T14","ThinkVision T24i","ThinkVision P27h"],
    "Acer": ["Veriton X2690","Veriton X4690","TravelMate P2","TravelMate P4","V247Y","B247Y","B277"],
    "Asus": ["ExpertBook B1400","ExpertBook B5302","ProArt PA278QV","TUF Gaming VG27AQ"],
    "Canon": ["imageCLASS LBP6030","imageCLASS LBP6230","imageCLASS MF267dw","imageCLASS MF269dw","imageRUNNER 2625i","imageRUNNER 2630i","imageRUNNER 2645i","imageRUNNER ADVANCE C5560i"],
    "Epson": ["TM-T82X","TM-T88VI","TM-T88VII","L3210","L3250","L5290","WF-3820","WF-7840"],
    "Fuji Xerox": ["DocuPrint P375d","DocuPrint M375z","ApeosPort 3560","ApeosPort 4560","ApeosPort 5570","ApeosPort C3070"],
    "Brother": ["HL-L2370DN","HL-L2375DW","MFC-L2750DW","MFC-L2770DW","DCP-L2540DW","DCP-L2560DW"],
    "Konica Minolta": ["Bizhub 225i","Bizhub 308e","Bizhub 368e","Bizhub 458e","Bizhub C250i","Bizhub C300i"],
    "Ricoh": ["IM 2702","IM 3702","IM 4702","IM 5702","IM C2000","IM C3000"],
    "Sharp": ["MX-3061","MX-4061","MX-3071","MX-4071","MX-5071","MX-6071"],
    "Star": ["TSP143III","TSP654II","TSP743II","mC-Print3"],
    "Bixolon": ["SRP-350plusIII","SRP-380","SRP-F310II","SRP-Q300"],
    "Citizen": ["CT-S310II","CT-S651","CT-S801II","CL-S521"],
    "Cisco": ["SG350-28","SG350-52","SG550X-24","SG550X-48","Catalyst 2960-X","Catalyst 9200"],
    "D-Link": ["DGS-1210-28","DGS-1210-52","DGS-1510-28X","DXS-1210-12TC","DAP-2682","DAP-2610"],
    "Ubiquiti": ["UniFi AP AC Pro","UniFi AP AC Lite","UniFi AP AC HD","UniFi AP WiFi 6","UniFi Switch 24","UniFi Switch 48"],
    "Tp-Link": ["TL-SG1024D","TL-SG1048","EAP670","EAP660 HD","TL-SG3428","TL-SG3452"],
    "APC": ["Back-UPS 650VA","Back-UPS 1000VA","Back-UPS 1500VA","Smart-UPS 1000VA","Smart-UPS 1500VA","Smart-UPS 3000VA"],
    "Eaton": ["5E 650VA","5E 1000VA","5SC 1000VA","5SC 1500VA","9SX 1000VA","9SX 2000VA"],
    "CyberPower": ["CP650AVRG","CP1000AVRLCD","CP1500AVRLCD","PR1500","PR2200","OL1000ERTXL2U"],
    "LG": ["24MK430H","27UK850","27BN650Y","32UN880","34WN80C","38WN95C"],
    "Philips": ["243V7","272V8","275E1S","288E2A","326E8FJSB","346B1C"],
    "Samsung": ["Xpress M2835DW","Xpress M4020ND","SL-M4070FR","SL-M5370LX","C43J890DKE","U32J590UQE"]
};

const brandSelect = document.getElementById('brand');
const modelInput  = document.getElementById('model');
const modelList   = document.getElementById('model-list');

function showModelDropdown(models) {
    modelList.innerHTML = '';
    models.forEach(m => {
        const div = document.createElement('div');
        div.className = 'px-4 py-3 hover:bg-blue-50 dark:hover:bg-blue-900/30 cursor-pointer text-sm text-gray-700 dark:text-gray-200 border-b border-gray-100 dark:border-gray-700 last:border-0 transition-colors';
        div.textContent = m;
        div.addEventListener('mousedown', e => {
            e.preventDefault();
            modelInput.value = m;
            modelList.classList.add('hidden');
        });
        modelList.appendChild(div);
    });
    modelList.classList.remove('hidden');
}

brandSelect.addEventListener('change', function() {
    const brand = this.value;
    modelInput.value = '';
    if (brandModels[brand]) {
        showModelDropdown(brandModels[brand]);
        modelInput.focus();
    } else {
        modelList.classList.add('hidden');
    }
});

modelInput.addEventListener('focus', function() {
    const brand = brandSelect.value;
    if (!this.value && brandModels[brand]) {
        showModelDropdown(brandModels[brand]);
    }
});

modelInput.addEventListener('input', function() {
    const brand = brandSelect.value;
    const val = this.value.toLowerCase();
    if (!val) {
        if (brandModels[brand]) showModelDropdown(brandModels[brand]);
        else modelList.classList.add('hidden');
        return;
    }
    const pool = brandModels[brand] || Object.values(brandModels).flat();
    const filtered = pool.filter(m => m.toLowerCase().includes(val));
    if (filtered.length) showModelDropdown(filtered);
    else modelList.classList.add('hidden');
});

document.addEventListener('click', e => {
    if (!modelInput.contains(e.target) && !modelList.contains(e.target)) {
        modelList.classList.add('hidden');
    }
});

/* ======= Location Autocomplete ======= */
document.addEventListener('DOMContentLoaded', function() {
    const locations = [
        "กลุ่มการพยาบาล(IT)","กลุ่มงานการพยาบาลชุมชน","กลุ่มงานข้อมูลทางการแพทย์",
        "กลุ่มงานโครงสร้างพื้นฐานและวิศวกรรมทางการแพทย์","กลุ่มงานเทคโนโลยีสารสนเทศ",
        "กลุ่มงานนิติเวช","กลุ่มงานบริการทันตกรรมปฐมภูมิและทุติยภูมิ","กลุ่มงานบริหารทั่วไป",
        "กลุ่มงานประกันสุขภาพ","กลุ่มงานพัฒนาคุณภาพบริการและมาตรฐาน",
        "กลุ่มงานพัฒนาคุณภาพบริการและวิชาการทันตกรรม","กลุ่มงานเวชระเบียนและข้อมูลทางการแพทย์",
        "กลุ่มงานสังคมสงเคราะห์","กลุ่มงานสารสนเทศทางการแพทย์","กลุ่มงานสุขภาพดิจิทัล",
        "กลุ่มงานสุขศึกษา","กลุ่มงานอาชีวเวชกรรม","คลินิกนมแม่",
        "คลินิกพิเศษเฉพาะทางนอกเวลาราชการ","งานกายภาพบำบัด","งานกายอุปกรณ์",
        "งานการแพทย์ทางเลือก","งานการแพทย์แผนไทย","งานกิจกรรมบำบัด","งานคลังยา",
        "งานจิตวิทยาคลินิก","งานจุลชีววิทยา","งานซ่อมสร้างอุปกรณ์คนพิการ",
        "งานซ่อมอุปกรณ์ทางการแพทย์","งานตึกคลอด","งานเตรียม TPN และน้ำเกลือ",
        "งานเตรียมยาเคมีบำบัด","งานโทรศัพท์","งานนิติการ","งานบริจาคและปลูกถ่ายอวัยวะ",
        "งานบริบาลเภสัชกรรมผู้ป่วยใน","งานบริหารลูกหนี้","งานประชาสัมพันธ์",
        "งานปั่นแยกส่วนประกอบโลหิต","งานภูมิคุ้มกันวิทยาและเคมีคลินิก",
        "งานเภสัชกรรม รพ.เมือง","งานเภสัชสนเทศ","งานรังสีรักษา","งานรังสีรักษา(แพทย์)",
        "งานรังสีวินิจฉัย","งานรังสีวินิจฉัย(แพทย์)","งานรับสิ่งส่งตรวจ",
        "งานเลขานุการ 1","งานเลขานุการ 2","งานโลหิตวิทยาและจุลทรรศนศาสตร์",
        "งานวิสัญญีพยาบาล(อาคารเทพรัตน์)","งานวิสัญญีพยาบาล(อาคารผ่าตัด)",
        "งานเวชกรรมฟื้นฟู","งานเวชปฏิบัติครอบครัวและชุมชนและศูนย์สุขภาพชุมชนเขตเมือง (ทันตกรรม)",
        "งานเวชปฏิบัติครอบครัวและชุมชนและศูนย์สุขภาพชุมชนเขตเมือง(ก.เภสัชกรรม)",
        "งานเวชปฏิบัติครอบครัวและชุมชนและศูนย์สุขภาพชุมชนเขตเมือง","งานเวชศาสตร์ครอบครัว",
        "งานศูนย์โรคหัวใจ","งานศูนย์สาธิตเครื่องช่วยคนพิการ","งานศูนย์อ๊อกซิเจน",
        "งานสารบรรณ","งานสำนักงานกลุ่มงานเภสัชกรรม","งานห้องจ่ายยาผู้ป่วยใน(อาคารใหม่)",
        "งานห้องเจาะเลือด","งานห้องฉีดยาผู้ป่วยนอก","งานห้องตรวจคลื่นหัวใจ(EKG)",
        "งานห้องตรวจพิเศษอายุรกรรม(ห้องส่องกล้อง)","งานห้องเตรียมสารละลาย(TPN)",
        "งานห้องน้ำเกลือ","งานห้องบัตร ชั้น 2","งานห้องบัตร ชั้น 3",
        "งานห้องบัตรเทพรัตน์ ชั้น 2","งานห้องปฏิบัติการ อาคารศูนย์มะเร็ง",
        "งานห้องปฏิบัติการกลางศูนย์รับบริจาคโลหิต","งานห้องผลิตยาทั่วไป",
        "งานห้องผลิตยาทั่วไปและTPNและเคมีบำบัด","งานห้องผ่าตัด(อาคารเทพรัตน์)",
        "งานห้องผ่าตัด(อาคารผ่าตัด)","งานห้องรับเงิน ชั้น 2","งานห้องรับเงิน ชั้น 3",
        "งานห้องรับเงิน เทพรัตน์","งานห้องรับเงินลีลาวดี",
        "งานห้องรับบริจาคโลหิตและส่วนประกอบโลหิต","งานหัวใจและปอดเทียม",
        "งานอณูชีววิทยา","งานอาคารสถานที่","ตรวจสุขภาพแรงงานต่างชาติ",
        "ตึกให้ยาเคมีบำบัด","บ้านแสงจันทร์","ผู้ป่วยนอก อาคารมะเร็งชั้น2",
        "พนักงานราชการเฉพาะกิจ","ยังไม่ระบุสถานที่",
        "รพ.สนามองค์การบริหารส่วนจังหวัดจันทบุรี","ศูนย์จีโนมิกส์และการแพทย์แม่นยำ",
        "ศูนย์เปล กลุ่มงานการพยาบาลผู้ป่วยนอก","ศูนย์ภารกิจด้านเศรษฐกิจการคลัง",
        "ศูนย์วิจัยทางคลินิก","ศูนย์เวชจริยศาสตร์","ศูนย์สาธิต (เวชกรรมฟืนฟู)",
        "ศูนย์อาหารโรงพยาบาลพระปกเกล้า","สหกรณ์ออมทรัพย์",
        "สำนักงานกลุ่มการพยาบาล","สำนักงานกลุ่มงานการเงิน",
        "สำนักงานกลุ่มงานกุมารเวชกรรม","สำนักงานกลุ่มงานจักษุวิทยา",
        "สำนักงานกลุ่มงานจิตเวชและยาเสพติด","สำนักงานกลุ่มงานทรัพยากรบุคคล",
        "สำนักงานกลุ่มงานทันตกรรม","สำนักงานกลุ่มงานเทคนิคการแพทย์",
        "สำนักงานกลุ่มงานบัญชี","สำนักงานกลุ่มงานผู้ป่วยนอก",
        "สำนักงานกลุ่มงานพยาธิวิทยา","สำนักงานกลุ่มงานพัสดุ",
        "สำนักงานกลุ่มงานภารกิจด้านบริการด่านหน้า","สำนักงานกลุ่มงานโภชนศาสตร์",
        "สำนักงานกลุ่มงานยุทธศาสตร์และแผนงานโครงการ",
        "สำนักงานกลุ่มงานรังสีวิทยา ชั้น 1 อาคารมะเร็ง",
        "สำนักงานกลุ่มงานรังสีวิทยา","สำนักงานกลุ่มงานวิสัญญีวิทยา",
        "สำนักงานกลุ่มงานเวชศาสตร์ฉุกเฉิน","สำนักงานกลุ่มงานศัลยกรรม",
        "สำนักงานกลุ่มงานศัลยกรรมออร์โธปิดิกส์","สำนักงานกลุ่มงานสูติ-นรีเวชกรรม",
        "สำนักงานกลุ่มงานโสต ศอ นาสิก","สำนักงานกลุ่มงานอายุรกรรม",
        "สำนักงานกลุ่มพัฒนาทรัพยากรบุคคล","สำนักงานกลุ่มอำนวยการ",
        "สำนักงานการแพทย์แผนไทยและการแพทย์ทางเลือก","สำนักงานกำจัดขยะมูลฝอย",
        "สำนักงานคลังพัสดุ","สำนักงานคลินิกพิเศษนอกเวลาราชการ",
        "สำนักงานควบคุมป้องกันโรคติดเชื้อในโรงพยาบาล","สำนักงานงานทำความสะอาด",
        "สำนักงานงานบำบัดน้ำเสีย","สำนักงานงานผลิตสื่อและสิ่งพิมพ์",
        "สำนักงานงานผู้ป่วยนอกกลุ่มการพยาบาล","สำนักงานงานยานพาหนะ",
        "สำนักงานงานรักษาความปลอดภัย","สำนักงานงานเวชนิทัศน์",
        "สำนักงานงานเวชศาสตร์ครอบครัว","สำนักงานงานสนาม",
        "สำนักงานงานโสต-กลุ่มงานบริหาร","สำนักงานงานโสตทัศนศึกษา",
        "สำนักงานประกันชีวิต","สำนักงานผู้บริหาร","สำนักงานเพาะชำ",
        "สำนักงานมะเร็งชั้น4","สำนักงานเลขานุการ","สำนักงานวิจัยและพัฒนา",
        "สำนักงานเวชศาสตร์นิวเคลียร์","สำนักงานเวชสารสนเทศ",
        "สำนักงานศูนย์รับบริจาคโลหิต","สำนักงานศูนย์รับเรื่องร้องเรียน",
        "สำนักงานศูนย์โรคหัวใจ","สำนักงานหน่วยงานบริการผ้า",
        "สำนักงานหน่วยงานศูนย์เครื่องช่วยหายใจ","สำนักงานหน่วยจ่ายกลาง",
        "สำนักงานห้องสมุด","หน่วยการพยาบาลผู้ป่วยนอกมะเร็ง",
        "หน่วยการพยาบาลรังสีร่วมรักษา","หน่วยการพยาบาลรังสีรักษา",
        "หน่วยการพยาบาลเวชศาสตร์นิวเคลียร์","หน่วยเคมีบำบัด ชั้น 4  (ศูนย์มะเร็ง)",
        "หน่วยจิตอาสา","หน่วยบริการกลุ่มงานเวชกรรมสังคม",
        "หน่วยบริการกลุ่มงานอาชีวเวชกรรม","หน่วยบริการงานห้องเลี้ยงเด็กเล็ก(เดย์แคร์)",
        "หน่วยบริการเวชกรรมสังคม (งานพัฒนาระบบบริการปฐมภูมิและสนับสนุนเครือข่าย)",
        "หน่วยบริการเวชกรรมสังคม (งานส่งเสริม และควบคุมโรค)",
        "หน่วยบริการศูนย์แพทยศาสตรศึกษาชั้นคลินิก",
        "หน่วยบริการหอนิสิตแพทย์,แพทย์ใช้ทุน","หน่วยโภชนศาสตร์คลินิก",
        "หน่วยรังสีร่วมรักษา","หน่วยรังสีรักษา ชั้น 1  (ศูนย์มะเร็ง)",
        "ห้องจ่ายยา ชั้น 2 ตึกประชาธิปกศักดิเดชน์",
        "ห้องจ่ายยา ชั้น 3 ตึกประชาธิปกศักดิเดชน์",
        "ห้องจ่ายยา อาคารสุขภาพ","ห้องจ่ายยา(อาคารเทพรัตน์)",
        "ห้องจ่ายยาผู้ป่วยนอก (อาคารสุขภาพ)","ห้องจ่ายยาผู้ป่วยนอกอาคารมะเร็งชั้น 2",
        "ห้องจ่ายยาผู้ป่วยใน (อาคารใหม่)","ห้องจ่ายยาผู้ป่วยใน(อาคารมะเร็งชั้น ๔)",
        "ห้องตรวจไขกระดูก  (ศูนย์มะเร็ง)","ห้องตรวจคลินิกปรึกษา",
        "ห้องตรวจคลินิกแพทย์แผนไทย","ห้องตรวจคลินิกวัณโรค",
        "ห้องตรวจคลินิกห้องนวดแผนไทย","ห้องตรวจเคมีบำบัด ชั้น 2 (อาคารมะเร็ง)",
        "ห้องตรวจผู้ป่วยนอกคลังเลือด","ห้องตรวจผู้ป่วยนอกคลินิกตรวจสุขภาพ",
        "ห้องตรวจผู้ป่วยนอกคลินิกนอกเวลาราชการ","ห้องตรวจผู้ป่วยนอกคลินิกประกันสังคม",
        "ห้องตรวจผู้ป่วยนอกงานห้องคลอด","ห้องตรวจผู้ป่วยนอกจักษุ",
        "ห้องตรวจผู้ป่วยนอกตรวจพิเศษอายุกรรม(ส่องกล้อง)",
        "ห้องตรวจผู้ป่วยนอกทันตกรรมนอกเวลา",
        "ห้องตรวจผู้ป่วยนอกผ่าตัดเล็ก(อาคารผ่าตัดเก่า)",
        "ห้องตรวจผู้ป่วยนอกแผนกกุมารเวชกรรม"
    ];

    const locInput = document.getElementById('location');
    const locList  = document.getElementById('location-list');

    locInput.addEventListener('input', function() {
        const val = this.value.toLowerCase().trim();
        locList.innerHTML = '';
        if (!val) { locList.classList.add('hidden'); return; }
        const filtered = locations.filter(l => l.toLowerCase().includes(val));
        if (!filtered.length) { locList.classList.add('hidden'); return; }
        filtered.slice(0, 10).forEach(item => {
            const div = document.createElement('div');
            div.className = 'px-4 py-3 hover:bg-blue-50 dark:hover:bg-blue-900/30 cursor-pointer text-sm text-gray-700 dark:text-gray-200 border-b border-gray-100 dark:border-gray-700 last:border-0 transition-colors';
            div.textContent = item;
            div.addEventListener('mousedown', e => {
                e.preventDefault();
                locInput.value = item;
                locList.classList.add('hidden');
                locInput.focus();
            });
            locList.appendChild(div);
        });
        locList.classList.remove('hidden');
    });

    locInput.addEventListener('focus', function() {
        if (this.value.length > 0) this.dispatchEvent(new Event('input'));
    });

    document.addEventListener('click', e => {
        if (!locInput.contains(e.target) && !locList.contains(e.target)) {
            locList.classList.add('hidden');
        }
    });
});

/* AJAX equipment search */
document.addEventListener('DOMContentLoaded', function() {
    let eqTimer = null;
    const eqSearch   = document.getElementById('eq_search');
    const eqId       = document.getElementById('eq_id');
    const eqDropdown = document.getElementById('eq_dropdown');
    const eqCard     = document.getElementById('eq_card');

    eqSearch.addEventListener('input', function() {
        clearTimeout(eqTimer);
        const q = this.value.trim();
        if (q.length < 2) { eqDropdown.classList.add('hidden'); return; }
        eqTimer = setTimeout(() => {
            fetch('/api/equipment-search?q=' + encodeURIComponent(q))
                .then(r => r.json())
                .then(data => {
                    eqDropdown.innerHTML = '';
                    if (!data.length) {
                        eqDropdown.innerHTML = '<div class="px-4 py-3 text-sm text-gray-400 dark:text-gray-500">ไม่พบอุปกรณ์ในระบบ</div>';
                        eqDropdown.classList.remove('hidden');
                        return;
                    }
                    data.forEach(eq => {
                        const div = document.createElement('div');
                        div.className = 'px-4 py-3 hover:bg-blue-50 dark:hover:bg-blue-900/30 cursor-pointer text-sm border-b border-gray-100 dark:border-gray-700 last:border-0 transition-colors';
                        div.innerHTML = '<div class="font-medium text-gray-900 dark:text-gray-100">' + eq.asset_code + ' — ' + eq.name + '</div>' +
                            '<div class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">' + [eq.location, eq.brand].filter(Boolean).join(' • ') + '</div>';
                        div.addEventListener('mousedown', e => { e.preventDefault(); selectEquipment(eq); });
                        eqDropdown.appendChild(div);
                    });
                    eqDropdown.classList.remove('hidden');
                })
                .catch(() => eqDropdown.classList.add('hidden'));
        }, 300);
    });

    window.selectEquipment = function(eq) {
        eqId.value = eq.id;
        eqSearch.value = eq.asset_code + ' — ' + eq.name;
        eqDropdown.classList.add('hidden');
        document.getElementById('eq_card_name').textContent = eq.name;
        document.getElementById('eq_card_details').textContent = [eq.asset_code, eq.brand, eq.model, eq.location].filter(Boolean).join(' • ');
        const wb = document.getElementById('eq_warranty_badge');
        if (eq.under_warranty) {
            wb.className = 'inline-flex items-center gap-1 mt-1 text-xs px-2 py-0.5 rounded-full bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400';
            wb.textContent = '✓ อยู่ในประกัน';
            wb.classList.remove('hidden');
        } else if (eq.warranty_expire) {
            wb.className = 'inline-flex items-center gap-1 mt-1 text-xs px-2 py-0.5 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-400';
            wb.textContent = 'หมดประกัน ' + eq.warranty_expire;
            wb.classList.remove('hidden');
        } else {
            wb.classList.add('hidden');
        }
        eqCard.classList.remove('hidden');
        const locInput = document.getElementById('location');
        if (eq.location && locInput && !locInput.value) locInput.value = eq.location;
    };

    window.clearEquipment = function() {
        eqId.value = '';
        eqSearch.value = '';
        eqCard.classList.add('hidden');
        document.getElementById('eq_warranty_badge').classList.add('hidden');
        eqSearch.focus();
    };

    document.addEventListener('click', e => {
        if (!eqSearch.contains(e.target) && !eqDropdown.contains(e.target)) {
            eqDropdown.classList.add('hidden');
        }
    });
});
</script>
