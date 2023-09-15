<?php

namespace App\Http\Controllers;

use App\Models\ConfirmUser;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except('show', 'index');
        //Si no esta iniciado en sesión llama al middleware de Authenticate y si es así 
        //te retorna al login antes que mandarte al muro

        //Le añadimos el except de show porque no hace falta estar logueado para ver el post
        //Le añadimos el except de index porque no hace falta estar logueado para ver el perfil del usuario, 
        //posterior le añadiremos la condición de no poder seguir si no estas logueado
    }

    public function index(User $user)
    {
        //dd($user->username);

        $posts = Post::where('user_id', $user->id)->orderBy('created_at', 'desc')->paginate(4);

        $user_pendiente_confirm = null;

        if (auth()->user()) {
            $user_pendiente_confirm = ConfirmUser::where('user_solicitante_id', auth()->user()->id)->where('user_id', $user->id)->first();
        }

        return view('dashboard', ['user' => $user, 'posts' => $posts, 'user_pendiente_confirm' => $user_pendiente_confirm]);
    }

    public function create(User $user)
    {
        //dd("Creando post");
        return view('posts.create');
    }

    public function store(Request $request)
    {
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

    public function show(User $user, Post $post)
    {
        return view('posts.show', ['user' => $user, 'post' => $post]);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        //Ahora eliminamos la imagen para no tenerla almacenada
        $imagen_path = public_path('uploads/' . $post->imagen);
        if (File::exists($imagen_path)) {
            unlink($imagen_path);
        }

        return redirect()->route('posts.index', auth()->user()->username);
    }
}
