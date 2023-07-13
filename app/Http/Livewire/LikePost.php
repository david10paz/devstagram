<?php

namespace App\Http\Livewire;

use App\Models\Like;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class LikePost extends Component
{
    public $post;
    public $isLiked;
    public $contLikes;

    public function mount($post){
        $this->isLiked = $post->checkLike(auth()->user());
        $this->contLikes = $post->likes->count();
    }

    public function like()
    {
        if ($this->post->checkLike(auth()->user())) {
            DB::table('likes')->where('user_id', auth()->user()->id)->where('post_id', $this->post->id)->delete();
            $this->isLiked = false;
            $this->contLikes--;

        } else {
            $likes = new Like();
            $likes->user_id = auth()->user()->id;
            $likes->post_id = $this->post->id;
            $likes->save();

            $this->isLiked = true;
            $this->contLikes++;
        }
    }

    public function render()
    {
        return view('livewire.like-post');
    }
}
