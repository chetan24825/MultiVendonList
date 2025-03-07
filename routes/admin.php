<?php

use Illuminate\Support\Facades\Route;




Route::get('/login', UserLogin::class)->name('login')->middleware('guest');
