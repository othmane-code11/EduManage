<?php

use App\Http\Controllers\AccController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\RoleMiddleware;


use App\Http\Controllers\ScheduleController;
Route::get('/', function () {

    return redirect()->route('landing');
});

Route::get('/landing', function () {
    return view('landing');
})->name('landing');

Route::get('/features', function () {
    return view('features');
})->name('features');

Route::get('/pricing', function () {
    return view('pricing');
})->name('pricing');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/blog', function () {
    return view('blog');
})->name('blog');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard/blog', function () {
        return view('blog-dashboard');
    })->name('blog.dashboard');
});

Route::get('/contact', function () {
    return view('contact');
})->name('contact');


// Login
Route::get('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::get('/register', [AuthController::class, 'register'])->middleware('guest')->name('register');
Route::get('/dash', [AuthController::class, 'dash'])
    ->middleware(['auth', 'role:admin'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('profile.update');

    Route::get('/settings', [ProfileController::class, 'settings'])->name('settings');
    Route::put('/settings/password', [ProfileController::class, 'updatePassword'])->name('settings.password.update');
    Route::post('/settings/logout-other-devices', [ProfileController::class, 'logoutOtherDevices'])->name('settings.logout-other-devices');
    Route::delete('/settings/account', [ProfileController::class, 'deleteAccount'])->name('settings.account.delete');
});

Route::middleware(['auth', 'role:formateur,student'])->group(function () {
    Route::get('/absence', [AccController::class, 'absc'])->name('absence');
});

Route::middleware(['auth', 'role:admin,formateur,student'])->group(function () {
    Route::get('/schedule', [AccController::class, 'schedule'])->name('schedule');
});



Route::post('/auth/register', [AuthController::class, 'registerPost'])->name('register.post'); 
Route::post('/auth/login', [AuthController::class, 'loginPost'])->name('login.post'); 



Route::delete('/delete/{id}', [AccController::class, 'delete'])
    ->middleware(['auth', 'role:admin'])
    ->name('delete');

Route::post('/absence/{email}', [AccController::class, 'toggle'])
    ->middleware(['auth', 'role:formateur'])
    ->name('absence.toggle');



//
Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {

    // Admin 
    Route::get('/admin', [AccController::class, 'admin'])
        ->name('admin')
        ->middleware('role:admin');

    // Student 
    Route::get('/student', [AccController::class, 'student'])
        ->name('student')
        ->middleware('role:student');

});


Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/lang/{locale}', function ($locale) {
    if (!in_array($locale, config('app.supported_locales', ['en', 'fr', 'ar']))) {
        $locale = config('app.locale', 'en');
    }

    session(['locale' => $locale]);

    return redirect()->back()->withCookie(cookie()->forever('locale', $locale));
})->name('lang.switch');

// Backward-compatible alias
Route::get('/change-locale/{locale}', function ($locale) {
    return redirect()->route('lang.switch', ['locale' => $locale]);
})->name('change-locale');


/*
|--------------------------------------------------------------------------
| Schedule Routes
|--------------------------------------------------------------------------
| Add these two lines inside your routes/web.php file.
| Both are wrapped in auth middleware so only logged-in users can access them.
*/

Route::middleware(['auth', 'role:admin,formateur'])->group(function () {

    // Show the upload form
    Route::get('/schedules', [ScheduleController::class, 'index'])
         ->name('schedules.index');

    // Handle PDF upload
    Route::post('/schedules/upload', [ScheduleController::class, 'upload'])
         ->name('schedules.upload');

    // Edit schedule title
    Route::put('/schedules/{schedule}', [ScheduleController::class, 'update'])
         ->name('schedules.update');

    // Delete schedule
    Route::delete('/schedules/{schedule}', [ScheduleController::class, 'destroy'])
         ->name('schedules.destroy');

});
// just for testing
Route::get('/test', function () {
    return view('test');
});