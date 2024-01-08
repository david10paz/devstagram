<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImagenController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\Select2SearchController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

//Chat
Route::get('/chat/{user_emisor}/{user_receptor}', [ChatController::class, 'index'])->name('chat.index');
Route::post('/chat/{user_emisor}/{user_receptor}', [ChatController::class, 'store'])->middleware(['auth'])->name('chat.store');
Route::get('/chats', [ChatController::class, 'lista'])->name('chat.lista');

//Routes search
Route::get('/ajax-autocomplete-search', [Select2SearchController::class, 'selectSearch']);


Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

//Ruta para el perfil
Route::get('/editar-perfil', [PerfilController::class, 'index'])->middleware(['auth'])->name('perfil.index');
Route::post('/editar-perfil', [PerfilController::class, 'store'])->name('perfil.store');


Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/create', [PostController::class, 'create'])->middleware(['auth'])->name('posts.create');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');


Route::post('/{user:username}/posts/{post}', [ComentarioController::class, 'store'])->middleware(['auth'])->name('comentarios.store');
Route::delete('/comentario-delete/{comentario}', [ComentarioController::class, 'destroy'])->middleware(['auth'])->name('comentarios.destroy');

Route::post('/imagenes', [ImagenController::class, 'store'])->middleware(['auth'])->name('imagenes.store');

//Like fotos
Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->middleware(['auth'])->name('posts.likes.store');
Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])->middleware(['auth'])->name('posts.likes.destroy');


//Siguiendo a usuarios
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->middleware(['auth'])->name('users.follow');
Route::post('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->middleware(['auth'])->name('users.unfollow');
Route::post('/{user:username}/solicitar-follow', [FollowerController::class, 'solicitar_follow'])->middleware(['auth'])->name('users.solicitar-follow');
Route::get('/{user:username}/confirm-follow', [FollowerController::class, 'show_confirmar_follow'])->middleware(['user.privado'])->name('users.show-confirmar-follow');
Route::post('/{user:username}/confirm-follow', [FollowerController::class, 'confirmar_follow'])->middleware(['auth'])->name('users.confirmar-follow');
