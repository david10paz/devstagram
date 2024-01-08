@extends('layouts.app')


@section('titulo')
    Conversaciones de {{ $user->username }}
@endsection

@section('contenido')
    <section>

        @if (count($conversaciones) > 0)
            @foreach ($conversaciones as $usuario_conversacion)
                <div class="p-6 bg-white border-b border-gray-200 md:flex">
                    <div class="md:w-1/12">
                        @if ($usuario_conversacion->imagen)
                            <a class="flex items-center gap-2 mb-2 mr-3"
                                href="{{ route('posts.index', $usuario_conversacion->username) }}">
                                <img width="80px" height="80px" class="rounded-full"
                                    src="{{ asset('perfiles') . '/' . $usuario_conversacion->imagen }}" alt="Imagen usuario">
                            </a>
                        @else
                            <a class="flex items-center gap-2 mb-2 mr-3"
                                href="{{ route('posts.index', $usuario_conversacion->username) }}">
                                <img width="80px" height="80px" src="{{ asset('img/usuario.svg') }}"
                                    alt="Imagen usuario">
                            </a>
                        @endif
                    </div>

                    <div class="md:w-1/12 flex gap-3 items-center mt-5 md:mt-0">
                        <p class="text-xl font-bold">
                            {{ $usuario_conversacion->name }}
                        </p>
                    </div>

                    <div class="md:w-1/12 flex gap-3 items-center mt-5 md:mt-0">
                        <p class="text-sm text-gray-600 font-bold">{{ $usuario_conversacion->username }}</p>
                    </div>

                    <div class="md:w-1/2 flex gap-3 items-center mt-5 md:mt-0 justify-end">
                        <div>
                            <a class="text-blue-500 hover:text-blue-600 cursor-pointer"
                                href="{{ route('chat.index', ['user_emisor' => auth()->user(), 'user_receptor' => $usuario_conversacion]) }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                </svg>
                                <span class="font-bold">¡Sigamos hablando!</span>

                            </a>
                        </div>

                    </div>

                </div>
            @endforeach
        @else
            <div class="container mx-auto flex items-center justify-center">
                <p class="text-sm text-gray-600 font-bold">No tienes coversaciones</p>
            </div>
        @endif
    </section>
@endsection
