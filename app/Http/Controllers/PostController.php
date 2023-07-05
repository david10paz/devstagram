<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth'); //Si no esta iniciado en sesión llama al middleware de Authenticate y si es así te retorna al login antes que mandarte al muro
    }

    public function index(User $user){
        //dd($user->username);
        return view('dashboard', ['user' => $user]);
    }

    public function create(User $user){
        //dd("Creando post");
        return view('posts.create');
    }

    public function store(Request $request){
        //dd("Creando post jeje");
        $this->validate($request, [
            'titulo' => 'required|max:50',
            'descripcion' => 'required|max:200',
            'imagen' => 'required'
        ]);

        //Esto es válido para crear un post pero voy a hacer otra manera
        /*Post::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' =>  auth()->user()->id
        ]);*/

        $post = new Post;
        $post->titulo = $request->titulo;
        $post->descripcion = $request->descripcion;
        $post->imagen = $request->imagen;
        $post->user_id = auth()->user()->id;
        $post->save();

        //Otra forma pero más compleja al haber hecho las relaciones en los modelos
        /*
        $request->user()->posts()->create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $request->imagen,
            'user_id' =>  auth()->user()->id
        ]);*/


        return redirect()->route('posts.index', auth()->user()->username);

    }
}
