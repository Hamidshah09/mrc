<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MrcController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});
Route::get('/inactive', function () {
    return view('auth.inactive');
})->name('inactive');

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [MrcController::class, 'index'])->name('dashboard');
    Route::post('/mrc/store', [MrcController::class, 'store'])->name('mrc.store');
    Route::get('/mrc/create', [MrcController::class, 'create'])->name('mrc.create');
    Route::get('/mrc/edit/{id}', [MrcController::class, 'edit'])->name('mrc.edit')->middleware('owner');
    Route::put('/mrc/{id}', [MrcController::class, 'update'])->name('mrc.update');
    Route::get('/mrc/{id}', [MrcController::class, 'show'])->name('mrc.show');
    Route::put('/mrc/verify/{id}', [MrcController::class, 'verify'])->name('mrc.verify')->middleware('admin');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::controller(RegisteredUserController::class)->group(function () {
        Route::get('/users', 'index')->name('users.index')->middleware('admin');
        Route::get('/users/create', 'create')->name('users.create')->middleware('admin');
        Route::post('/users/store', 'store')->name('users.store')->middleware('admin');
        Route::get('/users/edit/{id}', 'edit')->name('users.edit')->middleware('admin');
        Route::put('/users/{id}', 'update')->name('users.update')->middleware('admin');

    });
});
require __DIR__.'/auth.php';
