@extends('layouts.app')

<meta name="csrf-token" content="{{ csrf_token() }}" />

@section('titulo')
    Chat entre {{ $user_emisor->name }} y {{ $user_receptor->name }}
@endsection

@section('contenido')
    <div class="container mx-auto gap-6">

        <!-- Si estas logueado -->
        @auth

            <div>

                <div class="bg-white shadow p-5 mt-5">

                    <p class="text-xl font-bold text-center">¡VAMOS A CHATEAR!</p>

                    @if (session('mensaje'))
                        <p class="bg-green-600 text-white rounded-lg text-sm text-center p-2 mb-3 mt-3">{{ session('mensaje') }}
                        </p>
                    @endif

                    <form action="{{ route('chat.store', ['user_emisor' => $user_emisor, 'user_receptor' => $user_receptor]) }}"
                        method="POST">
                        @csrf
                        <div class="mb-3 mt-5">
                            <label for="mensaje_chat" class="mb-2 block uppercase text-gray-500 font-bold">Mensaje: </label>
                            <textarea id="mensaje_chat" name="mensaje_chat" placeholder="Agrega un mensaje al chat"
                                class="border p-3 w-full rounded-lg @error('mensaje_chat') border-red-500 @enderror"></textarea>
                            @error('mensaje_chat')
                                <p class="bg-red-500 text-white rounded-lg text-sm text-center p-2 mt-2">{{ $message }}
                                </p>
                            @enderror
                        </div>

                        <input type="submit" value="Enviar mensaje"
                            class="bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" />

                    </form>

                    <div class="bg-white shadow mb-5 mt-6">
                        @if ($mensajes_del_chat->count() <= 0)
                            <p class="text-gray-400 uppercase text-sm text-center font-bold">Nunca habéis conversado todavía o
                                no habéis hablado en los últimos 5 días...
                            </p>
                        @else
                            @foreach ($mensajes_del_chat as $mensaje)
                                <div class="p-5 border-gray-300 border-b">
                                    <div class="container gap-6">

                                        <div>

                                            @if ($mensaje->user_emisor->imagen)
                                                <p>
                                                    <a href="{{ route('posts.index', $mensaje->user_emisor->username) }}"
                                                        class="font-bold flex items-center gap-2 mb-2">

                                                        <img width="30px" height="30px" class="rounded-full"
                                                            src="{{ asset('perfiles') . '/' . $mensaje->user_emisor->imagen }}"
                                                            alt="Imagen usuario">

                                                        {{ $mensaje->user_emisor->username }}:

                                                        <span class="font-normal">{{ $mensaje->mensaje }}</span>
                                                    </a>
                                                </p>
                                                <small>{{ $mensaje->created_at->diffForHumans() }}</small>
                                            @else
                                                <p>
                                                    <a href="{{ route('posts.index', $mensaje->user_emisor->username) }}"
                                                        class="font-bold flex items-center gap-2 mb-2">

                                                        <img width="30px" height="30px" class="rounded-full"
                                                            src="{{ asset('img/usuario.svg') }}" alt="Imagen usuario">

                                                        {{ $mensaje->user_emisor->username }}:

                                                        <span class="font-normal">{{ $mensaje->mensaje }}</span>
                                                    </a>
                                                </p>
                                                <small>{{ $mensaje->created_at->diffForHumans() }}</small>
                                            @endif

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>

                </div>
            </div>
        @endauth
    </div>
@endsection
