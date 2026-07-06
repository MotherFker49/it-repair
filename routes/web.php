<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicRepairController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\RepairRequestController;
use App\Http\Controllers\TechnicianController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\UserRepairController;
use Illuminate\Support\Facades\Route;

// หน้าแรก
Route::get('/', function () {
    return view('welcome');
})->name('home');

// ประเมินความพึงพอใจ (ไม่ต้อง login)
Route::get('/rating/{ticket}/thanks', [RatingController::class, 'thanks'])->name('rating.thanks');
Route::get('/rating/{ticket}', [RatingController::class, 'show'])->name('rating.show');
Route::post('/rating/{repair}', [RatingController::class, 'store'])->name('rating.store');

// ต้อง login ทุก role
Route::middleware(['auth', 'verified'])->group(function () {

    // แจ้งซ่อม / ติดตามสถานะ / API ค้นหาอุปกรณ์ (ต้อง login)
    Route::get('/repair-request', [PublicRepairController::class, 'create'])->name('public.repair');
    Route::post('/repair-request', [PublicRepairController::class, 'store'])->name('public.repair.store');
    Route::get('/repair-request/success', [PublicRepairController::class, 'success'])->name('public.repair.success');
    Route::get('/track', [TrackController::class, 'index'])->name('track');
    Route::post('/track', [TrackController::class, 'search'])->name('track.search');
    Route::get('/api/equipment-search', [EquipmentController::class, 'apiSearch'])->name('api.equipment.search');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // ===== USER =====
    Route::middleware(['role:user'])->prefix('user')->name('user.')->group(function () {
        Route::get('/dashboard', [UserRepairController::class, 'index'])->name('dashboard');
        Route::get('/repair/create', [UserRepairController::class, 'create'])->name('repair.create');
        Route::post('/repair', [UserRepairController::class, 'store'])->name('repair.store');
        Route::get('/repair/{repair}', [UserRepairController::class, 'show'])->name('repair.show');
    });

    // ===== TECHNICIAN & ADMIN =====
    Route::middleware(['role:technician|admin'])->group(function () {
        Route::get('/technician', [TechnicianController::class, 'index'])->name('technician.index');
        Route::get('/technician-search', [TechnicianController::class, 'search'])->name('technician.search');
        Route::get('/technician/{repair}', [TechnicianController::class, 'show'])->name('technician.show');
        Route::post('/technician/{repair}/accept', [TechnicianController::class, 'accept'])->name('technician.accept');
        Route::patch('/technician/{repair}/status', [TechnicianController::class, 'updateStatus'])->name('technician.status');
    });

    // ===== ADMIN =====
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::resource('repairs', RepairRequestController::class);
        Route::patch('repairs/{repair}/status', [RepairRequestController::class, 'updateStatus'])->name('repairs.status');
    });

    // ===== ADMIN + TECHNICIAN =====
    Route::middleware(['role:admin|technician'])->group(function () {
        Route::get('equipments/import', [EquipmentController::class, 'importForm'])->name('equipments.import');
        Route::post('equipments/import', [EquipmentController::class, 'import'])->name('equipments.import.store');
        Route::resource('equipments', EquipmentController::class);
    });
});

require __DIR__.'/auth.php';
