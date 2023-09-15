@extends('layouts.app')

<meta name="csrf-token" content="{{ csrf_token() }}" />

@section('titulo')
    {{ $user->name }} ({{ $user->username }}) - {{ $post->titulo }}
@endsection

@section('contenido')
    <div class="container mx-auto md:flex gap-6">

        <!-- Si estas logueado -->
        @auth
            @if ($user->privado == 1 && !$user->siguiendo(auth()->user()) && $user->id != auth()->user()->id)
                <p class="text-gray-400 uppercase text-sm text-center font-bold">Esta cuenta es privada, síguela para poder ver
                    su contenido.</p>
            @else
                <div class="md:w-1/2">
                    <img src="/uploads/{{ $post->imagen }}" alt="Imagen {{ $post->titulo }}">
                    <div class="p-3 flex items-center gap-4">
                        @auth
                            <livewire:like-post :post="$post" />

                            {{-- Esto de abajo funciona, pero vamos a hacerlo con livewire para que le sea reactivo el darle like o no --}}
                            {{--
                    @if ($post->checkLike(auth()->user()))
                        <form action="{{ route('posts.likes.destroy', $post) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <div class="mt-4">
                                <button wire:click="like">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="red" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    @else
                        <form action="{{ route('posts.likes.store', $post) }}" method="POST">
                            @csrf
                            <div class="mt-4">
                                <button type="submit">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    @endif
                    --}}
                        @endauth
                        {{-- Esto también lo comentamos porque vamos a hacerlo en livewire, pero funciona igual junto con lo arriba comentado --}}
                        {{--
                <p><span class="font-bold">{{ $post->likes->count() }}</span> likes</p>
                --}}
                    </div>

                    <div>
                        <p class="text-gray-500 font-bold">{{ $post->created_at->diffForHumans() }}</p>
                    </div>

                    @auth
                        @if ($post->user_id == auth()->user()->id)
                            <div class="mt-3">
                                <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                    @method('DELETE')
                                    <!-- SPOOFING para eliminar registros -->
                                    @csrf
                                    <input type="submit" value="Eliminar publicación"
                                        class="bg-red-600 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" />
                                </form>

                                <!-- Intento de borrado mediante JS-->
                                <!--form id="form-delete-post" onsubmit="deletePost({{ $post->id }})">
                                                                                                                    @csrf
                                                                                                                    <input type="submit" value="Eliminar publicación"
                                                                                                                        class="bg-red-600 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" />
                                                                                                                </form-->
                            </div>
                        @endif
                    @endauth
                </div>
                <div class="md:w-1/2">
                    {{ $post->descripcion }}

                    <div class="bg-white shadow p-5 mt-5">
                        @auth

                            @if (session('mensaje'))
                                <p class="bg-green-600 text-white rounded-lg text-sm text-center p-2 mb-3">{{ session('mensaje') }}
                                </p>
                            @endif

                            <p class="text-xl font-bold text-center">Agrega un nuevo comentario</p>

                            <form action="{{ route('comentarios.store', [$user, $post]) }}" method="POST">
                                @csrf
                                <div class="mb-3 mt-5">
                                    <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">Comentario</label>
                                    <textarea id="comentario" name="comentario" placeholder="Agrega un comentario"
                                        class="border p-3 w-full rounded-lg @error('comentario') border-red-500 @enderror"></textarea>
                                    @error('comentario')
                                        <p class="bg-red-500 text-white rounded-lg text-sm text-center p-2 mt-2">{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <input type="submit" value="Comentar"
                                    class="bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" />

                            </form>
                        @endauth

                        <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-6">
                            @if ($post->comentarios->count() <= 0)
                                <p class="text-gray-400 uppercase text-sm text-center font-bold">No hay comentarios todavía :(
                                </p>
                            @else
                                @foreach ($post->comentarios as $comentario)
                                    @php
                                        //Esto sería una manera de sacarlo, pero vamos a hacerlo por una funcion del modelo de Comentario
                                        //Si no sería llamar a $user_comentario->username
                                        $user_comentario = DB::table('users')
                                            ->where('id', $comentario->user_id)
                                            ->first();
                                    @endphp
                                    <div class="p-5 border-gray-300 border-b">
                                        <div class="container mx-auto md:flex gap-6">
                                            <div class="md:w-1/2">
                                                <p><a href="{{ route('posts.index', $comentario->user->username) }}"
                                                        class="font-bold">{{ $comentario->user->username }}:
                                                    </a>{{ $comentario->comentario }}</p>
                                                <small>{{ $comentario->created_at->diffForHumans() }}</small>
                                            </div>
                                            @auth
                                                <div class="md:w-1/2">
                                                    <p><livewire:like-comentario-post :comentario="$comentario" /></p>
                                                </div>
                                            @endauth
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        @endauth


        <!-- Si no estas logueado -->
        @guest
            @if ($user->privado == 0)
                <div class="md:w-1/2">
                    <img src="/uploads/{{ $post->imagen }}" alt="Imagen {{ $post->titulo }}">
                    <div class="p-3 flex items-center gap-4">
                        @auth
                            <livewire:like-post :post="$post" />
                        @endauth
                    </div>

                    <div>
                        <p class="text-gray-500 font-bold">{{ $post->created_at->diffForHumans() }}</p>
                    </div>

                    @auth
                        @if ($post->user_id == auth()->user()->id)
                            <div class="mt-3">
                                <form action="{{ route('posts.destroy', $post) }}" method="POST">
                                    @method('DELETE')
                                    <!-- SPOOFING para eliminar registros -->
                                    @csrf
                                    <input type="submit" value="Eliminar publicación"
                                        class="bg-red-600 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" />
                                </form>

                                <!-- Intento de borrado mediante JS-->
                                <!--form id="form-delete-post" onsubmit="deletePost({{ $post->id }})">
                                                                                                            @csrf
                                                                                                            <input type="submit" value="Eliminar publicación"
                                                                                                                class="bg-red-600 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" />
                                                                                                        </form-->
                            </div>
                        @endif
                    @endauth
                </div>
                <div class="md:w-1/2">
                    {{ $post->descripcion }}

                    <div class="bg-white shadow p-5 mt-5">
                        @auth

                            @if (session('mensaje'))
                                <p class="bg-green-600 text-white rounded-lg text-sm text-center p-2 mb-3">{{ session('mensaje') }}
                                </p>
                            @endif

                            <p class="text-xl font-bold text-center">Agrega un nuevo comentario</p>

                            <form action="{{ route('comentarios.store', [$user, $post]) }}" method="POST">
                                @csrf
                                <div class="mb-3 mt-5">
                                    <label for="comentario" class="mb-2 block uppercase text-gray-500 font-bold">Comentario</label>
                                    <textarea id="comentario" name="comentario" placeholder="Agrega un comentario"
                                        class="border p-3 w-full rounded-lg @error('comentario') border-red-500 @enderror"></textarea>
                                    @error('comentario')
                                        <p class="bg-red-500 text-white rounded-lg text-sm text-center p-2 mt-2">{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                <input type="submit" value="Comentar"
                                    class="bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" />

                            </form>
                        @endauth

                        <div class="bg-white shadow mb-5 max-h-96 overflow-y-scroll mt-6">
                            @if ($post->comentarios->count() <= 0)
                                <p class="text-gray-400 uppercase text-sm text-center font-bold">No hay comentarios todavía :(
                                </p>
                            @else
                                @foreach ($post->comentarios as $comentario)
                                    @php
                                        //Esto sería una manera de sacarlo, pero vamos a hacerlo por una funcion del modelo de Comentario
                                        //Si no sería llamar a $user_comentario->username
                                        $user_comentario = DB::table('users')
                                            ->where('id', $comentario->user_id)
                                            ->first();
                                    @endphp
                                    <div class="p-5 border-gray-300 border-b">
                                        <div class="container mx-auto md:flex gap-6">
                                            <div class="md:w-1/2">
                                                <p><a href="{{ route('posts.index', $comentario->user->username) }}"
                                                        class="font-bold">{{ $comentario->user->username }}:
                                                    </a>{{ $comentario->comentario }}</p>
                                                <small>{{ $comentario->created_at->diffForHumans() }}</small>
                                            </div>
                                            @auth
                                                <div class="md:w-1/2">
                                                    <p><livewire:like-comentario-post :comentario="$comentario" /></p>
                                                </div>
                                            @endauth
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            @else
                <p class="text-gray-400 uppercase text-sm text-center font-bold">Esta cuenta es privada, no tienes nada que ver.
                </p>
            @endif
        @endguest
    </div>
@endsection

<script type="text/javascript">
    //INTENTO DE BORRAR MEDIANTE JS
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("form-delete-post").addEventListener("submit", function(event) {
            event.preventDefault();
            console.log("hola");
        });
    });

    function deletePost(post) {

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '/posts/' + post,
                    type: 'DELETE',
                    data: {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                    },
                    success: function(result) {
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                });

            }
        })

    }
</script>
