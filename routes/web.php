<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CardController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [PostController::class, 'home'])->name('home')->middleware(['auth:sanctum', 'verified']);
Route::post('/home', [PostController::class, 'home'])->name('mypost')->middleware(['auth:sanctum', 'verified']);

Route::resource('posts', PostController::class)->middleware(['auth:sanctum', 'verified']);

Route::post('/likes', [LikeController::class, 'store'])->name('likes.store')->middleware(['auth:sanctum', 'verified']);
Route::delete('/likes/{likes}', [LikeController::class, 'destroy'])->name('likes.destroy')->middleware(['auth:sanctum', 'verified']);

Route::get('/posts/{post}/comments', [CommentController::class, 'index'])->name('comment.index')->middleware(['auth:sanctum', 'verified']);
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comment.store')->middleware(['auth:sanctum', 'verified']);
Route::put('/comments/{comments}/edit', [CommentController::class, 'index'])->name('comment.update')->middleware(['auth:sanctum', 'verified']);
Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy')->middleware(['auth:sanctum', 'verified']);

// resource auto
Route::resource('card', CardController::class)->middleware(['auth:sanctum', 'verified']);