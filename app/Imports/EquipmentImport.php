<?php

namespace App\Imports;

use App\Models\Equipment;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\SkipsErrors;

class EquipmentImport implements ToModel, WithHeadingRow, SkipsOnError
{
    use SkipsErrors;

    private int $imported = 0;

    public function model(array $row)
    {
        $assetCode = trim(
            $row['รหัส รพจ'] ?? $row['รหัสรพจ'] ?? $row['รหัส_รพจ'] ??
            $row['asset_code'] ?? $row['รหัส'] ?? ''
        );
        if (!$assetCode) return null;

        $name = trim(
            $row['ชื่ออุปกรณ์'] ?? $row['ชื่อ'] ?? $row['name'] ?? ''
        );
        if (!$name) return null;

        $equipment = Equipment::firstOrNew(['asset_code' => $assetCode]);
        $equipment->name     = $name;
        $equipment->model    = $this->str($row['รุ่น'] ?? $row['model'] ?? null);
        $equipment->brand    = $this->str($row['ยี่ห้อ'] ?? $row['brand'] ?? null);
        $equipment->serial_no = $this->str($row['หมายเลขเครื่อง'] ?? $row['serial'] ?? $row['serial_no'] ?? null);
        $equipment->location = $this->str($row['สถานที่'] ?? $row['หน่วยงาน'] ?? $row['location'] ?? null);
        $equipment->category = $this->guessCategory($name);
        $equipment->status   = $equipment->status ?: 'active';
        $equipment->purchase_price  = $this->parsePrice($row['ราคา'] ?? null);
        $equipment->purchase_date   = $this->parseDate($row['วันที่ซื้อ'] ?? null);
        $equipment->warranty_expire = $this->parseDate($row['วันหมดประกัน'] ?? null);

        $this->imported++;
        return $equipment;
    }

    private function str($val): ?string
    {
        $s = trim((string)($val ?? ''));
        return $s !== '' ? $s : null;
    }

    private function parsePrice($price): ?float
    {
        if ($price === null || $price === '') return null;
        $cleaned = preg_replace('/[^\d.]/', '', str_replace(',', '', (string)$price));
        return $cleaned !== '' ? (float)$cleaned : null;
    }

    private function parseDate($date): ?string
    {
        if ($date === null || $date === '') return null;
        $date = trim((string)$date);

        // Excel numeric date
        if (is_numeric($date)) {
            try {
                $dt = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject((float)$date);
                return $dt->format('Y-m-d');
            } catch (\Throwable $e) {
                return null;
            }
        }

        // d/m/yy or d/m/yyyy (Thai BE or Gregorian)
        if (preg_match('#^(\d{1,2})[/\-](\d{1,2})[/\-](\d{2,4})$#', $date, $m)) {
            $year = (int)$m[3];
            if ($year > 2400) {
                $year -= 543;       // 4-digit Buddhist Era → AD
            } elseif ($year <= 99) {
                $year += 1957;      // 2-digit Buddhist Era (68 → 2025)
            }
            return sprintf('%04d-%02d-%02d', $year, (int)$m[2], (int)$m[1]);
        }

        return null;
    }

    private function guessCategory(string $name): string
    {
        $n = mb_strtolower($name);
        if (preg_match('/printer|พิมพ์|ถ่ายเอกสาร|scanner|สแกน/u', $n)) return 'printer';
        if (preg_match('/switch|router|access.?point|wifi|network|เน็ตเวิร์ก/u', $n)) return 'network';
        if (preg_match('/computer|คอมพิวเตอร์|notebook|laptop|monitor|จอ|ups|server/u', $n)) return 'computer';
        return 'other';
    }

    public function getImported(): int
    {
        return $this->imported;
    }
}
