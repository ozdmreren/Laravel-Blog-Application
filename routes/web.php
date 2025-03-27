<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\RegisterUserController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\UserController;
use App\Mail\BlogPosted;
use Illuminate\Support\Facades\Route;


Route::controller(BlogController::class)
->group(function(){
    Route::get('/','home')->name('home');
    Route::get('/search','search');
    Route::post('/','store')->name('blog.store');
});

Route::controller(BlogController::class)
->middleware('auth')
->prefix('/blogs')
->group(function(){
    Route::get('/write','write')->name('write');
    Route::get('/{blog}/edit','edit')->can('edit','blog')->name('blog.edit');
    Route::get('/{blog}','show')->name('blog'); // çakışan rotolar var /write ile
    Route::patch('/{blog}','update')->can('edit','blog');
    Route::delete('/{blog}','delete')->can('edit','blog');
});
// routelere name ekliyordun
Route::controller(UserController::class)
->middleware('auth')
->group(function(){
    Route::get('/users/{user}/library','showLib')->can('validate','user')->name('user.library');
    Route::get('/users/{user}/stories','showStories')->can('validate','user')->name('user.stories');
    Route::post('/blogs/{blog}','add_comment');
    Route::patch('/notifies/{notify}','read_comment');
    // buna da can eklersi
    Route::delete('/comments/{comment}','deleteComment');
    Route::post('/save/{blog}','saveBlog');
});

Route::controller(UserController::class)
->middleware('auth')
->prefix('/profile')
->group(function(){
    Route::get('/{user}','dashboard')->name('dashboard');
    Route::get('/{user}/edit','editProfile')->can('validate','user')->name('profile.edit');
    Route::get('/{user}/security','editSecurity')->can('validate','user')->name('profile.security');
    Route::patch('/{user}/edit','updateProfile')->can('validate','user');
    Route::patch('/{user}/security/email','updateSecurityEmail')->can('validate','user');
    Route::patch('/{user}/security/password','updateSecurityPassword')->can('validate','user');
    Route::patch('/{user}/edit-avatar','updateAvatar')->can('validate','user');
});

Route::controller(RegisterUserController::class)
->prefix('/register')
->group(function(){
    Route::get('/','create')->name('register');
    Route::post('/','store');
});

Route::controller(SessionController::class)
->group(function(){
    Route::get('/login','create')->name('login');
    Route::post('/login','store');
    Route::post('/logout','destroy')->name('logout');
});



// Route::get('/blogs/{blog}',[BlogController::class,'show']);


// can'deki 'blog' parametresi aslında url'deki blog değişkenimizdir.
//Route::get('/blogs/{blog}/edit',[BlogController::class,'edit'])->middleware('auth')->can('edit','blog');
//Route::patch('/blogs/{blog}',[BlogController::class,'update'])->middleware('auth')->can('edit','blog');
//Route::delete('/blogs/{blog}',[BlogController::class,'delete'])->middleware('auth')->can('edit','blog');


// Route::post('/blogs/{blog}',[UserController::class,'add_comment']);
// Route::patch('/notifies/{notify}',[UserController::class,'read_comment']);
// // buna da can eklersin
// Route::delete('/comments/{comment}',[UserController::class,'deleteComment'])->middleware('auth');
// Route::post('/save/{blog}',[UserController::class,'saveBlog'])->middleware('auth');
// Route::get('/users/{user}/library',[UserController::class,'showLib'])->middleware('auth')->can('validate','user');
// Route::get('/users/{user}/stories',[UserController::class,'showStories'])->middleware('auth')->can('validate','user');
// 
// Route::get('/profile/{user}',[UserController::class,'dashboard']);
// Route::get('/profile/{user}/edit',[UserController::class,'editProfile'])->middleware('auth')->can('validate','user');
// Route::get('/profile/{user}/security',[UserController::class,'editSecurity'])->middleware('auth')->can('validate','user');
// Route::patch('/profile/{user}/edit',[UserController::class,'updateProfile'])->middleware('auth')->can('validate','user');
// Route::patch('/profile/{user}/security/email',[UserController::class,'updateSecurityEmail'])->middleware('auth')->can('validate',// 'user');
// Route::patch('/profile/{user}/security/password',[UserController::class,'updateSecurityPassword'])->middleware('auth')->can('validate',// 'user');
// Route::patch('/profile/{user}/edit-avatar',[UserController::class,'updateAvatar'])->middleware('auth')->can('validate','user');


// Route::get('/register',[RegisterUserController::class,'create']);
// Route::post('/register',[RegisterUserController::class,'store']);
// Route::get('/login',[SessionController::class,'create'])->name('login');
// Route::post('/login',[SessionController::class,'store']);
// Route::post('/logout',[SessionController::class,'destroy']);

// Route::get('/search',[BlogController::class,'search']);