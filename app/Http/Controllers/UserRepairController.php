<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\RepairRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserRepairController extends Controller
{
    public function index()
    {
        $repairs = RepairRequest::with(['equipment', 'technician'])
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        $stats = [
            'new'         => RepairRequest::where('user_id', Auth::id())
                                          ->whereIn('status', ['new', 'assigned'])->count(),
            'in_progress' => RepairRequest::where('user_id', Auth::id())
                                          ->where('status', 'in_progress')->count(),
            'done'        => RepairRequest::where('user_id', Auth::id())
                                          ->where('status', 'done')->count(),
        ];

        return view('user.dashboard', compact('repairs', 'stats'));
    }

    public function create()
    {
        $equipments = Equipment::where('status', 'active')
                               ->orderBy('location')
                               ->orderBy('name')
                               ->get();
        return view('user.repair-create', compact('equipments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'equipment_id' => 'nullable|exists:equipments,id',
            'department'   => 'required|string|max:255',
            'priority'     => 'required|in:low,medium,high,urgent',
            'description'  => 'required|string|min:10|max:1000',
            'image'        => 'nullable|image|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('repairs', 'public');
        }

        $equipmentId = $request->equipment_id;
        if (!$equipmentId) {
            $general = Equipment::firstOrCreate(
                ['asset_code' => 'GENERAL-001'],
                [
                    'name'     => 'อุปกรณ์ทั่วไป',
                    'category' => 'other',
                    'status'   => 'active',
                    'location' => '-',
                ]
            );
            $equipmentId = $general->id;
        }

        $repair = RepairRequest::create([
            'user_id'      => Auth::id(),
            'ticket_no'    => RepairRequest::generateTicketNo(),
            'status'       => 'new',
            'equipment_id' => $equipmentId,
            'department'   => $request->department,
            'priority'     => $request->priority,
            'description'  => $request->description,
            'image_path'   => $imagePath,
        ]);

        return redirect()->route('user.repair.show', $repair)
                         ->with('success', 'แจ้งซ่อมสำเร็จ! เลขที่ใบ: ' . $repair->ticket_no);
    }

    public function show(RepairRequest $repair)
    {
        if ($repair->user_id !== Auth::id()) {
            abort(403);
        }
        $repair->load(['equipment', 'technician']);
        return view('user.repair-show', compact('repair'));
    }
}
