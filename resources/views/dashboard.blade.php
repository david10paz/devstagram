@extends('layouts.app')


@section('titulo')
    Perfil: {{$user->username}}
@endsection

@section('contenido')
    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
            <div class="w-6/12 lg:w-6/12 px-5">
                <img src="{{asset('img/usuario.svg')}}" alt="Imagen usuario">
            </div>
            <div class="md:w-6/12 lg:w-6/12 px-5 flex flex-col md:items-start md:justify-center items-center py-10 md:py-10">
                <p class="text-gray-700 text-2xl mb-5">{{$user->username}}</p>
                <p class="text-gray-800 text-sm mb-3 font-bold">0<span class="font-normal"> seguidores</span></p>
                <p class="text-gray-800 text-sm mb-3 font-bold">0<span class="font-normal"> siguiendo</span></p>
                <p class="text-gray-800 text-sm mb-3 font-bold">0<span class="font-normal"> posts</span></p>
            </div>
        </div>
    </div>
@endsection
