<?php

namespace App\Http\Controllers;

use App\Imports\EquipmentImport;
use App\Models\Equipment;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipments = Equipment::with('assignedUser')
                                ->latest()
                                ->paginate(10);
        return view('equipments.index', compact('equipments'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('equipments.create', compact('users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_code'      => 'required|string|unique:equipments,asset_code',
            'name'            => 'required|string|max:255',
            'model'           => 'nullable|string|max:255',
            'category'        => 'required|in:computer,printer,network,other',
            'brand'           => 'nullable|string|max:255',
            'serial_no'       => 'nullable|string|max:255',
            'location'        => 'nullable|string|max:255',
            'assigned_user_id'=> 'nullable|exists:users,id',
            'status'          => 'required|in:active,inactive,maintenance,retired',
            'purchase_date'   => 'nullable|date',
            'purchase_price'  => 'nullable|numeric|min:0',
            'warranty_expire' => 'nullable|date',
            'note'            => 'nullable|string',
        ]);

        Equipment::create($validated);

        return redirect()->route('equipments.index')
                        ->with('success', 'เพิ่มอุปกรณ์สำเร็จแล้ว!');
    }

    public function show(Equipment $equipment)
    {
        $equipment->load(['assignedUser', 'repairRequests.technician']);
        $totalCost = $equipment->totalRepairCost();
        $repairCount = $equipment->repairRequests()->count();
        return view('equipments.show', compact('equipment', 'totalCost', 'repairCount'));
    }

    public function edit(Equipment $equipment)
    {
        $users = User::orderBy('name')->get();
        return view('equipments.edit', compact('equipment', 'users'));
    }

    public function update(Request $request, Equipment $equipment)
    {
        $validated = $request->validate([
            'asset_code'      => 'required|string|unique:equipments,asset_code,' . $equipment->id,
            'name'            => 'required|string|max:255',
            'model'           => 'nullable|string|max:255',
            'category'        => 'required|in:computer,printer,network,other',
            'brand'           => 'nullable|string|max:255',
            'serial_no'       => 'nullable|string|max:255',
            'location'        => 'nullable|string|max:255',
            'assigned_user_id'=> 'nullable|exists:users,id',
            'status'          => 'required|in:active,inactive,maintenance,retired',
            'purchase_date'   => 'nullable|date',
            'purchase_price'  => 'nullable|numeric|min:0',
            'warranty_expire' => 'nullable|date',
            'note'            => 'nullable|string',
        ]);

        $equipment->update($validated);

        return redirect()->route('equipments.index')
                        ->with('success', 'แก้ไขข้อมูลสำเร็จแล้ว!');
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return redirect()->route('equipments.index')
                        ->with('success', 'ลบอุปกรณ์แล้ว!');
    }

    public function importForm()
    {
        return view('equipments.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls,csv|max:10240',
        ]);

        $import = new EquipmentImport();
        Excel::import($import, $request->file('file'));

        $count = $import->getImported();
        $errors = count($import->failures());

        if ($count === 0) {
            return back()->with('warning', 'ไม่พบข้อมูลที่นำเข้าได้ กรุณาตรวจสอบรูปแบบไฟล์');
        }

        $msg = "นำเข้าสำเร็จ {$count} รายการ";
        if ($errors > 0) $msg .= " (ข้ามแถวที่มีข้อผิดพลาด {$errors} แถว)";

        return redirect()->route('equipments.index')->with('success', $msg);
    }

    public function apiSearch(Request $request)
    {
        $q = trim($request->get('q', ''));
        if (mb_strlen($q) < 2) return response()->json([]);

        $equipments = Equipment::where('status', 'active')
            ->where(function ($query) use ($q) {
                $query->where('asset_code', 'like', "%{$q}%")
                      ->orWhere('name', 'like', "%{$q}%")
                      ->orWhere('brand', 'like', "%{$q}%")
                      ->orWhere('location', 'like', "%{$q}%");
            })
            ->limit(10)
            ->get(['id', 'asset_code', 'name', 'brand', 'model', 'location', 'warranty_expire']);

        return response()->json($equipments->map(fn($e) => [
            'id'             => $e->id,
            'asset_code'     => $e->asset_code,
            'name'           => $e->name,
            'brand'          => $e->brand,
            'model'          => $e->model,
            'location'       => $e->location,
            'warranty_expire' => $e->warranty_expire?->format('d/m/Y'),
            'under_warranty' => $e->isUnderWarranty(),
        ]));
    }
}