<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->mediumText('message');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('chatroom_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * 
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['user_id', 'chatroom_id']);
        });
        Schema::dropIfExists('messages');
    }
}
