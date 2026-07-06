<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('repair_requests', function (Blueprint $table) {
            $table->string('reporter_name')->nullable()->after('ticket_no');
            $table->string('reporter_phone', 20)->nullable()->after('reporter_name');
            $table->string('department')->nullable()->after('reporter_phone');
        });
    }

    public function down(): void
    {
        Schema::table('repair_requests', function (Blueprint $table) {
            $table->dropColumn(['reporter_name', 'reporter_phone', 'department']);
        });
    }
};
