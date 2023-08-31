@extends('layouts.app')


@section('titulo')
    Inicia sesión en Devstagram
@endsection

@section('contenido')
    <div class="md:flex md:justify-center md:gap-10">
        <div class="md:w-6/12 p-5 md:items-center">
            <img src="{{ asset('img/login.jpg') }}" alt="Imagen Login" />
        </div>
        <div class="md:w-4/12 bg-white p-6 rounded-lg shadow-xl">
            <form action="{{ route('login') }}" method="POST" novalidate>
                @csrf

                @if (session('mensaje'))
                    <p class="bg-red-500 text-white rounded-lg text-sm text-center p-2 mt-2 mb-2">{{ session('mensaje') }}
                    </p>
                @endif

                <div class="mb-3">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">Email</label>
                    <input type="text" id="email" name="email" placeholder="Tu email de registro"
                        class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror"
                        value="{{ old('email') }}" />
                    @error('email')
                        <p class="bg-red-500 text-white rounded-lg text-sm text-center p-2 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">Password</label>
                    <input type="password" id="password" name="password" placeholder="Tu password de registro"
                        class="border p-3 w-full rounded-lg @error('password') border-red-500 @enderror" />
                    @error('password')
                        <p class="bg-red-500 text-white rounded-lg text-sm text-center p-2 mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-3">
                    <input type="checkbox" name="remember"><label class="text-gray-500 ml-3">Mantener mi sesión abierta</label>
                </div>

                <input type="submit" value="Iniciar sesión"
                    class="bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" />

                
            </form>
        </div>
    </div>
@endsection
