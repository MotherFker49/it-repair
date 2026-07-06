<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    protected $table = 'equipments';

    protected $fillable = [
        'asset_code', 'name', 'model', 'category',
        'brand', 'serial_no', 'location', 'assigned_user_id',
        'status', 'purchase_date', 'purchase_price',
        'warranty_expire', 'note',
    ];

    protected $casts = [
        'purchase_date'   => 'date',
        'warranty_expire' => 'date',
        'purchase_price'  => 'decimal:2',
    ];

    // ผู้ใช้งานอุปกรณ์นี้
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_user_id');
    }

    // ประวัติการซ่อมทั้งหมด
    public function repairRequests(): HasMany
    {
        return $this->hasMany(RepairRequest::class);
    }

    // ค่าซ่อมรวมทั้งหมด
    public function totalRepairCost(): float
    {
        return $this->repairRequests()->sum('repair_cost') ?? 0;
    }

    // เช็คว่าประกันยังไม่หมด
    public function isUnderWarranty(): bool
    {
        if (!$this->warranty_expire) return false;
        return $this->warranty_expire->isFuture();
    }

    // สถานะเป็นภาษาไทย
    public function statusLabel(): string
    {
        return match($this->status) {
            'active'      => 'ใช้งานปกติ',
            'inactive'    => 'ไม่ได้ใช้งาน',
            'maintenance' => 'อยู่ระหว่างซ่อม',
            'retired'     => 'เลิกใช้งานแล้ว',
            default       => $this->status,
        };
    }
}