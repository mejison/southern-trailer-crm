<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $casts = [
        'attached' => 'json'
    ];

    protected $fillable = [
        'did',
        'message',
        'attached',
    ];
}
