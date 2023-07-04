@extends('layouts.app')


@section('titulo')
    Regístrate en Devstagram
@endsection

@section('contenido')
    <div class="md:flex md:justify-center md:gap-10">
        <div class="md:w-6/12 p-5 md:items-center">
            <img src="{{ asset('img/registrar.jpg') }}" alt="Imagen Registro" />
        </div>
        <div class="md:w-4/12 bg-white p-6 rounded-lg shadow-xl">
            <form action="/register" method="POST" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="name" class="mb-2 block uppercase text-gray-500 font-bold">Nombre</label>
                    <input type="text" id="name" name="name" placeholder="Tu nombre"
                        class="border p-3 w-full rounded-lg @error('name') border-red-500 @enderror" value="{{old('name')}}" />
                    @error('name')
                    <p class="bg-red-500 text-white rounded-lg text-sm text-center p-2 mt-2">{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">Username</label>
                    <input type="text" id="username" name="username" placeholder="Tu nombre de usuario"
                        class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror" value="{{old('username')}}" />
                        @error('username')
                    <p class="bg-red-500 text-white rounded-lg text-sm text-center p-2 mt-2">{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="mb-2 block uppercase text-gray-500 font-bold">Email</label>
                    <input type="text" id="email" name="email" placeholder="Tu email de registro"
                        class="border p-3 w-full rounded-lg @error('email') border-red-500 @enderror" value="{{old('email')}}" />
                        @error('email')
                    <p class="bg-red-500 text-white rounded-lg text-sm text-center p-2 mt-2">{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password" class="mb-2 block uppercase text-gray-500 font-bold">Password</label>
                    <input type="text" id="password" name="password" placeholder="Tu password de registro"
                        class="border p-3 w-full rounded-lg @error('password') border-red-500 @enderror" />
                        @error('password')
                    <p class="bg-red-500 text-white rounded-lg text-sm text-center p-2 mt-2">{{$message}}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="mb-2 block uppercase text-gray-500 font-bold">Repetir
                        password</label>
                    <input type="text" id="password_confirmation" name="password_confirmation"
                        placeholder="Repite tu password de registro" class="border p-3 w-full rounded-lg" />
                </div>

                <input type="submit" value="Crear cuenta"
                    class="bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" />
            </form>
        </div>
    </div>
@endsection
