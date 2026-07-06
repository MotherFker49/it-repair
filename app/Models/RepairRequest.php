<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RepairRequest extends Model
{
    protected $fillable = [
        'ticket_no', 'reporter_name', 'reporter_phone', 'department',
        'user_id', 'equipment_id', 'technician_id',
        'status', 'priority', 'description', 'solution',
        'root_cause', 'repair_type', 'parts_used',
        'start_repair_at', 'finish_repair_at',
        'image_path', 'repair_cost', 'resolved_at',
        'rating', 'rating_comment', 'rated_at',
    ];

    protected $casts = [
        'resolved_at'     => 'datetime',
        'repair_cost'     => 'decimal:2',
        'rated_at'        => 'datetime',
        'start_repair_at' => 'datetime',
        'finish_repair_at'=> 'datetime',
    ];

    // ผู้แจ้งซ่อม
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // ช่างที่รับงาน
    public function technician(): BelongsTo
    {
        return $this->belongsTo(User::class, 'technician_id');
    }

    // อุปกรณ์ที่แจ้งซ่อม
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    // สร้างเลขที่ใบแจ้งซ่อมอัตโนมัติ
    public static function generateTicketNo(): string
    {
        $last = static::latest('id')->first();
        $no   = $last ? ((int) substr($last->ticket_no, 1)) + 1 : 1;
        return '#' . str_pad($no, 4, '0', STR_PAD_LEFT);
    }

    // สถานะเป็นภาษาไทย
    public function statusLabel(): string
    {
        return match($this->status) {
            'new'         => 'ใหม่',
            'assigned'    => 'รับงานแล้ว',
            'in_progress' => 'กำลังซ่อม',
            'done'        => 'เสร็จแล้ว',
            'cancelled'   => 'ยกเลิก',
            default       => $this->status,
        };
    }

    public function isRated(): bool
    {
        return !is_null($this->rating);
    }

    public function ratingLabel(): string
    {
        return match($this->rating) {
            5       => 'ดีมาก',
            4       => 'ดี',
            3       => 'พอใช้',
            2       => 'ควรปรับปรุง',
            1       => 'ไม่พอใจ',
            default => 'ยังไม่ได้ประเมิน',
        };
    }

    public function repairDuration(): ?string
    {
        if (!$this->start_repair_at || !$this->finish_repair_at) {
            return null;
        }
        $minutes = $this->start_repair_at->diffInMinutes($this->finish_repair_at);
        if ($minutes < 60) {
            return $minutes . ' นาที';
        }
        $hours = floor($minutes / 60);
        $mins  = $minutes % 60;
        return $hours . ' ชั่วโมง' . ($mins > 0 ? ' ' . $mins . ' นาที' : '');
    }

    public function repairTypeLabel(): string
    {
        return match($this->repair_type) {
            'on_site'  => 'ซ่อมที่จุด',
            'bring_in' => 'นำเข้าซ่อม',
            'remote'   => 'ซ่อมทางไกล',
            default    => 'ไม่ระบุ',
        };
    }
}