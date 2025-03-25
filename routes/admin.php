<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\Admin\AdminLogin;
use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\UserAdminController;
use App\Http\Controllers\Basic\UserLeadsController;
use App\Http\Controllers\Admin\IndividualController;
use App\Http\Controllers\Admin\TechnologyController;


Route::get('/', AdminLogin::class)->name('login')->middleware('guest');


Route::group(['middleware' => ['auth:admin', 'user.active']], function () {
    Route::get('/dashboard', [AdminController::class, 'toAdminDashboard'])->name('dashboard');


    //Technology
    Route::get('/technology', [TechnologyController::class, 'toAdminTechnology'])->name('technology');
    Route::post('/technology', [TechnologyController::class, 'toAdminTechnologyStore']);
    Route::delete('/technology/{id}', [TechnologyController::class, 'toAdminTechnologyDelete'])->name('technology.delete');
    Route::post('/technology/update', [TechnologyController::class, 'toAdminTechnologyUpdate'])->name('technology.update');

    // Companies
    Route::get('/companies', [CompanyController::class, 'toAdminCompanies'])->name('companies');

    Route::get('/companies/import', [AdminController::class, 'tocompanyimport'])->name('companies.import');
    Route::post('/companies/import', [AdminController::class, 'tocompanyimportexcel']);

    // Users
    Route::get('/users', [UserAdminController::class, 'tousers'])->name('users');
    Route::put('/users/{id}', [UserAdminController::class, 'UserUpdate'])->name('users.update');
    Route::delete('user-delete/{id}', [UserAdminController::class, 'UserDelete'])->name('user-delete');
    Route::get('/user/view/{slug}', [UserAdminController::class, 'touserview'])->name('user.view');

    // Individual
    Route::get('/individual', [IndividualController::class, 'toAdminIndividual'])->name('individual');

    //General Leads
    Route::get('/leads', [UserLeadsController::class, 'toAdminLeads'])->name('leads');
    Route::post('leads/update', [UserLeadsController::class, 'toUpdateOrder'])->name('leads.update');


    //Globaly
    Route::get('customer/view/{id}', [AdminController::class, 'toAdminView'])->name('view');
    Route::post('/companies/{store}/toggle-status', [CompanyController::class, 'toggleStatus'])->name('companies.toggleStatus');


    // GetSettings
    Route::get('/settings', [AdminController::class, 'toSettings'])->name('settings');
    Route::post('/settings', [AdminController::class, 'toSettingUpload']);

    // Custom Pages
    Route::get('/custom-pages', [AdminController::class, 'toCustom'])->name('custom-page-all');
    Route::get('/custom-pages/create', [AdminController::class, 'toCustomPage'])->name('custom-page');
    Route::post('/custom-pages/create', [AdminController::class, 'toCustomPageSave']);
    Route::get('/custom-pages/update/{id}', [AdminController::class, 'toCustomPageEdit'])->name('custom-page-edit');
    Route::put('/custom-pages/update/{id}', [AdminController::class, 'toCustomPageUpdate'])->name('custom-page-update');
    Route::delete('custom-pages/delete/{id}', [AdminController::class, 'toCustomPageDelete'])->name('custom-page.delete');



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
