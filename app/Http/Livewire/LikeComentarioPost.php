<?php

namespace App\Http\Livewire;

use App\Models\LikeComentario;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class LikeComentarioPost extends Component
{

    public $comentario;
    public $isLikedComentario;
    public $contLikeComentario;

    public function mount($comentario)
    {
        $this->isLikedComentario = $comentario->checkLikeComentarios(auth()->user());
        $this->contLikeComentario = $comentario->likeComentarios->count();
    }

    public function likeComentario()
    {
        if ($this->comentario->checkLikeComentarios(auth()->user())) {
            DB::table('like_comentarios')->where('user_id', auth()->user()->id)->where('comentario_id', $this->comentario->id)->delete();
            $this->isLikedComentario = false;
            $this->contLikeComentario--;
        } else {
            $like_comentario = new LikeComentario();
            $like_comentario->user_id = auth()->user()->id;
            $like_comentario->comentario_id = $this->comentario->id;
            $like_comentario->save();

            $this->isLikedComentario = true;
            $this->contLikeComentario++;
        }
    }

    public function render()
    {
        return view('livewire.like-comentario-post');
    }
}
