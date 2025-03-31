<?php

use Illuminate\Support\Facades\Auth;
use App\Livewire\Auth\User\UserLogin;
use Illuminate\Support\Facades\Route;
use App\Livewire\Auth\User\UserRegister;
use App\Http\Controllers\AizUploadController;
use App\Http\Controllers\Ajax\AjaxController;
use App\Http\Controllers\Site\SiteController;
use App\Http\Controllers\User\UserController;
use App\Livewire\Auth\User\UserForgetPassword;

$customSlug = get_setting('custom_slug');

Route::get('/', [SiteController::class, 'index'])->name('site.index');
Route::get('/state', [SiteController::class, 'toState'])->name('state');


// Route::get("/$customSlug/others/{plumber}", [SiteController::class, 'toPlumberFeatured'])->name('plumber.other');
Route::get("/$customSlug/{id}", [SiteController::class, 'tostatecity'])->name('states.city');
Route::get("/$customSlug/{country}/{city}", [SiteController::class, 'toStateCityUser'])->name('country.city');
Route::get("/$customSlug/{country?}/{city?}/{plumber?}", [SiteController::class, 'toStateCityUserPlumber'])->name('country.city.plumber');

Route::post("lead/submit", [SiteController::class, 'toLeadStore'])->name('leads');


// AJAX Route
Route::get('/ajax/get-cities/{id}', [AjaxController::class, 'togetCity'])->name('ajax.get-cities');
Route::get("/ajax/{country}/{city}", [AjaxController::class, 'toStateCityUser'])->name('ajax.country-city');


Route::get('/login', UserLogin::class)->name('login')->middleware('guest');
Route::get('/register', UserRegister::class)->name('register');
Route::get('/forget-password', UserForgetPassword::class)->name('forget.password');


Route::get('/logout', function () {
    Auth::logout(); // Logs out the current user
    request()->session()->invalidate(); // Invalidate the session
    request()->session()->regenerateToken(); // Regenerate the CSRF token for security
    return redirect()->route('site.index'); // Redirect to the login page (or any other route)
})->name('logout');

// Route::get('/', function () {
//     return view('welcome');
// });
// hello



Route::group(['middleware' => ['auth:web', 'user.active'], 'prefix' => 'user', 'as' => 'user.'], function () {
    //Dashboard
    Route::get('/dashboard', [UserController::class, 'toUserDashboard'])->name('dashboard');

    //Profile
    Route::get('profile', [UserController::class, 'UserProfile'])->name('profile');
    Route::put('profile', [UserController::class, 'UserProfileUpdate'])->name('profileupdate');
    Route::post('/change-password', [UserController::class, 'toChangePassword'])->name('password');

    Route::post('epin-generate', [UserController::class, 'toepingenerate'])->name('epin.generate');

    Route::get('order', [UserController::class, 'Order'])->name('order');
    Route::post('order', [UserController::class, 'toStoreOrder']);
    Route::post('order/update', [UserController::class, 'toUpdateOrder'])->name('order.update');

    Route::get('favourites', [UserController::class, 'VisitingCards'])->name('visitingcards');
    Route::delete('favourite/delete/{id}', [UserController::class, 'toDeleteFavourite'])->name('user.favourite');




    // AizUpload
    Route::post('/aiz-uploader', [AizUploadController::class, 'show_uploader']);
    Route::post('/aiz-uploader/upload', [AizUploadController::class, 'upload']);
    Route::get('/aiz-uploader/get_uploaded_files', [AizUploadController::class, 'get_uploaded_files']);
    Route::post('/aiz-uploader/get_file_by_ids', [AizUploadController::class, 'get_preview_files']);
    Route::get('/aiz-uploader/download/{id}', [AizUploadController::class, 'attachment_download'])->name('download_attachment');
});
