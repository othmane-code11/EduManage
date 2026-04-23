<?php

use App\Http\Controllers\AccController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Middleware\RoleMiddleware;


use App\Http\Controllers\ScheduleController;
Route::get('/', function () {

    return redirect()->route('landing');
});

Route::get('/landing', function () {
    return view('landing');
})->name('landing');


// Login
Route::get('/login', [AuthController::class, 'login'])->middleware('guest')->name('login');
Route::get('/register', [AuthController::class, 'register'])->middleware('guest')->name('register');
Route::get('/dash', [AuthController::class, 'dash'])
    ->middleware('role:admin,student')
    ->name('dashboard');

Route::get('/absence', [AccController::class, 'absc'])->name('absence');
Route::get('/schedule', [AccController::class, 'schedule'])->name('schedule');



Route::post('/auth/register', [AuthController::class, 'registerPost'])->name('register.post'); 
Route::post('/auth/login', [AuthController::class, 'loginPost'])->name('login.post'); 



Route::delete('/delete/{id}', [AccController::class, 'delete'])->name('delete');

Route::post('/absence/{email}', [AccController::class, 'toggle'])->name('absence.toggle');



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


/*
|--------------------------------------------------------------------------
| Schedule Routes
|--------------------------------------------------------------------------
| Add these two lines inside your routes/web.php file.
| Both are wrapped in auth middleware so only logged-in users can access them.
*/

Route::middleware(['auth', 'role:formateur'])->group(function () {

    // Show the upload form
    Route::get('/schedules', [ScheduleController::class, 'index'])
         ->name('schedules.index');

    // Handle PDF upload
    Route::post('/schedules/upload', [ScheduleController::class, 'upload'])
         ->name('schedules.upload');

});
// just for testing
Route::get('/test', function () {
    return view('test');
});