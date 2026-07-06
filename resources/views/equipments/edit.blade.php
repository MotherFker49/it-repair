<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-100 leading-tight">
            แก้ไขข้อมูลอุปกรณ์ — {{ $equipment->asset_code }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 transition-colors duration-200">

                <form action="{{ route('equipments.update', $equipment) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">รหัสทรัพย์สิน *</label>
                            <input type="text" name="asset_code" value="{{ old('asset_code', $equipment->asset_code) }}"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm">
                            @error('asset_code')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">ชื่ออุปกรณ์ *</label>
                            <input type="text" name="name" value="{{ old('name', $equipment->name) }}"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <!-- ยี่ห้อ -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">ยี่ห้อ</label>
                            <select id="brand" name="brand"
                                    class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm">
                                <option value="">-- เลือกยี่ห้อ --</option>
                                <optgroup label="🖥️ คอมพิวเตอร์/โน้ตบุ๊ก">
                                    <option @selected(old('brand', $equipment->brand) == 'Dell')>Dell</option>
                                    <option @selected(old('brand', $equipment->brand) == 'HP')>HP</option>
                                    <option @selected(old('brand', $equipment->brand) == 'Lenovo')>Lenovo</option>
                                    <option @selected(old('brand', $equipment->brand) == 'Acer')>Acer</option>
                                    <option @selected(old('brand', $equipment->brand) == 'Asus')>Asus</option>
                                </optgroup>
                                <optgroup label="🖨️ เครื่องพิมพ์/ถ่ายเอกสาร">
                                    <option @selected(old('brand', $equipment->brand) == 'Canon')>Canon</option>
                                    <option @selected(old('brand', $equipment->brand) == 'Epson')>Epson</option>
                                    <option @selected(old('brand', $equipment->brand) == 'Fuji Xerox')>Fuji Xerox</option>
                                    <option @selected(old('brand', $equipment->brand) == 'Brother')>Brother</option>
                                    <option @selected(old('brand', $equipment->brand) == 'Konica Minolta')>Konica Minolta</option>
                                    <option @selected(old('brand', $equipment->brand) == 'Ricoh')>Ricoh</option>
                                    <option @selected(old('brand', $equipment->brand) == 'Sharp')>Sharp</option>
                                    <option @selected(old('brand', $equipment->brand) == 'Samsung')>Samsung</option>
                                    <option @selected(old('brand', $equipment->brand) == 'Star')>Star</option>
                                    <option @selected(old('brand', $equipment->brand) == 'Bixolon')>Bixolon</option>
                                    <option @selected(old('brand', $equipment->brand) == 'Citizen')>Citizen</option>
                                </optgroup>
                                <optgroup label="🌐 อุปกรณ์เครือข่าย">
                                    <option @selected(old('brand', $equipment->brand) == 'Cisco')>Cisco</option>
                                    <option @selected(old('brand', $equipment->brand) == 'D-Link')>D-Link</option>
                                    <option @selected(old('brand', $equipment->brand) == 'Ubiquiti')>Ubiquiti</option>
                                    <option @selected(old('brand', $equipment->brand) == 'Tp-Link')>Tp-Link</option>
                                </optgroup>
                                <optgroup label="🖥️ จอมอนิเตอร์">
                                    <option @selected(old('brand', $equipment->brand) == 'LG')>LG</option>
                                    <option @selected(old('brand', $equipment->brand) == 'Philips')>Philips</option>
                                </optgroup>
                                <optgroup label="🔌 UPS">
                                    <option @selected(old('brand', $equipment->brand) == 'APC')>APC</option>
                                    <option @selected(old('brand', $equipment->brand) == 'Eaton')>Eaton</option>
                                    <option @selected(old('brand', $equipment->brand) == 'CyberPower')>CyberPower</option>
                                </optgroup>
                                <optgroup label="❓ อื่นๆ">
                                    <option @selected(old('brand', $equipment->brand) == 'อื่นๆ (ระบุเอง)')>อื่นๆ (ระบุเอง)</option>
                                </optgroup>
                            </select>
                        </div>

                        <!-- รุ่น (มี autocomplete) -->
                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">รุ่น</label>
                            <input type="text" id="model" name="model" value="{{ old('model', $equipment->model) }}"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-500 rounded-lg shadow-sm"
                                   placeholder="เลือกยี่ห้อก่อน หรือพิมพ์รุ่นเอง"
                                   autocomplete="off">
                            <div id="model-list"
                                 class="hidden absolute z-10 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg max-h-48 overflow-y-auto w-full mt-1">
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">ประเภท *</label>
                            <select name="category" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm">
                                <option value="computer" {{ $equipment->category=='computer'?'selected':'' }}>คอมพิวเตอร์</option>
                                <option value="printer" {{ $equipment->category=='printer'?'selected':'' }}>เครื่องพิมพ์</option>
                                <option value="network" {{ $equipment->category=='network'?'selected':'' }}>อุปกรณ์เครือข่าย</option>
                                <option value="other" {{ $equipment->category=='other'?'selected':'' }}>อื่นๆ</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">สถานะ *</label>
                            <select name="status" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm">
                                <option value="active" {{ $equipment->status=='active'?'selected':'' }}>ใช้งานปกติ</option>
                                <option value="inactive" {{ $equipment->status=='inactive'?'selected':'' }}>ไม่ได้ใช้งาน</option>
                                <option value="maintenance" {{ $equipment->status=='maintenance'?'selected':'' }}>อยู่ระหว่างซ่อม</option>
                                <option value="retired" {{ $equipment->status=='retired'?'selected':'' }}>เลิกใช้งานแล้ว</option>
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">หมายเลขซีเรียล</label>
                            <input type="text" name="serial_no" value="{{ old('serial_no', $equipment->serial_no) }}"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm">
                        </div>

                        <div class="relative">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">สถานที่</label>
                            <input type="text" name="location" id="location" value="{{ old('location', $equipment->location) }}"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 dark:placeholder-gray-500 rounded-lg shadow-sm"
                                   placeholder="พิมพ์เพื่อค้นหาหน่วยงาน..."
                                   autocomplete="off">
                            <div id="location-list" class="hidden absolute z-10 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 rounded-lg shadow-lg max-h-48 overflow-y-auto w-full mt-1"></div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">ผู้ใช้งาน</label>
                            <select name="assigned_user_id" class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm">
                                <option value="">-- ไม่ระบุ --</option>
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}" {{ $equipment->assigned_user_id==$user->id?'selected':'' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">วันที่ซื้อ</label>
                            <input type="date" name="purchase_date" value="{{ old('purchase_date', $equipment->purchase_date?->format('Y-m-d')) }}"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">ราคาซื้อ (บาท)</label>
                            <input type="number" name="purchase_price" value="{{ old('purchase_price', $equipment->purchase_price) }}"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm" step="0.01">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">วันหมดประกัน</label>
                            <input type="date" name="warranty_expire" value="{{ old('warranty_expire', $equipment->warranty_expire?->format('Y-m-d')) }}"
                                   class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm">
                        </div>

                    </div>

                    <div class="mt-4">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">หมายเหตุ</label>
                        <textarea name="note" rows="3"
                                  class="w-full border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-gray-100 rounded-lg shadow-sm">{{ old('note', $equipment->note) }}</textarea>
                    </div>

                    <div class="flex gap-3 mt-6">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors">
                            บันทึกการแก้ไข
                        </button>
                        <a href="{{ route('equipments.show', $equipment) }}" class="bg-gray-200 dark:bg-gray-700 hover:bg-gray-300 dark:hover:bg-gray-600 text-gray-700 dark:text-gray-300 px-6 py-2 rounded-lg transition-colors">
                            ยกเลิก
                        </a>
                    </div>

                </form>
            </div>
        </div>
    </div>

<script>
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
        div.className = 'px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 cursor-pointer text-sm text-gray-800 dark:text-gray-200 border-b border-gray-100 dark:border-gray-700 last:border-0 transition-colors';
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
    const val = this.value.toLowerCase();
    locList.innerHTML = '';
    if (!val) { locList.classList.add('hidden'); return; }
    const filtered = locations.filter(l => l.toLowerCase().includes(val));
    if (!filtered.length) { locList.classList.add('hidden'); return; }
    filtered.forEach(item => {
        const div = document.createElement('div');
        div.className = 'px-4 py-2 hover:bg-blue-50 dark:hover:bg-blue-900/30 cursor-pointer text-sm text-gray-800 dark:text-gray-200 border-b border-gray-100 dark:border-gray-700 last:border-0 transition-colors';
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

document.addEventListener('click', e => {
    if (!locInput.contains(e.target) && !locList.contains(e.target)) locList.classList.add('hidden');
});
}); /* end DOMContentLoaded */
</script>
</x-app-layout>
