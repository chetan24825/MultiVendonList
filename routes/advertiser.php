<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Advertiser\AdvertiserLogin;
use App\Livewire\Auth\Advertiser\AdvertiserRegister;
use App\Livewire\Auth\Advertiser\AdvertiserForgetPassword;


Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', AdvertiserLogin::class)->name('login');
    Route::get('/register', AdvertiserRegister::class)->name('register');
    Route::get('/forget-password', AdvertiserForgetPassword::class)->name('forget.password');
});
