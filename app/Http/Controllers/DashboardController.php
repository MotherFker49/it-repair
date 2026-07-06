<?php

namespace App\Http\Controllers;

use App\Models\RepairRequest;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'new'         => RepairRequest::where('status', 'new')->count(),
            'assigned'    => RepairRequest::where('status', 'assigned')->count(),
            'in_progress' => RepairRequest::where('status', 'in_progress')->count(),
            'done'        => RepairRequest::where('status', 'done')->count(),
            'total'       => RepairRequest::count(),
        ];

        $recent = RepairRequest::with(['user', 'equipment', 'technician'])
                                ->latest()
                                ->take(10)
                                ->get();

        return view('dashboard', compact('stats', 'recent'));
    }
}