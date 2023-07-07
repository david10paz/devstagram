@extends('layouts.app')


@section('titulo')
    Perfil: {{ $user->username }}
@endsection

@section('contenido')
    <div class="flex justify-center">
        <div class="w-full md:w-8/12 lg:w-6/12 flex flex-col items-center md:flex-row">
            <div class="w-6/12 lg:w-6/12 px-5">
                <img src="{{ asset('img/usuario.svg') }}" alt="Imagen usuario">
            </div>
            <div class="md:w-6/12 lg:w-6/12 px-5 flex flex-col md:items-start md:justify-center items-center py-10 md:py-10">
                <p class="text-gray-700 text-2xl mb-5">{{ $user->username }}</p>
                <p class="text-gray-800 text-sm mb-3 font-bold">0<span class="font-normal"> seguidores</span></p>
                <p class="text-gray-800 text-sm mb-3 font-bold">0<span class="font-normal"> siguiendo</span></p>
                <p class="text-gray-800 text-sm mb-3 font-bold">{{ $user->posts->count() }}<span class="font-normal">
                        posts</span></p>
            </div>
        </div>
    </div>

    <section>
        <h2 class="text-4xl text-center font-black my-10">Publicaciones</h2>
        @if ($posts->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach ($posts as $post)
                    <div>
                        <a href="{{route('posts.show', [$user, $post])}}">
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
