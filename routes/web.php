<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\domicileController;
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
Route::controller(domicileController::class)->group(function () {
    Route::get('/domicile/noc/success/{id}', 'noc_success')->name('noc.success');
    Route::get('/domicile/success/{id}/{cnic}', 'domicile_success')->name('domicile.success');        
    Route::get('/domicile/noc', 'show_noc')->name('noc.show');
    Route::get('/domicile/noc/create', 'create_noc')->name('noc.create');
    Route::post('/domicile/noc/store', 'store_noc')->name('noc.store');
    Route::get('/domicile', 'dom_index')->name('domicile.index');
    
    Route::get('/domicile/create', 'create_new')->name('domicile.create');
    Route::post('/domicile/store', 'store_new')->name('domicile.store');
    Route::get('/domicile/edit/{id}/{cnic}', 'dom_edit')->name('domicile.edit');
    Route::post('/domicile/update/{id}', 'dom_update')->name('domicile.update');
    Route::get('/domicile/show', 'show_domicile')->name('domicile.show');
    Route::get('/domicile/form-p/{id}', 'form_p')->name('domicile.form_p');

    });
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/domicile/admin', [domicileController::class, 'admin_index'])->name('domicile.admin');
    Route::get('/domicile/form-p/{id}', [domicileController::class,'form_p'])->name('domicile.form_p');
    Route::get('/admin/generate-passcodes/create', [AdminController::class, 'create'])->name('Passcode.create');
    Route::post('/admin/generate-passcodes/store', [AdminController::class, 'store'])->name('Passcode.store');
    Route::get('/admin/passcodes/gen-report', [AdminController::class, 'gen_report'])->name('Passcodes.gen_report');
    Route::post('/admin/passcodes/report', [AdminController::class, 'report'])->name('Passcodes.report');
    
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
