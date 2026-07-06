<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\RepairRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RepairRequestController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->hasRole('admin') || $user->hasRole('technician')) {
            $repairs = RepairRequest::with(['user', 'equipment', 'technician'])
                                     ->latest()->paginate(10);
        } else {
            $repairs = RepairRequest::with(['equipment', 'technician'])
                                     ->where('user_id', $user->id)
                                     ->latest()->paginate(10);
        }

        return view('repairs.index', compact('repairs'));
    }

    public function create()
    {
        $equipments = Equipment::where('status', 'active')->orderBy('name')->get();
        return view('repairs.create', compact('equipments'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'equipment_id' => 'required|exists:equipments,id',
            'priority'     => 'required|in:low,medium,high,urgent',
            'description'  => 'required|string|min:10|max:1000',
            'image'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('repairs', 'public');
        }

        RepairRequest::create([
            ...$validated,
            'user_id'   => Auth::id(),
            'ticket_no' => RepairRequest::generateTicketNo(),
        ]);

        return redirect()->route('repairs.index')
                        ->with('success', 'แจ้งซ่อมสำเร็จแล้ว! รอเจ้าหน้าที่ดำเนินการ');
    }

    public function show(RepairRequest $repair)
    {
        $repair->load(['user', 'equipment', 'technician']);
        $technicians = User::role('technician')->get();
        return view('repairs.show', compact('repair', 'technicians'));
    }

    public function edit(RepairRequest $repair)
    {
        $technicians = User::role('technician')->get();
        return view('repairs.edit', compact('repair', 'technicians'));
    }

    public function update(Request $request, RepairRequest $repair)
    {
        return redirect()->route('repairs.show', $repair);
    }

    public function destroy(RepairRequest $repair)
    {
        $repair->delete();
        return redirect()->route('repairs.index')
                        ->with('success', 'ลบใบแจ้งซ่อมแล้ว');
    }

    public function updateStatus(Request $request, RepairRequest $repair)
    {
        $request->validate([
            'status'        => 'required|in:new,assigned,in_progress,done,cancelled',
            'technician_id' => 'nullable|exists:users,id',
            'solution'      => 'nullable|string',
        ]);

        $repair->update([
            'status'        => $request->status,
            'technician_id' => $request->technician_id,
            'solution'      => $request->solution,
            'resolved_at'   => $request->status === 'done' ? now() : null,
        ]);

        // อัปเดตสถานะอุปกรณ์ตามสถานะการซ่อม
        if ($request->status === 'in_progress') {
            $repair->equipment->update(['status' => 'maintenance']);
        } elseif ($request->status === 'done') {
            $repair->equipment->update(['status' => 'active']);
        }

        return back()->with('success', 'อัปเดตสถานะสำเร็จแล้ว!');
    }
}