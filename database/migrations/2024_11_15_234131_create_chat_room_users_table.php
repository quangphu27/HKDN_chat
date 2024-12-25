<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_room_users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('chat_room_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->enum('available', ['YES', 'NOT'])->default('YES');
            $table->timestamps();
            $table->foreign('chat_room_id')->references('id')->on('chat_rooms');
            $table->foreign('user_id')->references('id')->on('users');
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_room_users');
    }
};
