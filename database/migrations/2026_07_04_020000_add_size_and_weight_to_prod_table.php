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
            $table->decimal('height', 10, 2)->nullable()->after('discount_percentage');
            $table->decimal('width', 10, 2)->nullable()->after('height');
            $table->decimal('length', 10, 2)->nullable()->after('width');
            $table->decimal('weight', 10, 2)->nullable()->after('length');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('prod', function (Blueprint $table) {
            $table->dropColumn(['height', 'width', 'length', 'weight']);
        });
    }
};
