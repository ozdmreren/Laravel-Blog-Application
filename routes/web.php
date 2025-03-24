<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;


Route::controller(BlogController::class)->group(function(){
    Route::get('/','home');
    Route::post('/','store');
});


Route::get('/blogs/write',[BlogController::class,'write'])->middleware('auth');
Route::get('/blogs/{blog}',[BlogController::class,'show']);
// can'deki 'blog' parametresi aslında url'deki blog değişkenimizdir.
Route::get('/blogs/{blog}/edit',[BlogController::class,'edit'])->middleware('auth')->can('edit','blog');
Route::patch('/blogs/{blog}',[BlogController::class,'update'])->middleware('auth')->can('edit','blog');
Route::delete('/blogs/{blog}',[BlogController::class,'delete'])->middleware('auth')->can('edit','blog');
Route::post('/blogs/{blog}',[UserController::class,'add_comment']);
Route::patch('/notifies/{notify}',[UserController::class,'read_comment']);
// buna da can eklersin
Route::delete('/comments/{comment}',[UserController::class,'deleteComment'])->middleware('auth');
Route::post('/save/{blog}',[UserController::class,'saveBlog'])->middleware('auth');
Route::get('/users/{user}/library',[UserController::class,'showLib'])->middleware('auth')->can('validate','user');
Route::get('/users/{user}/stories',[UserController::class,'showStories'])->middleware('auth')->can('validate','user');

Route::get('/profile/{user}',[UserController::class,'dashboard']);
Route::get('/profile/{user}/edit',[UserController::class,'editProfile'])->middleware('auth')->can('validate','user');
Route::get('/profile/{user}/security',[UserController::class,'editSecurity'])->middleware('auth')->can('validate','user');
Route::patch('/profile/{user}/edit',[UserController::class,'updateProfile'])->middleware('auth')->can('validate','user');
Route::patch('/profile/{user}/security/email',[UserController::class,'updateSecurityEmail'])->middleware('auth')->can('validate','user');
Route::patch('/profile/{user}/security/password',[UserController::class,'updateSecurityPassword'])->middleware('auth')->can('validate','user');
Route::patch('/profile/{user}/edit-avatar',[UserController::class,'updateAvatar'])->middleware('auth')->can('validate','user');

Route::get('/register',[RegisterUserController::class,'create']);
Route::post('/register',[RegisterUserController::class,'store']);
Route::get('/login',[SessionController::class,'create'])->name('login');
Route::post('/login',[SessionController::class,'store']);
Route::post('/logout',[SessionController::class,'destroy']);

Route::get('/search',[BlogController::class,'search']);