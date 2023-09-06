<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LikeComentario extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'comentario_id',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
