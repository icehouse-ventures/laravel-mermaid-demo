<?php

use App\Livewire\UsersDemo;
use App\Livewire\EntitiesDemo;
use App\Livewire\VerbosityDemo;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/basic', 'App\Http\Controllers\BasicExampleController@show');

Route::get('/from-user-model', 'App\Http\Controllers\UserController@show');

Route::get('/livewire-users', UsersDemo::class);

Route::get('/livewire-depth', EntitiesDemo::class);

Route::get('/livewire-verbosity', VerbosityDemo::class);