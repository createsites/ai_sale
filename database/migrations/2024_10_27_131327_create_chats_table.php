<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Привязка к пользователю
            $table->string('name')->nullable(); // Название чата (опционально)
            $table->timestamps(); // Дата создания и изменения
        });
    }

    public function down()
    {
        Schema::dropIfExists('chats');
    }
};
