<?php

namespace App\Http\Controllers;

use App\Models\ConfirmUser;
use App\Models\User;
use Illuminate\Http\Request;

class FollowerController extends Controller
{
    public function store(User $user)
    {
        $user->followers()->attach(auth()->user()->id);

        return back();
    }

    public function destroy(User $user)
    {
        $user->followers()->detach(auth()->user()->id);

        return back();
    }

    //Para cuentas privadas

    public function solicitar_follow(User $user)
    {

        //Creamos una solicitud de seguimiento
        $confirm_user = new ConfirmUser;
        $confirm_user->user_id = $user->id;
        $confirm_user->user_solicitante_id = auth()->user()->id;
        $confirm_user->save();

        return back();
    }

    public function show_confirmar_follow(User $user)
    {

        $usuarios_para_confirmar = ConfirmUser::where('user_id', $user->id)->get();

        return view('follow.index', ['user' => $user, 'usuarios_para_confirmar' => $usuarios_para_confirmar]);
    }

    public function confirmar_follow(User $user, Request $request)
    {
        $usuario_solicitante = $request->user_solicitante_id;
        $respuesta = $request->respuesta;

        //Si la respuesta es aprobada (1) lo metemos en la bbdd en followers
        if ($respuesta == 1) {
            $user->followers()->attach($usuario_solicitante);
        }

        //Eliminamos la solicitud pues ya esta aprobada o rechazada
        ConfirmUser::where('user_id', $user->id)->where('user_solicitante_id', $usuario_solicitante)->delete();



        $nombre_usuario_solicitante = User::where('id', $usuario_solicitante)->first();

        if ($respuesta == 1) {
            return back()->with('mensaje', "Usuario " . $nombre_usuario_solicitante->username . " aceptado!!");;
        } else {

            return back()->with('mensaje', "Usuario " . $nombre_usuario_solicitante->username . " rechazado!!");;
        }
    }
}
