<?php

namespace App\Http\Controllers;

use App\Models\RepairRequest;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function show(Request $request, string $ticket)
    {
        $ticket = str_starts_with($ticket, '#') ? $ticket : '#' . $ticket;
        $repair = RepairRequest::with(['equipment', 'technician'])
                               ->where('ticket_no', $ticket)
                               ->where('status', 'done')
                               ->firstOrFail();
        return view('public.rating', compact('repair'));
    }

    public function store(Request $request, RepairRequest $repair)
    {
        if ($repair->isRated()) {
            return back()->with('error', 'คุณได้ประเมินงานนี้แล้ว');
        }

        if ($repair->status !== 'done') {
            return back()->with('error', 'ยังไม่สามารถประเมินได้ งานยังไม่เสร็จสิ้น');
        }

        $request->validate([
            'rating'         => 'required|integer|min:1|max:5',
            'rating_comment' => 'nullable|string|max:500',
        ], [
            'rating.required' => 'กรุณาเลือกคะแนน',
            'rating.min'      => 'คะแนนต้องอยู่ระหว่าง 1-5',
            'rating.max'      => 'คะแนนต้องอยู่ระหว่าง 1-5',
        ]);

        $repair->update([
            'rating'         => $request->rating,
            'rating_comment' => $request->rating_comment,
            'rated_at'       => now(),
        ]);

        return redirect()->route('rating.thanks', ltrim($repair->ticket_no, '#'));
    }

    public function thanks(string $ticket)
    {
        $ticket = str_starts_with($ticket, '#') ? $ticket : '#' . $ticket;
        $repair = RepairRequest::where('ticket_no', $ticket)->firstOrFail();
        return view('public.rating-thanks', compact('repair'));
    }
}
