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
        Schema::create('tbl_messages', function (Blueprint $table) {
            $table->increments('message_id');
            $table->integer('user_id');
            $table->integer('admin_id')->nullable();
            $table->string('sender_type', 20);
            $table->text('message_text');
            $table->boolean('is_read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'created_at'], 'tbl_messages_user_created_index');
            $table->index(['sender_type', 'is_read'], 'tbl_messages_sender_read_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_messages');
    }
};
