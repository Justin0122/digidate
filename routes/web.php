<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    '2faEnabled',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('profile/{user?}', [ProfileController::class, 'show'])->name('user.profile')->middleware('auth');

    Route::get('/audit-trail', function () {
        return view('audittrail');
    })->name('audit-trail');

    Route::get('/messages', function () {
        $receiver = auth()->user()->matches()->first()?->likeable;

        return view('messages', compact('receiver'));
    })->name('messages');
});
