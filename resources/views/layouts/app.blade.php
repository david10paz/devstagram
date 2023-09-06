<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Devstagram - @yield('titulo')</title>

    @stack('styles')

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

    @livewireStyles

</head>

<body class="bg-gray-100">
    <header class="p-5 border-b bg-white shadow">
        <div class="container mx-auto flex justify-between items-center">
            <div class="md:w-1/2">
                <a href="/">
                    <h1 class="text-3xl font-black">Devstagram</h1>
                </a>
            </div>

            <div class="md:w-1/2">

                @auth
                    <nav class="flex gap-6 items-center">
                        <a href="{{ route('posts.create') }}"
                            class="flex items-center gap-2 bg-white border p-2 text-gray-600 rounded text-sm uppercase font-bold cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="w-6 h-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M6.827 6.175A2.31 2.31 0 015.186 7.23c-.38.054-.757.112-1.134.175C2.999 7.58 2.25 8.507 2.25 9.574V18a2.25 2.25 0 002.25 2.25h15A2.25 2.25 0 0021.75 18V9.574c0-1.067-.75-1.994-1.802-2.169a47.865 47.865 0 00-1.134-.175 2.31 2.31 0 01-1.64-1.055l-.822-1.316a2.192 2.192 0 00-1.736-1.039 48.774 48.774 0 00-5.232 0 2.192 2.192 0 00-1.736 1.039l-.821 1.316z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.5 12.75a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0zM18.75 10.5h.008v.008h-.008V10.5z" />
                            </svg>
                            Crear
                        </a>
                        <!--  href="/{{ auth()->user()->username }}" SE PODRÍA PONER ASÍ-->
                        <a href="{{ route('posts.index', auth()->user()->username) }}"
                            class="font-bold text-gray-600 text-sm">Hola: <span
                                class="text-blue-700">{{ auth()->user()->username }}</span></a>


                        <div class="md:w-2/5">
                            <select
                                class="livesearch bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                name="livesearch"></select>
                        </div>


                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="font-bold uppercase text-gray-600 text-sm">Cerrar sesión</button>
                        </form>
                    </nav>
                @endauth

                @guest
                    <nav class="flex gap-3 items-center">
                        <a href="{{ route('login') }}" class="font-bold uppercase text-gray-600 text-sm">Login</a>
                        <a href="{{ route('register') }}" class="font-bold uppercase text-gray-600 text-sm">Crear cuenta</a>
                    </nav>
                @endguest
            </div>

        </div>
    </header>

    <main class="container mx-auto mt-10">
        <h2 class="font-black text-center text-3xl mb-10">@yield('titulo')</h2>
        @yield('contenido')
    </main>

    <footer class="text-center p-5 text-gray-500 font-bold uppercase mt-10">
        Devstagram David Díez Paz - Todos los derechos reservados {{ now()->year }}
    </footer>

    @livewireScripts

</body>

<script type="text/javascript">
    $('.livesearch').select2({
        placeholder: '¡Busca un usuario para seguir!',
        ajax: {
            url: '/ajax-autocomplete-search',
            dataType: 'json',
            delay: 250,
            processResults: function(data) {
                return {

                    results: $.map(data, function(item) {
                        return {
                            text: item.username,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });

    $('.livesearch').on('select2:select', function(e) {
        var data = e.params.data.text;
        //console.log(data);
        window.location.replace('http://devstagram.test/' + data);
    });
</script>

</html>
