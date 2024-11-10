<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    // Используем поле created_at, но отключаем updated_at
    const UPDATED_AT = null;

    protected $fillable = ['content', 'chat_id', 'tokens'];

    // Одно сообщение принадлежит одному чату
    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }
}
