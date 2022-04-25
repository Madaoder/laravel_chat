<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Message;

class Chatroom extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'password'
    ];

    protected $hidden = [
        'password'
    ];

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}
