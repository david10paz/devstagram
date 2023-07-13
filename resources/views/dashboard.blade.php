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
                    <p class="text-gray-700 text-2xl mb-5">{{ $user->username }}</p>

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

                <p class="text-gray-800 text-sm mb-3 font-bold">{{$user->followers->count()}}<span class="font-normal"> seguidores</span></p>
                <p class="text-gray-800 text-sm mb-3 font-bold">{{$user->followings->count()}}<span class="font-normal"> siguiendo</span></p>
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
                            <form action="{{ route('users.follow', $user) }}" method="POST">
                                @csrf
                                <input type="submit"
                                    class="bg-blue-600 text-white uppercase rounded-full px-3 py-1 text-xs font-bold cursor-pointer"
                                    value="Seguir" />
                            </form>
                        @endif
                    @endif
                @endauth
            </div>
        </div>
    </div>

    <section>
        <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>
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


    </section>
@endsection