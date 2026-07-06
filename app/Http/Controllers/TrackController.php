<?php
namespace App\Http\Controllers;

use App\Models\RepairRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrackController extends Controller
{
    public function index()
    {
        $layout = $this->getLayout();
        $myRepairs = null;

        if (Auth::check() && Auth::user()->hasRole('user')) {
            $myRepairs = RepairRequest::with(['equipment', 'technician'])
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }

        return view('public.track', compact('layout', 'myRepairs'));
    }

    public function search(Request $request)
    {
        $request->validate([
            'ticket_no' => 'required|string',
        ], [
            'ticket_no.required' => 'กรุณากรอกเลขที่ใบแจ้งซ่อม',
        ]);

        $ticket = $request->ticket_no;
        if (!str_starts_with($ticket, '#')) {
            $ticket = '#' . ltrim($ticket, '#');
        }

        $repair = RepairRequest::with(['equipment', 'technician'])
                               ->where('ticket_no', $ticket)
                               ->first();

        $layout = $this->getLayout();
        $myRepairs = null;

        if (Auth::check() && Auth::user()->hasRole('user')) {
            $myRepairs = RepairRequest::with(['equipment', 'technician'])
                ->where('user_id', Auth::id())
                ->latest()
                ->get();
        }

        return view('public.track', compact('repair', 'ticket', 'layout', 'myRepairs'));
    }

    private function getLayout(): string
    {
        if (!Auth::check()) return 'standalone';

        $user = Auth::user();
        if ($user->hasRole('admin'))      return 'admin';
        if ($user->hasRole('technician')) return 'technician';
        if ($user->hasRole('user'))       return 'user';

        return 'standalone';
    }
}
