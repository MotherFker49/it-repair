<x-user-layout>
    <x-slot name="header">แจ้งซ่อมอุปกรณ์ IT</x-slot>

    <div class="max-w-2xl mx-auto">

        @if ($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-4 rounded-2xl mb-5 flex gap-3">
            <svg class="w-5 h-5 text-red-500 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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

        <form action="{{ route('user.repair.store') }}" method="POST" enctype="multipart/form-data" id="repair-form">
            @csrf

            {{-- ส่วนที่ 1: ผู้แจ้ง (auto จาก login) --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-5">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-8 h-8 bg-blue-700 rounded-xl flex items-center justify-center shrink-0">
                        <span class="text-white font-bold text-sm">1</span>
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900">ข้อมูลผู้แจ้ง</h2>
                        <p class="text-xs text-gray-400">ข้อมูลจากบัญชีที่เข้าสู่ระบบ</p>
                    </div>
                </div>
                <div class="flex items-center gap-3 bg-blue-50 border border-blue-100 rounded-xl px-4 py-3">
                    <div class="w-9 h-9 bg-blue-600 rounded-full flex items-center justify-center text-white font-bold text-sm shrink-0">
                        {{ mb_substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <div>
                        <p class="font-semibold text-gray-900 text-sm">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-500">{{ Auth::user()->email }}</p>
                    </div>
                </div>
            </div>

            {{-- ส่วนที่ 2: สถานที่และอุปกรณ์ --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-5">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-blue-700 rounded-xl flex items-center justify-center shrink-0">
                        <span class="text-white font-bold text-sm">2</span>
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900">สถานที่และอุปกรณ์</h2>
                        <p class="text-xs text-gray-400">ระบุหน่วยงานและอุปกรณ์ที่ต้องการซ่อม</p>
                    </div>
                </div>

                <div class="space-y-4">
                    {{-- Location autocomplete --}}
                    <div class="relative">
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            หน่วยงาน / สถานที่ <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </div>
                            <input type="text" name="department" id="location" value="{{ old('department') }}"
                                   class="w-full border {{ $errors->has('department') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl pl-11 pr-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white text-gray-900 placeholder-gray-400"
                                   placeholder="พิมพ์เพื่อค้นหาหน่วยงาน..." autocomplete="off">
                        </div>
                        <div id="location-list"
                             class="hidden absolute z-20 bg-white border border-gray-200 rounded-xl shadow-lg max-h-52 overflow-y-auto w-full mt-1.5">
                        </div>
                    </div>

                    {{-- AJAX Equipment Search --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            อุปกรณ์ที่ต้องการซ่อม
                            <span class="text-gray-400 font-normal text-xs ml-1">(ค้นหาจากระบบ)</span>
                        </label>
                        <input type="hidden" name="equipment_id" id="eq_id">
                        <div class="relative">
                            <input type="text" id="eq_search"
                                   placeholder="พิมพ์รหัส รพจ หรือชื่ออุปกรณ์..."
                                   autocomplete="off"
                                   class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors bg-white text-gray-900 placeholder-gray-400">
                            <div id="eq_dropdown"
                                 class="hidden absolute z-20 bg-white border border-gray-200 rounded-xl shadow-lg max-h-52 overflow-y-auto w-full mt-1.5"></div>
                        </div>
                        <div id="eq_card" class="hidden mt-2 bg-blue-50 border border-blue-200 rounded-xl p-3">
                            <div class="flex items-start justify-between">
                                <div class="flex-1 min-w-0">
                                    <div class="font-semibold text-sm text-gray-900" id="eq_card_name"></div>
                                    <div class="text-xs text-gray-500 mt-0.5" id="eq_card_details"></div>
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
                </div>
            </div>

            {{-- ส่วนที่ 3: รายละเอียดปัญหา --}}
            <div class="bg-white rounded-2xl border border-gray-200 shadow-sm p-6 mb-5">
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 bg-blue-700 rounded-xl flex items-center justify-center shrink-0">
                        <span class="text-white font-bold text-sm">3</span>
                    </div>
                    <div>
                        <h2 class="font-semibold text-gray-900">รายละเอียดปัญหา</h2>
                        <p class="text-xs text-gray-400">อธิบายอาการและความเร่งด่วน</p>
                    </div>
                </div>

                <div class="space-y-5">
                    {{-- Priority --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-3">
                            ความเร่งด่วน <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            @foreach([
                                ['value' => 'low',    'emoji' => '🟢', 'label' => 'ปกติ',        'desc' => 'ไม่เร่งด่วน'],
                                ['value' => 'medium', 'emoji' => '🟡', 'label' => 'ด่วน',         'desc' => 'ควรซ่อมวันนี้'],
                                ['value' => 'high',   'emoji' => '🟠', 'label' => 'ด่วนมาก',      'desc' => 'กระทบการทำงาน'],
                                ['value' => 'urgent', 'emoji' => '🔴', 'label' => 'เร่งด่วนที่สุด','desc' => 'หยุดให้บริการ'],
                            ] as $p)
                            <label class="priority-label cursor-pointer">
                                <input type="radio" name="priority" value="{{ $p['value'] }}" class="sr-only"
                                       {{ old('priority', 'medium') == $p['value'] ? 'checked' : '' }}>
                                <div class="priority-card border-2 border-gray-200 rounded-xl p-3.5 text-center transition-all hover:border-gray-300">
                                    <div class="text-2xl mb-1.5">{{ $p['emoji'] }}</div>
                                    <div class="text-sm font-semibold text-gray-800">{{ $p['label'] }}</div>
                                    <div class="text-xs text-gray-400 mt-0.5">{{ $p['desc'] }}</div>
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            อธิบายปัญหา <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" rows="4"
                                  class="w-full border {{ $errors->has('description') ? 'border-red-400 bg-red-50' : 'border-gray-300' }} rounded-xl px-4 py-3 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none bg-white text-gray-900 placeholder-gray-400"
                                  placeholder="เช่น เปิดไม่ติด, จอดำ, พิมพ์ไม่ออก, เน็ตหลุดบ่อย, ช้ามาก...">{{ old('description') }}</textarea>
                    </div>

                    {{-- Image Upload --}}
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            รูปภาพประกอบ
                            <span class="text-gray-400 font-normal text-xs ml-1">(ไม่บังคับ, JPG/PNG ไม่เกิน 2MB)</span>
                        </label>
                        <label for="image-input"
                               class="block border-2 border-dashed border-gray-300 rounded-xl p-6 text-center cursor-pointer hover:border-blue-400 hover:bg-blue-50 transition-all group">
                            <input type="file" name="image" id="image-input" accept="image/*" class="sr-only">
                            <div id="upload-placeholder">
                                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3 group-hover:bg-blue-100 transition-colors">
                                    <svg class="w-6 h-6 text-gray-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                </div>
                                <p class="text-sm text-gray-600 font-medium group-hover:text-blue-700">แตะเพื่อถ่ายรูปหรือเลือกไฟล์</p>
                                <p class="text-xs text-gray-400 mt-1">รองรับ JPG, PNG</p>
                            </div>
                            <div id="image-preview" class="hidden">
                                <img id="preview-img" class="max-h-40 mx-auto rounded-xl object-cover mb-2" src="" alt="">
                                <p id="file-name" class="text-xs text-gray-500"></p>
                                <p class="text-xs text-blue-600 mt-1">แตะเพื่อเปลี่ยนรูป</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <button type="submit" id="submit-btn"
                    class="w-full bg-blue-700 hover:bg-blue-800 text-white py-4 rounded-2xl text-base font-bold transition-colors shadow-md flex items-center justify-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                </svg>
                ส่งใบแจ้งซ่อม
            </button>

            <a href="{{ route('user.dashboard') }}"
               class="flex items-center justify-center gap-2 w-full mt-3 py-3 text-sm text-gray-500 hover:text-gray-700 transition-colors">
                ← กลับหน้าหลัก
            </a>
        </form>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    /* Location autocomplete — full list */
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
            div.className = 'px-4 py-2.5 text-sm text-gray-700 cursor-pointer hover:bg-blue-50 border-b border-gray-100 last:border-0';
            div.textContent = item;
            div.addEventListener('mousedown', e => {
                e.preventDefault();
                locInput.value = item;
                locList.classList.add('hidden');
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

}); /* end DOMContentLoaded */

/* Priority cards */
function updatePriorityCards() {
    document.querySelectorAll('.priority-label').forEach(label => {
        const radio = label.querySelector('input[type=radio]');
        const card  = label.querySelector('.priority-card');
        if (radio.checked) {
            card.classList.add('border-blue-600', 'bg-blue-50', 'shadow-sm');
            card.classList.remove('border-gray-200');
        } else {
            card.classList.remove('border-blue-600', 'bg-blue-50', 'shadow-sm');
            card.classList.add('border-gray-200');
        }
    });
}
document.querySelectorAll('.priority-label input').forEach(r => r.addEventListener('change', updatePriorityCards));
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

/* Submit loading */
document.getElementById('repair-form').addEventListener('submit', function() {
    const btn = document.getElementById('submit-btn');
    btn.disabled = true;
    btn.innerHTML = '<svg class="w-5 h-5 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg> กำลังส่ง...';
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
                        eqDropdown.innerHTML = '<div class="px-4 py-3 text-sm text-gray-400">ไม่พบอุปกรณ์ในระบบ</div>';
                        eqDropdown.classList.remove('hidden');
                        return;
                    }
                    data.forEach(eq => {
                        const div = document.createElement('div');
                        div.className = 'px-4 py-3 hover:bg-blue-50 cursor-pointer text-sm border-b border-gray-100 last:border-0 transition-colors';
                        div.innerHTML = '<div class="font-medium text-gray-900">' + eq.asset_code + ' — ' + eq.name + '</div>' +
                            '<div class="text-xs text-gray-400 mt-0.5">' + [eq.location, eq.brand].filter(Boolean).join(' • ') + '</div>';
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
            wb.className = 'inline-flex items-center gap-1 mt-1 text-xs px-2 py-0.5 rounded-full bg-green-100 text-green-700';
            wb.textContent = '✓ อยู่ในประกัน';
            wb.classList.remove('hidden');
        } else if (eq.warranty_expire) {
            wb.className = 'inline-flex items-center gap-1 mt-1 text-xs px-2 py-0.5 rounded-full bg-gray-100 text-gray-500';
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
</x-user-layout>
