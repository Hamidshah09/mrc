<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\domicileController;
use App\Http\Controllers\idpController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MrcController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return redirect()->route('dashboard');
    return view('welcome');
});

Route::get('/mrc/info', function(){
            return view('mrc.info');
        })->name('mrc.info');
Route::get('/mrc/divorce-info', function(){
            return view('mrc.divorce-info');
        })->name('drc.info');        

Route::get('/idp/info', function(){
            return view('idp.info');
        })->name('idp.info');
Route::get('/arms/info', function(){
            return view('arms.info');
        })->name('arms.info');
Route::get('/birth/info', function(){
            return view('birth.info');
        })->name('birth.info');

Route::post('/mrc/check', [MrcController::class, 'check'])->name('mrc.check');
Route::post('/domicile/check', [domicileController::class, 'apiCheck'])->name('domicile.check');
Route::get('/inactive', function () {
    return view('auth.inactive');
})->name('inactive');
Route::controller(idpController::class)->group(function () {
    Route::get('/idp/create', 'create')->name('idp.create');
    Route::post('/idp/store', 'store')->name('idp.store');
    Route::get('/idp/edit/{id}/{cnic}', 'edit')->name('idp.edit');
    Route::post('/idp/update/{id}', 'update')->name('idp.update');
    Route::get('/idp/success/{id}/{cnic}', 'success')->name('idp.success');
});
Route::controller(domicileController::class)->group(function () {
    Route::get('/domicile/noc/success/{id}', 'noc_success')->name('noc.success');
    Route::get('/domicile/success/{id}/{cnic}', 'domicile_success')->name('domicile.success');        
    Route::get('/domicile/noc', 'show_noc')->name('noc.show');
    Route::get('/domicile/noc/create', 'create_noc')->name('noc.create');
    Route::post('/domicile/noc/store', 'store_noc')->name('noc.store');
    Route::get('/domicile', 'dom_index')->name('domicile.index');
    Route::get('/domicile/tehsils', 'dom_tehsils')->name('domicile.tehsils');
    Route::get('/domicile/districts', 'dom_districts')->name('domicile.districts');
    
    Route::get('/domicile/info', function(){
        return view('domicile.info');
    })->name('domicile.info');
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
    Route::get('/admin/downloads', [AdminController::class, 'downloads'])->name('downloads');
    
    Route::get('/dashboard', [MrcController::class, 'index'])->name('dashboard');
    Route::post('/mrc/store', [MrcController::class, 'store'])->name('mrc.store');
    Route::get('/mrc/create', [MrcController::class, 'create'])->name('mrc.create');
    Route::get('/mrc/edit/{id}', [MrcController::class, 'edit'])->name('mrc.edit')->middleware('owner');
    Route::put('/mrc/{id}', [MrcController::class, 'update'])->name('mrc.update');
    Route::get('/mrc/{id}', [MrcController::class, 'show'])->name('mrc.show');
    Route::put('/mrc/verify/{id}', [MrcController::class, 'verify'])->name('mrc.verify')->middleware('admin');
    Route::get('/mrc/file/upload', [MrcController::class, 'upload_'])->name('mrc.upload');
    Route::post('/mrc/import', [MrcController::class, 'import'])->name('mrc.import');
    

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
