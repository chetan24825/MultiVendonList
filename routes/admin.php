<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Admin\AdminLogin;
use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\Admin\AdminController;


Route::get('/', AdminLogin::class)->name('login')->middleware('guest');


Route::group(['middleware' => ['auth:admin', 'user.active']], function () {
    Route::get('/dashboard', [AdminController::class, 'toAdminDashboard'])->name('dashboard');

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
