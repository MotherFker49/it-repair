<?php

namespace App\Http\Controllers;

use App\Models\RepairRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TechnicianController extends Controller
{
    // หน้า Dashboard ช่าง
    public function index(Request $request)
    {
        $status = $request->query('status', 'all');
        $query  = RepairRequest::with(['user', 'equipment', 'technician'])->latest();

        if (Auth::user()->hasRole('technician')) {
            $query->where(function($q) {
                $q->where('technician_id', Auth::id())
                  ->orWhere(function($q2) {
                      $q2->whereNull('technician_id')
                         ->where('status', 'new');
                  });
            });
        }

        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $repairs = $query->paginate(15);

        $counts = [
            'all'         => RepairRequest::count(),
            'new'         => RepairRequest::where('status', 'new')->count(),
            'assigned'    => RepairRequest::where('status', 'assigned')->count(),
            'in_progress' => RepairRequest::where('status', 'in_progress')->count(),
            'done'        => RepairRequest::where('status', 'done')->count(),
        ];

        $technicians = User::role('technician')->get();

        return view('technician.index', compact('repairs', 'counts', 'status', 'technicians'));
    }

    // หน้าดูรายละเอียดงานซ่อม
    public function show(RepairRequest $repair)
    {
        $repair->load(['user', 'equipment', 'technician']);
        $technicians = User::role('technician')->get();
        return view('technician.show', compact('repair', 'technicians'));
    }

    // ค้นหางานซ่อม
    public function search(Request $request)
    {
        $q         = $request->query('q', '');
        $status    = $request->query('status', '');
        $techId    = $request->query('technician_id', '');
        $dateFrom  = $request->query('date_from', '');
        $dateTo    = $request->query('date_to', '');

        $query = RepairRequest::with(['user', 'equipment', 'technician'])->latest();

        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('ticket_no', 'like', "%{$q}%")
                    ->orWhere('reporter_name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%")
                    ->orWhere('solution', 'like', "%{$q}%")
                    ->orWhere('department', 'like', "%{$q}%")
                    ->orWhereHas('equipment', fn($eq) => $eq->where('name', 'like', "%{$q}%")
                        ->orWhere('asset_code', 'like', "%{$q}%"));
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        if ($techId) {
            $query->where('technician_id', $techId);
        }

        if ($dateFrom) {
            $query->whereDate('created_at', '>=', $dateFrom);
        }

        if ($dateTo) {
            $query->whereDate('created_at', '<=', $dateTo);
        }

        $repairs     = $query->paginate(20)->withQueryString();
        $technicians = User::role('technician')->get();

        return view('technician.search', compact('repairs', 'technicians', 'q', 'status', 'techId', 'dateFrom', 'dateTo'));
    }

    // รับงาน
    public function accept(RepairRequest $repair)
    {
        $repair->update([
            'technician_id' => Auth::id(),
            'status'        => 'assigned',
        ]);

        return back()->with('success', 'รับงาน ' . $repair->ticket_no . ' แล้ว!');
    }

    // อัปเดตสถานะ
    public function updateStatus(Request $request, RepairRequest $repair)
    {
        $request->validate([
            'status'          => 'required|in:new,assigned,in_progress,done,cancelled',
            'solution'        => 'nullable|string',
            'root_cause'      => 'nullable|string',
            'repair_type'     => 'nullable|in:on_site,bring_in,remote',
            'parts_used'      => 'nullable|string',
            'start_repair_at' => 'nullable|date',
            'finish_repair_at'=> 'nullable|date|after_or_equal:start_repair_at',
        ]);

        $data = [
            'status'          => $request->status,
            'solution'        => $request->solution,
            'root_cause'      => $request->root_cause,
            'repair_type'     => $request->repair_type,
            'parts_used'      => $request->parts_used,
            'start_repair_at' => $request->start_repair_at ?: null,
            'finish_repair_at'=> $request->finish_repair_at ?: null,
            'resolved_at'     => $request->status === 'done' ? now() : null,
        ];

        $repair->update($data);

        if ($request->status === 'in_progress') {
            $repair->equipment->update(['status' => 'maintenance']);
        } elseif ($request->status === 'done') {
            $repair->equipment->update(['status' => 'active']);
        }

        return back()->with('success', 'อัปเดตสถานะสำเร็จ!');
    }
}
