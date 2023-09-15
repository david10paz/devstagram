<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfirmUser extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_solicitante_id'
    ];

    public function user_solicitado()
    {
        return $this->belongsTo(User::class, 'user_solicitante_id');
    }
}
