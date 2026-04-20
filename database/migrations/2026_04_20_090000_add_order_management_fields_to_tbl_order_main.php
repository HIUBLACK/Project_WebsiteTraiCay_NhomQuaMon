<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tbl_order_main', function (Blueprint $table) {
            $table->tinyInteger('payment_status')->default(0)->after('status');
            $table->string('coupon_code')->nullable()->after('payment_status');
            $table->integer('coupon_discount')->default(0)->after('coupon_code');
            $table->text('cancel_reason')->nullable()->after('coupon_discount');
            $table->timestamp('cancelled_at')->nullable()->after('cancel_reason');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tbl_order_main', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status',
                'coupon_code',
                'coupon_discount',
                'cancel_reason',
                'cancelled_at',
            ]);
        });
    }
};
