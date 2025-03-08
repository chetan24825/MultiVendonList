<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AizUploadController;
use App\Livewire\Auth\Advertiser\AdvertiserLogin;
use App\Livewire\Auth\Advertiser\AdvertiserRegister;
use App\Livewire\Auth\Verification\CustomerVerification;
use App\Http\Controllers\Advertiser\AdvertiserController;
use App\Livewire\Auth\Advertiser\AdvertiserForgetPassword;


Route::group(['middleware' => 'guest'], function () {
    Route::get('/login', AdvertiserLogin::class)->name('login');
    Route::get('/register', AdvertiserRegister::class)->name('register');
    Route::get('/forget-password', AdvertiserForgetPassword::class)->name('forget.password');
    Route::get('/verification/{id}/details', CustomerVerification::class)->name('verification');
});



Route::group(['middleware' => ['auth:advertiser', 'user.active', 'profile.registration']], function () {

    //Advertiser
    Route::get('/dashboard', [AdvertiserController::class, 'toAdvertiserDashboard'])->name('dashboard');

    //Profile
    Route::get('/profile', [AdvertiserController::class, 'toAdvertiserprofile'])->name('profile');
    Route::post('/profile', [AdvertiserController::class, 'toAdvertiserprofileUpdate']);

    // AizUpload
    Route::post('/aiz-uploader', [AizUploadController::class, 'show_uploader']);
    Route::post('/aiz-uploader/upload', [AizUploadController::class, 'upload']);
    Route::get('/aiz-uploader/get_uploaded_files', [AizUploadController::class, 'get_uploaded_files']);
    Route::post('/aiz-uploader/get_file_by_ids', [AizUploadController::class, 'get_preview_files']);
    Route::get('/aiz-uploader/download/{id}', [AizUploadController::class, 'attachment_download'])->name('download_attachment');

    // Upload
    Route::any('/uploaded-files/file-info', [AizUploadController::class, 'file_info'])->name('uploaded-files.info');
    Route::resource('/uploaded-files', AizUploadController::class);
    Route::get('/uploaded-files/destroy/{id}', [AizUploadController::class, 'destroy'])->name('uploaded-files.destroy1');
});
