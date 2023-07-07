<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LikeController extends Controller
{
    public function store(Post $post, Request $request){
        //dd("Dando like");

        //Creando like
        $likes = new Like();
        $likes->user_id = auth()->user()->id;
        $likes->post_id = $post->id;
        $likes->save();

        return back();
    }

    public function destroy(Post $post, Request $request) {
        DB::table('likes')->where('user_id', auth()->user()->id)->where('post_id', $post->id)->delete();
        return back();
    }
}
