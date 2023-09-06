<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comentario extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'post_id',
        'comentario',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function likeComentarios(){
        return $this->hasMany(LikeComentario::class);
    }

    public function checkLikeComentarios(User $user){
        return $this->likeComentarios->contains('user_id' , $user->id);
    }
}
