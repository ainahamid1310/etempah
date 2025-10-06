<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/user_public', 'PublicUserController@index');
Route::get('/user_public/create', 'PublicUserController@create');
Route::post('/user_public/create', 'PublicUserController@store');
Route::post('/', 'PublicUserController@store');
