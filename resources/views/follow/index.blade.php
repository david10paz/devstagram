@extends('layouts.app')


@section('titulo')
    Solicitudes de seguimiento de {{ $user->username }}
@endsection

@section('contenido')
    <section>
        @if (session('mensaje'))
            <p class="bg-green-600 text-white rounded-lg text-sm text-center p-2 mb-3">{{ session('mensaje') }}
            </p>
        @endif

        @if ($usuarios_para_confirmar->count() > 0)
            @foreach ($usuarios_para_confirmar as $usuario)
                <div class="p-6 bg-white border-b border-gray-200 md:flex">
                    <div class="md:w-1/12">
                        @if ($usuario->user_solicitado->imagen)
                            <a class="flex items-center gap-2 mb-2 mr-3"
                                href="{{ route('posts.index', $usuario->user_solicitado->username) }}">
                                <img width="80px" height="80px" class="rounded-full"
                                    src="{{ asset('perfiles') . '/' . $usuario->user_solicitado->imagen }}"
                                    alt="Imagen usuario">
                            </a>
                        @else
                            <a class="flex items-center gap-2 mb-2 mr-3"
                                href="{{ route('posts.index', $usuario->user_solicitado->username) }}">
                                <img width="80px" height="80px" src="{{ asset('img/usuario.svg') }}"
                                    alt="Imagen usuario">
                            </a>
                        @endif
                    </div>

                    <div class="md:w-1/12 flex gap-3 items-center mt-5 md:mt-0">
                        <p class="text-xl font-bold">
                            {{ $usuario->user_solicitado->name }}
                        </p>
                    </div>

                    <div class="md:w-1/12 flex gap-3 items-center mt-5 md:mt-0">
                        <p class="text-sm text-gray-600 font-bold">{{ $usuario->user_solicitado->username }}</p>
                    </div>
                    <div class="md:w-1/6 flex gap-3 items-center mt-5 md:mt-0">
                        <p class="text-sm text-gray-600 font-bold">Fecha de solicitud:<br /> {{ $usuario->created_at }}</p>
                    </div>

                    <div class="md:w-1/2 flex gap-3 items-center mt-5 md:mt-0 justify-end">
                        <div>
                            <form action="{{ route('users.confirmar-follow', $user) }}" method="POST" novalidate>
                                @csrf
                                <input type="hidden" name="user_solicitante_id"
                                    value="{{ $usuario->user_solicitante_id }}" />
                                <input type="hidden" name="respuesta" value="1" />
                                <input type="submit" value="Aceptar"
                                    class="bg-green-800 py-2 px-12 rounded-lg text-white text-xs font-bold uppercase cursor-pointer" />
                            </form>
                        </div>
                        <div>
                            <form action="{{ route('users.confirmar-follow', $user) }}" method="POST" novalidate>
                                @csrf
                                <input type="hidden" name="user_solicitante_id"
                                    value="{{ $usuario->user_solicitante_id }}" />
                                <input type="hidden" name="respuesta" value="2" />
                                <input type="submit" value="Rechazar"
                                    class="bg-red-800 py-2 px-12 rounded-lg text-white text-xs font-bold uppercase cursor-pointer" />
                            </form>
                        </div>
                    </div>

                </div>
            @endforeach
        @else
            <div class="container mx-auto flex items-center justify-center">
                <p class="text-sm text-gray-600 font-bold">No tienes solicitudes de seguimiento</p>
            </div>
        @endif
    </section>
@endsection
