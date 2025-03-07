<?php

use App\Livewire\Auth\User\UserLogin;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\User\UserRegister;
use App\Livewire\Auth\User\UserForgetPassword;



Route::get('/login', UserLogin::class)->name('login')->middleware('guest');
Route::get('/register', UserRegister::class)->name('register');
Route::get('/forget-password', UserForgetPassword::class)->name('forget.password');

Route::get('/', function () {
    return view('welcome');
});
// hello
