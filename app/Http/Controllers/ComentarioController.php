<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class ComentarioController extends Controller
{
    public function store(User $user, Post $post, Request $request){
        //Validar
        $this->validate($request, [
            'comentario' => 'required|max:50'
        ]);

        //Almacenar el resultado
        Comentario::create([
            'user_id' => auth()->user()->id,
            'post_id' => $post->id,
            'comentario' => $request->comentario
        ]);

        //Imprimir mensaje
        return back()->with('mensaje', "Comentario publicado correctamente!!!");
    }
}
