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
        Schema::create('tbl_coupon_conditions', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('coupon_id');
    $table->bigInteger('min_order_value')->nullable();
    $table->integer('min_order_quantity')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_coupon_conditions');
    }
};
