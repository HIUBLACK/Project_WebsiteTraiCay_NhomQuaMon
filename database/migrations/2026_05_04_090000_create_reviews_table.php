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
        Schema::create('tbl_reviews', function (Blueprint $table) {
            $table->increments('review_id');
            $table->integer('order_id');
            $table->integer('product_id');
            $table->integer('user_id');
            $table->tinyInteger('rating');
            $table->text('review_content');
            $table->text('admin_reply')->nullable();
            $table->timestamp('admin_replied_at')->nullable();
            $table->timestamps();

            $table->unique(['order_id', 'product_id', 'user_id'], 'tbl_reviews_unique_order_product_user');
            $table->index(['product_id', 'created_at'], 'tbl_reviews_product_created_index');
            $table->index(['user_id', 'order_id'], 'tbl_reviews_user_order_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_reviews');
    }
};
