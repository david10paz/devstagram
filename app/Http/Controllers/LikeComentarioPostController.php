<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;
use App\Models\LikeComentario;
use Illuminate\Support\Facades\DB;

class LikeComentarioPostController extends Controller
{
    public function store(Comentario $comentario, Request $request){
        //dd("Dando like a comentario");

        //Creando like al comentario
        $like_comentario = new LikeComentario();
        $like_comentario->user_id = auth()->user()->id;
        $like_comentario->comentario_id = $comentario->id;
        $like_comentario->save();

        return back();
    }

    public function destroy(Comentario $comentario, Request $request) {
        DB::table('like_comentarios')->where('user_id', auth()->user()->id)->where('comentario_id', $comentario->id)->delete();
        return back();
    }
}
