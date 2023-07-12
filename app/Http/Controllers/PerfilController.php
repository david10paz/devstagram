<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class PerfilController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        //Si no esta iniciado en sesión llama al middleware de Authenticate y si es así 
        //te retorna al login antes que mandarte a la edición del perfil
    }

    public function index()
    {
        return view('perfil.index');
    }

    public function store(Request $request)
    {
        //Modificar el request
        $request->request->add(['username' => Str::slug($request->username)]);

        //Esta parte de aquí:  ---- username,'. auth()->user()->id . ---- corresponde a que si estoy metiendo mi propio usuario
        //no me diga que ese usuario esta tomado y no me deje editar mi perfil  
        $this->validate($request, [
            'username' => 'required|unique:users,username,' . auth()->user()->id . '|min:3|max:20',
        ]);

        //Compruebo si tiene imagen ya el usuario
        if (auth()->user()->imagen) {
            $nombreImagen = auth()->user()->imagen;
        } else {
            $nombreImagen = '';
        }

        //Si la quiere cambiar empezamos el proceso
        if ($request->imagen) {
            $imagen = $request->file('imagen');

            $nombreImagen = Str::uuid() . "." . $imagen->extension();

            $imagenServidor = Image::make($imagen);
            $imagenServidor->fit(1000, 1000);

            $imagenPath = public_path('perfiles') . '/' . $nombreImagen;
            $imagenServidor->save($imagenPath);
        }

        $usuario = User::find(auth()->user()->id);
        $usuario->username = $request->username;
        //Si no tenía imagen y no la ha cambiado se queda en vació nombreImagen
        //Si tenía imagen y no la cambia se mantiene la que tenía
        //Si no tenía o tenía imagen y la cambia pues se le ha hecho el proceso de cambio
        $usuario->imagen = $nombreImagen;
        $usuario->save();

        return redirect()->route('posts.index', $usuario->username);
    }
}
