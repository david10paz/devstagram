<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_emisor_id',
        'user_receptor_id',
        'mensaje',
        'created_at',
    ];

    public function user_emisor(){
        return $this->belongsTo(User::class, 'user_emisor_id')->select(['name', 'username', 'imagen']);
    }

    public function user_receptor(){
        return $this->belongsTo(User::class, 'user_receptor_id')->select(['name', 'username', 'imagen']);
    }
}
