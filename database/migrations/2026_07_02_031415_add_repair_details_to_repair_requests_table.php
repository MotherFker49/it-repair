<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('repair_requests', function (Blueprint $table) {
            $table->text('root_cause')->nullable()->after('solution');
            $table->enum('repair_type', ['on_site', 'bring_in', 'remote'])->nullable()->after('root_cause');
            $table->text('parts_used')->nullable()->after('repair_type');
            $table->timestamp('start_repair_at')->nullable()->after('parts_used');
            $table->timestamp('finish_repair_at')->nullable()->after('start_repair_at');
        });
    }

    public function down(): void
    {
        Schema::table('repair_requests', function (Blueprint $table) {
            $table->dropColumn(['root_cause', 'repair_type', 'parts_used', 'start_repair_at', 'finish_repair_at']);
        });
    }
};
