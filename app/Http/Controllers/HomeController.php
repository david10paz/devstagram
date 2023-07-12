<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        //Si no esta iniciado en sesión llama al middleware de Authenticate y si es así 
        //te retorna al login antes que mandarte a la home
    }

    public function index(){

        //dd(auth()->user()->followings->pluck('id')->toArray());
        //Obtener a quienes seguimos
        $ids = auth()->user()->followings->pluck('id')->toArray();
        $posts = Post::whereIn('user_id', $ids)->orderBy('created_at', 'desc')->paginate(4);

        //dd($posts);

        return view('home', ['posts' => $posts]);
    }
}
