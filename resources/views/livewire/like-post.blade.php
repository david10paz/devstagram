<div class="flex gap-4">
    <button wire:click='like'>
        <svg xmlns="http://www.w3.org/2000/svg" fill="{{ $isLiked ? 'red' : 'white' }}" viewBox="0 0 24 24"
            stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="M6.633 10.5c.806 0 1.533-.446 2.031-1.08a9.041 9.041 0 012.861-2.4c.723-.384 1.35-.956 1.653-1.715a4.498 4.498 0 00.322-1.672V3a.75.75 0 01.75-.75A2.25 2.25 0 0116.5 4.5c0 1.152-.26 2.243-.723 3.218-.266.558.107 1.282.725 1.282h3.126c1.026 0 1.945.694 2.054 1.715.045.422.068.85.068 1.285a11.95 11.95 0 01-2.649 7.521c-.388.482-.987.729-1.605.729H13.48c-.483 0-.964-.078-1.423-.23l-3.114-1.04a4.501 4.501 0 00-1.423-.23H5.904M14.25 9h2.25M5.904 18.75c.083.205.173.405.27.602.197.4-.078.898-.523.898h-.908c-.889 0-1.713-.518-1.972-1.368a12 12 0 01-.521-3.507c0-1.553.295-3.036.831-4.398C3.387 10.203 4.167 9.75 5 9.75h1.053c.472 0 .745.556.5.96a8.958 8.958 0 00-1.302 4.665c0 1.194.232 2.333.654 3.375z" />
        </svg>
    </button>
    <p><span class="font-bold items-center">{{ $contLikes }}</span> likes</p>
    <p>
        <button data-modal-target="modalLikesUsuarios" data-modal-toggle="modalLikesUsuarios"
            class="block text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            type="button">
            ¿Que usuarios dieron like?
        </button>
    </p>


    <!-- Main modal -->
    <div id="modalLikesUsuarios" data-modal-backdrop="static" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        Usuarios que dieron like
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="modalLikesUsuarios">
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
                    @if ($post->likes->count() <= 0)
                        <p class="text-gray-400 uppercase text-sm text-center font-bold">No hay likes todavía :(</p>
                    @else
                        @foreach ($post->likes as $likes)
                            @php
                                //Esto sería una manera de sacarlo, pero vamos a hacerlo por una funcion del modelo de Like
                                //Si no sería llamar a $user_likes->username
                                $user_likes = DB::table('users')
                                    ->where('id', $likes->user_id)
                                    ->first();
                            @endphp

                            @if ($likes->user->imagen)
                                <a class="flex items-center gap-2 mb-2"
                                    href="{{ route('posts.index', $likes->user->username) }}">
                                    <img width="30px" height="30px" class="rounded-full"
                                        src="{{ asset('perfiles') . '/' . $likes->user->imagen }}" alt="Imagen usuario">
                                    <p class="mb-3 text-sm text-gray-500 font-bold">{{ $likes->user->username }}</p>
                                </a>
                            @else
                                <a class="flex items-center gap-2 mb-2"
                                    href="{{ route('posts.index', $likes->user->username) }}">
                                    <img width="30px" height="30px" src="{{ asset('img/usuario.svg') }}"
                                        alt="Imagen usuario">
                                    <p class="mb-3 text-sm text-gray-500 font-bold">{{ $likes->user->username }}</p>
                                </a>
                            @endif
                        @endforeach
                    @endif
                </div>

            </div>
        </div>
    </div>

</div>
