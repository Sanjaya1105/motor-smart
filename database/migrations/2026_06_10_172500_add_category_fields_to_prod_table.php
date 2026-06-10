<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('prod', function (Blueprint $table) {
            $table->foreignId('vehicle_brand_id')->nullable()->after('image_path')->constrained('vehcle_brands')->nullOnDelete();
            $table->foreignId('vehicle_type_id')->nullable()->after('vehicle_brand_id')->constrained('vehicle_types')->nullOnDelete();
            $table->foreignId('category_product_id')->nullable()->after('vehicle_type_id')->constrained('category_products')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prod', function (Blueprint $table) {
            $table->dropConstrainedForeignId('category_product_id');
            $table->dropConstrainedForeignId('vehicle_type_id');
            $table->dropConstrainedForeignId('vehicle_brand_id');
        });
    }
};
