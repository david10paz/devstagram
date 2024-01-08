<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        //Si no esta iniciado en sesión llama al middleware de Authenticate y si es así 
        //te retorna al login antes que mandarte a la home
    }


    public function lista()
    {

        $user = auth()->user();

        $mensajes_del_chat = Chat::where(function ($query) use ($user) {
                $query->where('user_emisor_id', $user->id)
                    ->orWhere('user_receptor_id', $user->id);
            })
            ->orderBy('created_at', 'DESC')->select('user_emisor_id', 'user_receptor_id')->get();

        $data = collect($mensajes_del_chat->toArray())->flatten()->unique()->all();
        $user_id = array_search($user->id, $data);

        if ($user_id !== false) {
            unset($data[$user_id]);
        }

        //dd($data);

        $conversaciones = [];

        foreach ($data as $persona_con_conversacion) {
            // Assuming $persona_con_conversacion is a user ID
            $user = User::find($persona_con_conversacion);

            if ($user) {
                // Add user data to $conversaciones array
                $conversaciones[] = $user;
            }
        }

        //dd($conversaciones);

        return view('chat.lista', ['user' => auth()->user(), 'conversaciones' => $conversaciones]);
    }


    public function index(User $user_emisor, User $user_receptor)
    {

        if ($user_emisor->id == auth()->user()->id) {

            $mensajes_del_chat = Chat::where(function ($query) use ($user_emisor, $user_receptor) {
                    $query->where('user_emisor_id', $user_emisor->id)
                        ->orWhere('user_emisor_id', $user_receptor->id);
                })->where(function ($query) use ($user_emisor, $user_receptor) {
                    $query->where('user_receptor_id', $user_emisor->id)
                        ->orWhere('user_receptor_id', $user_receptor->id);
                })
                ->where('created_at', '>=', now()->subDays(10))
                ->orderBy('created_at', 'DESC')->get();

            return view('chat.index', ['user_emisor' => $user_emisor, 'user_receptor' => $user_receptor, 'mensajes_del_chat' => $mensajes_del_chat]);
        } else {
            return back();
        }
    }

    public function store(User $user_emisor, User $user_receptor, Request $request)
    {

        //Validar
        $this->validate($request, [
            'mensaje_chat' => 'required|max:50'
        ]);

        //Almacenar el resultado
        Chat::create([
            'user_emisor_id' => $user_emisor->id,
            'user_receptor_id' => $user_receptor->id,
            'mensaje' => $request->mensaje_chat,
        ]);

        //Imprimir mensaje
        return back()->with('mensaje', "Mensaje enviado.");
    }
}
