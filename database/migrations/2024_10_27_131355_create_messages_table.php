<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_id')->constrained()->onDelete('cascade'); // Привязка к чату
            $table->text('content'); // Содержимое сообщения
            $table->timestamp('created_at'); // Только дата создания
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
