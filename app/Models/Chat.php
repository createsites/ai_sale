<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id'];

    // Один пользователь может иметь много чатов
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Один чат может содержать много сообщений
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
