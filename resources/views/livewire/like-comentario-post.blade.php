<div class="flex gap-4">
    <button wire:click='likeComentario'>
        <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $isLikedComentario ? 'red' : 'white' }}" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
        </svg>
    </button>

    <p class="cursor-pointer"><a data-modal-target="modalLikesComentariosUsuarios_{{$comentario->id}}" data-modal-toggle="modalLikesComentariosUsuarios_{{$comentario->id}}"><span class="font-bold items-center">{{ $contLikeComentario }}</span> likes</a></p>


    <!-- Main modal -->
    <div id="modalLikesComentariosUsuarios_{{$comentario->id}}" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Usuarios que dieron like al comentario: {{$comentario->comentario}}
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="modalLikesComentariosUsuarios_{{$comentario->id}}">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Cerrar modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-6 space-y-6">
                    @if ($comentario->likeComentarios->count() <= 0)
                        <p class="text-gray-400 uppercase text-sm text-center font-bold">No hay likes a este comentario todavía :(</p>
                    @else
                        @foreach ($comentario->likeComentarios as $likesComentario)
                            @php
                                //Esto sería una manera de sacarlo, pero vamos a hacerlo por una funcion del modelo de Like
                                //Si no sería llamar a $user_like_comentario->username
                                $user_like_comentario = DB::table('users')
                                    ->where('id', $likesComentario->user_id)
                                    ->first();
                            @endphp

                            @if ($likesComentario->user->imagen)
                                <a class="flex items-center gap-2 mb-2"
                                    href="{{ route('posts.index', $likesComentario->user->username) }}">
                                    <img width="30px" height="30px" class="rounded-full"
                                        src="{{ asset('perfiles') . '/' . $likesComentario->user->imagen }}" alt="Imagen usuario">
                                    <p class="mb-3 text-sm text-gray-500 font-bold">{{ $likesComentario->user->username }}</p>
                                </a>
                            @else
                                <a class="flex items-center gap-2 mb-2"
                                    href="{{ route('posts.index', $likesComentario->user->username) }}">
                                    <img width="30px" height="30px" src="{{ asset('img/usuario.svg') }}"
                                        alt="Imagen usuario">
                                    <p class="mb-3 text-sm text-gray-500 font-bold">{{ $likesComentario->user->username }}</p>
                                </a>
                            @endif
                        @endforeach
                    @endif
                </div>

            </div>
        </div>
    </div>

</div>
