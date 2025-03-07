<?php

use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\User\UserLogin;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\User\UserRegister;
use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\User\UserController;
use App\Livewire\Auth\User\UserForgetPassword;



Route::get('/login', UserLogin::class)->name('login')->middleware('guest');
Route::get('/register', UserRegister::class)->name('register');
Route::get('/forget-password', UserForgetPassword::class)->name('forget.password');


Route::get('/logout', function () {
    Auth::logout(); // Logs out the current user
    request()->session()->invalidate(); // Invalidate the session
    request()->session()->regenerateToken(); // Regenerate the CSRF token for security
    return redirect()->route('login'); // Redirect to the login page (or any other route)
})->name('logout');

Route::get('/', function () {
    return view('welcome');
});
// hello



Route::group(['middleware' => ['auth:web', 'user.active'], 'prefix' => 'user', 'as' => 'user.'], function () {
    Route::get('/dashboard', [UserController::class, 'toUserDashboard'])->name('dashboard');
    Route::get('profile', [UserController::class, 'UserProfile'])->name('profile');
    Route::put('profile', [UserController::class, 'UserProfileUpdate'])->name('profileupdate');
    Route::post('epin-generate', [UserController::class, 'toepingenerate'])->name('epin.generate');
    Route::get('order', [UserController::class, 'Order'])->name('order');
    Route::get('favourites', [UserController::class, 'VisitingCards'])->name('visitingcards');
    Route::delete('favourite/delete/{id}', [UserController::class, 'toDeleteFavourite'])->name('user.favourite');




    // AizUpload
    Route::post('/aiz-uploader', [AizUploadController::class, 'show_uploader']);
    Route::post('/aiz-uploader/upload', [AizUploadController::class, 'upload']);
    Route::get('/aiz-uploader/get_uploaded_files', [AizUploadController::class, 'get_uploaded_files']);
    Route::post('/aiz-uploader/get_file_by_ids', [AizUploadController::class, 'get_preview_files']);
    Route::get('/aiz-uploader/download/{id}', [AizUploadController::class, 'attachment_download'])->name('download_attachment');
});
