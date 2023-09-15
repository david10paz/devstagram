@extends('layouts.app')


@section('titulo')
    Editar perfil: {{ auth()->user()->username }}
@endsection

@section('contenido')
    <div class="md:flex md:justify-center">
        <div class="md:w-1/2 bg-white shadow p-6">
            <form class="mt-10 md:mt-10" method="POST" action="{{ route('perfil.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">Username</label>
                    <input type="text" id="username" name="username" placeholder="Tu nombre de usuario"
                        class="border p-3 w-full rounded-lg @error('username') border-red-500 @enderror"
                        value="{{ auth()->user()->username }}" />
                    @error('username')
                        <p class="bg-red-500 text-white rounded-lg text-sm text-center p-2 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="username" class="mb-2 block uppercase text-gray-500 font-bold">Tipo de cuenta</label>
                    <select id="tipo_cuenta" name="tipo_cuenta"
                        class="w-full rounded-md shadow-sm focus:border-indigo-300 focus:ring 
                        focus:ring-indigo-200 focus:ring-opacity-50  @error('tipo_cuenta') border-red-500 @enderror">
                        <option value="1">Privada</option>
                        <option value="0">Pública</option>
                    </select>
                    @error('tipo_cuenta')
                        <p class="bg-red-500 text-white rounded-lg text-sm text-center p-2 mt-2">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="imagen" class="mb-2 block uppercase text-gray-500 font-bold">Imagen perfil</label>
                    <input type="file" id="imagen" name="imagen" class="border p-3 w-full rounded-lg"
                        accept=".jpg, .jpeg, .png" />
                </div>

                <input type="submit" value="Guardar cambios"
                    class="bg-sky-700 transition-colors cursor-pointer uppercase font-bold w-full p-3 text-white rounded-lg" />
            </form>
        </div>
    </div>
@endsection
