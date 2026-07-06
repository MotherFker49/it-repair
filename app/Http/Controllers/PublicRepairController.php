<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\RepairRequest;
use App\Services\LineNotifyService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicRepairController extends Controller
{
    // หน้าฟอร์มแจ้งซ่อม
    public function create()
    {
        $user = Auth::user();
        $layout = 'standalone';
        if ($user) {
            if ($user->hasRole('admin')) $layout = 'admin';
            elseif ($user->hasRole('technician')) $layout = 'technician';
            else $layout = 'user';
        }
        return view('public.repair', compact('layout'));
    }

    // บันทึกและแจ้งเตือน
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reporter_name' => 'required|string|max:100',
            'reporter_phone'=> 'nullable|string|max:20',
            'location'      => 'required|string|max:255',
            'equipment_id'  => 'nullable|exists:equipments,id',
            'equipment_name'=> 'nullable|string|max:255',
            'priority'      => 'required|in:low,medium,high,urgent',
            'description'   => 'required|string|min:10|max:1000',
            'image'         => 'nullable|image|max:2048',
        ], [
            'reporter_name.required' => 'กรุณากรอกชื่อผู้แจ้ง',
            'location.required'      => 'กรุณาระบุสถานที่',
            'description.required'   => 'กรุณาอธิบายปัญหา',
            'description.min'        => 'กรุณาอธิบายปัญหาอย่างน้อย 10 ตัวอักษร',
        ]);

        // หาหรือสร้าง system user สำหรับแจ้งซ่อมสาธารณะ
        $systemUser = \App\Models\User::where('email', 'system@repair.local')->first();
        if (!$systemUser) {
            $systemUser = \App\Models\User::create([
                'name'     => 'ระบบแจ้งซ่อม',
                'email'    => 'system@repair.local',
                'password' => bcrypt('system_password_never_login'),
            ]);
        }

        // ถ้าไม่ได้เลือกอุปกรณ์ในระบบ ให้ใช้อุปกรณ์ทั่วไป
        $equipmentId = $request->equipment_id;
        if (!$equipmentId) {
            $general = Equipment::where('asset_code', 'GENERAL-001')->first();
            if (!$general) {
                $general = Equipment::create([
                    'asset_code' => 'GENERAL-001',
                    'name'       => 'อุปกรณ์ทั่วไป (ไม่ระบุ)',
                    'category'   => 'other',
                    'status'     => 'active',
                    'location'   => '-',
                ]);
            }
            $equipmentId = $general->id;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('repairs', 'public');
        }

        $repair = RepairRequest::create([
            'ticket_no'      => RepairRequest::generateTicketNo(),
            'reporter_name'  => $request->reporter_name,
            'reporter_phone' => $request->reporter_phone,
            'department'     => $request->location,
            'user_id'        => $systemUser->id,
            'equipment_id'   => $equipmentId,
            'priority'       => $request->priority,
            'description'    => $request->description,
            'image_path'     => $imagePath,
            'status'         => 'new',
        ]);

        // แจ้งเตือน Line
        $priority = match($request->priority) {
            'urgent' => '🔴 เร่งด่วนที่สุด',
            'high'   => '🟠 ด่วนมาก',
            'medium' => '🟡 ด่วน',
            default  => '🟢 ปกติ',
        };

        $equipName = $request->equipment_id
            ? Equipment::find($request->equipment_id)?->name
            : ($request->equipment_name ?? 'ไม่ระบุ');

        $message = "\n🔔 มีงานซ่อมใหม่!"
            . "\n━━━━━━━━━━━━━━"
            . "\nเลขที่: " . $repair->ticket_no
            . "\nผู้แจ้ง: " . $request->reporter_name
            . ($request->reporter_phone ? "\nโทร: " . $request->reporter_phone : '')
            . "\nหน่วยงาน: " . $request->location
            . "\nอุปกรณ์: " . $equipName
            . "\nความเร่งด่วน: " . $priority
            . "\n━━━━━━━━━━━━━━"
            . "\nปัญหา: " . $request->description;

        app(LineNotifyService::class)->send($message);

        return redirect()->route('public.repair.success', ['ticket' => $repair->ticket_no]);
    }

    // หน้าแจ้งซ่อมสำเร็จ
    public function success(Request $request)
    {
        $ticket = $request->query('ticket');
        $user = Auth::user();
        $layout = 'standalone';
        if ($user) {
            if ($user->hasRole('admin')) $layout = 'admin';
            elseif ($user->hasRole('technician')) $layout = 'technician';
            else $layout = 'user';
        }
        return view('public.success', compact('ticket', 'layout'));
    }
}