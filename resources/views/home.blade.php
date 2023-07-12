@extends('layouts.app')


@section('titulo')
    Página principal
@endsection

@section('contenido')
    @if ($posts->count())
        <div class="grid md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($posts as $post)
                @php
                    $userPost = DB::table('users')
                        ->where('username', $post->user->username)
                        ->first();
                @endphp

                <div>
                    <div>
                        @if ($userPost->imagen)
                            <a class="flex items-center gap-2 mb-2" href="{{ route('posts.index', $post->user->username) }}">
                                <img width="30px" height="30px" class="rounded-full"
                                    src="{{ asset('perfiles') . '/' . $userPost->imagen }}" alt="Imagen usuario">
                                <p class="mb-3 text-sm text-gray-500 font-bold">{{ $userPost->username }}</p>
                            </a>
                        @else
                            <a class="flex items-center gap-2 mb-2" href="{{ route('posts.index', $post->user->username) }}">
                                <img width="30px" height="30px" src="{{ asset('img/usuario.svg') }}"
                                    alt="Imagen usuario">
                                <p class="mb-3 text-sm text-gray-500 font-bold">{{ $userPost->username }}</p>
                            </a>
                        @endif
                    </div>

                    <a href="{{ route('posts.show', [$post->user, $post]) }}">
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
        <p>No hay posts, sigue a alguien :)</p>
    @endif
@endsection
