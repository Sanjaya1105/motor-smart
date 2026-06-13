<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('customer_name')->nullable()->after('address');
            $table->string('id_number')->nullable()->after('customer_name');
            $table->string('br_number')->nullable()->after('id_number');
            $table->string('bank')->nullable()->after('br_number');
            $table->string('branch')->nullable()->after('bank');
            $table->string('account_number')->nullable()->after('branch');
            $table->string('payment_method')->nullable()->after('account_number');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'customer_name',
                'id_number',
                'br_number',
                'bank',
                'branch',
                'account_number',
                'payment_method',
            ]);
        });
    }
};
