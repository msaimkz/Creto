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
        Schema::table('orders', function (Blueprint $table) {
            $table->integer('coupon_code_id')->nullable()->after('coupon_code');
            $table->enum('payment_status',['pending','Complete'])->default('pending')->after('grand_total');
            $table->enum('delivery_status',['pending','shipped','delivered','cancelled'])->default('pending')->after('payment_status');
            $table->timestamp('shipping_date')->nullable()->after('delivery_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('coupon_code_id');
            $table->dropColumn('payment_status');
            $table->dropColumn('delivery_status');
            $table->dropColumn('shipping_date');
        });
    }
};
