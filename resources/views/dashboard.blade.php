@extends('layouts.app')


@section('titulo')
    Perfil: {{ $user->username }}
@endsection

@section('contenido')
    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
            <div class="w-6/12 lg:w-6/12 px-5">
                @if ($user->imagen)
                    <img class="rounded-full" src="{{ asset('perfiles') . '/' . $user->imagen }}" alt="Imagen usuario">
                @else
                    <img src="{{ asset('img/usuario.svg') }}" alt="Imagen usuario">
                @endif
            </div>
            <div class="md:w-6/12 lg:w-6/12 px-5 flex flex-col md:items-start md:justify-center items-center py-10 md:py-10">
                <div class="flex gap-2">
                    <p class="text-gray-700 text-2xl mb-5">

                        {{ $user->username }}

                        @auth
                            @if ($user->id != auth()->user()->id)
                                @if ($user->tesigue(auth()->user()))
                                    <span
                                        class=" text-blue-700  focus:ring-4 focus:outline-none font-bold rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 ">
                                        Te sigue
                                    </span>
                                @else
                                    <span
                                        class=" text-red-700 focus:ring-4 focus:outline-none font-bold rounded-lg text-sm px-5 py-2.5 text-center dark:bg-red-600">
                                        No te sigue
                                    </span>
                                @endif
                            @endif
                        @endauth

                        @if (auth()->user()->id != $user->id)
                            <div class="mt-2">
                                <a class="text-blue-500 hover:text-blue-600 cursor-pointer"
                                    href="{{ route('chat.index', ['user_emisor' => auth()->user(), 'user_receptor' => $user]) }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M7.5 8.25h9m-9 3H12m-9.75 1.51c0 1.6 1.123 2.994 2.707 3.227 1.129.166 2.27.293 3.423.379.35.026.67.21.865.501L12 21l2.755-4.133a1.14 1.14 0 0 1 .865-.501 48.172 48.172 0 0 0 3.423-.379c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0 0 12 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018Z" />
                                    </svg>

                                </a>
                            </div>
                        @endif
                    </p>

                    @auth
                        @if (auth()->user()->id == $user->id)
                            <a href="{{ route('perfil.index') }}" class="text-gray-500 hover:text-gray-600 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>

                            </a>
                        @endif
                    @endauth
                </div>

                @if ($user->descripcion)
                    <p class="text-gray-800 text-sm mb-3 font-bold">{{ $user->descripcion }}</p>
                @endif
                <p class="text-gray-800 text-sm mb-3 font-bold">{{ $user->followers->count() }}<span class="font-normal">
                        seguidores</span></p>
                <p class="text-gray-800 text-sm mb-3 font-bold">{{ $user->followings->count() }}<span class="font-normal">
                        siguiendo</span></p>
                <p class="text-gray-800 text-sm mb-3 font-bold">{{ $user->posts->count() }}<span class="font-normal">
                        posts</span></p>




                @auth
                    @if ($user->id != auth()->user()->id)
                        @if ($user->siguiendo(auth()->user()))
                            <form action="{{ route('users.unfollow', $user) }}" method="POST">
                                @csrf
                                <input type="submit"
                                    class="bg-red-600 text-white uppercase rounded-full px-3 py-1 text-xs font-bold cursor-pointer"
                                    value="Dejar de seguir" />
                            </form>
                        @else
                            @if ($user->privado == 0)
                                <form action="{{ route('users.follow', $user) }}" method="POST">
                                    @csrf
                                    <input type="submit"
                                        class="bg-blue-600 text-white uppercase rounded-full px-3 py-1 text-xs font-bold cursor-pointer"
                                        value="Seguir" />
                                </form>
                            @elseif($user->privado == 1 && !$user_pendiente_confirm)
                                <form action="{{ route('users.solicitar-follow', $user) }}" method="POST">
                                    @csrf
                                    <input type="submit"
                                        class="bg-blue-600 text-white uppercase rounded-full px-3 py-1 text-xs font-bold cursor-pointer"
                                        value="Seguir (Solicitud a una cuenta privada)" />
                                </form>
                            @elseif($user->privado == 1 && $user_pendiente_confirm)
                                <p class="text-yellow-400 uppercase text-sm text-center font-bold mt-3">Pendiente de
                                    aprobación<br /> la solicitud de seguimiento</p>
                            @endif
                        @endif
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <section>
        <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>
        @auth
            @if ($user->privado == 1 && !$user->siguiendo(auth()->user()) && $user->id != auth()->user()->id)
                <p class="text-gray-400 uppercase text-sm text-center font-bold">Esta cuenta es privada.</p>
            @else
                @if ($posts->count() > 0)
                    <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                        @foreach ($posts as $post)
                            <div>
                                <a href="{{ route('posts.show', [$user, $post]) }}">
                                    <img src="/uploads/{{ $post->imagen }}" alt="Imagen {{ $post->titulo }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="my-10">
                        <!-- En el caso de que haya más de 4 posts como hemos definido en el controller hará una paginación -->
                        {{ $posts->links() }}
                    </div>
                @else
                    <p class="text-gray-400 uppercase text-sm text-center font-bold">No hay posts todavía :(</p>
                @endif
            @endif
        @endauth

        @guest
            <p class="text-gray-400 uppercase text-sm text-center font-bold"><a href="{{ route('login') }}"
                    class="text-blue-600">INICIA SESIÓN</a> o <a href="{{ route('register') }}"
                    class="text-blue-600">REGÍSTRATE</a> PARA PODER VER LAS PUBLICACIONES DE DEVSTAGRAM</p>
        @endguest


    </section>
@endsection
