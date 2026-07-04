<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('prod', function (Blueprint $table) {
            $table->dropForeign(['vehicle_brand_id']);
        });

        DB::statement('ALTER TABLE prod MODIFY vehicle_brand_id VARCHAR(255) NULL');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('prod')
            ->where('vehicle_brand_id', 'like', '%,%')
            ->update(['vehicle_brand_id' => null]);

        DB::statement('ALTER TABLE prod MODIFY vehicle_brand_id BIGINT UNSIGNED NULL');

        Schema::table('prod', function (Blueprint $table) {
            $table->foreign('vehicle_brand_id')->references('id')->on('vehcle_brands')->nullOnDelete();
        });
    }
};
