<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArmsController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DesignationController;
use App\Http\Controllers\domicileController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\FinanceController;
use App\Http\Controllers\MrcController;
use App\Http\Controllers\MrcStatusController;
use App\Http\Controllers\OnlineApplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\idpController;
use App\Models\ApplicationType;
use App\Models\OnlineApplication;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/about', function () {
    return view('about');
})->name('about');
Route::get('/chatbot/ask', [ChatController::class, 'ask'])->name('chatbot.ask');
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
Route::get('/birth-info', function(){
            return view('birth.info');
        })->name('birth.info');

Route::post('/idp/check', [idpController::class, 'check'])->name('idp.check');
Route::post('/mrc/check', [MrcController::class, 'check'])->name('mrc.check');
Route::post('/domicile/check', [domicileController::class, 'apiCheck'])->name('domicile.check');
Route::get('/statistics/check', [domicileController::class, 'get_statistics'])->name('statistics.check');
Route::get('/inactive', function () {
    return view('auth.inactive');
})->name('inactive');
Route::controller(idpController::class)->group(function () {
    Route::get('/idp/show', 'show')->name('idp.show');
    Route::get('/idp', 'index')->name('idp.index');
    Route::post('/idp/update/{id}', 'update')->name('idp.update');
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

Route::middleware('auth')->group(function () {

    Route::controller(OnlineApplicationController::class)->group(function(){
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        Route::get('/hcg/noc-events/create', 'noc_events_create')->name('hcg.noc_events.create');
        Route::get('/hcg/noc-fuel/create', 'noc_fuel_create')->name('hcg.noc_fuel.create');
        Route::get('/hcg/l7/create', 'l7_create')->name('hcg.l7.create');
        Route::get('/alc/l4/create', 'l4_create')->name('alc.l4.create');
        Route::get('/domicile/noc-to-other-district/create', 'noc_to_other_district_create')->name('noc.other_district.create');
        Route::get('/online-application/show/{id}', 'online_application_show')->name('online.application.show');
        Route::post('/domicile/noc-to-other-district/store', 'noc_to_other_district_store')->name('noc.other_district.store');
    });
    
    
    Route::get('/domicile/admin', [domicileController::class, 'admin_index'])->name('domicile.admin');
    Route::get('/domicile/form-p/{id}', [domicileController::class,'form_p'])->name('domicile.form_p');
    
    
    
    Route::get('/admin/generate-passcodes/create', [AdminController::class, 'create'])->name('Passcode.create');
    Route::post('/admin/generate-passcodes/store', [AdminController::class, 'store'])->name('Passcode.store');
    Route::get('/admin/passcodes/gen-report', [AdminController::class, 'gen_report'])->name('Passcodes.gen_report');
    Route::post('/admin/passcodes/report', [AdminController::class, 'report'])->name('Passcodes.report');
    Route::get('/admin/downloads', [AdminController::class, 'downloads'])->name('downloads');

    Route::middleware('role:arms,admin')->group(function(){
        Route::get('/arms', [ArmsController::class, 'index'])->name('arms.index');
        Route::get('/arms/edit/{id}', [ArmsController::class, 'edit'])->name('arms.edit');
        Route::put('/arms/update/{id}', [ArmsController::class, 'update'])->name('arms.update');
        Route::get('/arms/approve/{id}', [ArmsController::class, 'approve'])->name('arms.approve');
        Route::get('/arms/deliver/{id}', [ArmsController::class, 'deliver'])->name('arms.deliver');
        Route::get('/arms/trash/{id}', [ArmsController::class, 'trash'])->name('arms.trash');
        Route::get('/arms/approve/all', [ArmsController::class, 'approveall'])->name('arms.approveall');
        Route::get('/arms/trash/all', [ArmsController::class, 'trashall'])->name('arms.trashall');
        Route::get('/arms/pdf-report', [ArmsController::class, 'pdf_report'])->name('arms.pdf');
    });
    
    Route::middleware('role:admin,domicile,idp,arms')->group(function(){
        Route::get('/statistics/pdf-report', [StatisticsController::class, 'pdf_report'])->name('statistics.pdf');
        Route::get('/statistics', [StatisticsController::class, 'index'])->name('statistics.index');
        Route::post('/statistics/upsert', [StatisticsController::class, 'upsert'])->name('statistics.upsert');
        Route::get('/statistics/create', [StatisticsController::class, 'create'])->name('statistics.create');
        Route::post('/statistics/store', [StatisticsController::class, 'store'])->name('statistics.store');
    });
    
    Route::get('/mrc', [MrcController::class, 'index'])->name('mrc.index')->middleware('role:mrc,admin,registrar,verifier');
    Route::post('/mrc/store', [MrcController::class, 'store'])->name('mrc.store')->middleware('role:mrc,admin,registrar,verifier');
    Route::get('/mrc/create', [MrcController::class, 'create'])->name('mrc.create')->middleware('role:mrc,admin,registrar,verifier');
    Route::get('/mrc/edit/{id}', [MrcController::class, 'edit'])->name('mrc.edit')->middleware('owner');
    Route::put('/mrc/{id}', [MrcController::class, 'update'])->name('mrc.update')->middleware('role:mrc,admin,registrar,verifier');
    Route::put('/mrc/verify/{id}', [MrcController::class, 'verify'])->name('mrc.verify')->middleware('role:verifier,admin');;
    Route::get('/mrc/file/upload', [MrcController::class, 'upload_'])->name('mrc.upload')->middleware('role:mrc,admin,registrar,verifier');
    Route::post('/mrc/import', [MrcController::class, 'import'])->name('mrc.import')->middleware('role:mrc,admin,registrar,verifier');
    
    Route::middleware('role:admin,mrc')->group(function(){
        Route::resource('mrc_status', MrcStatusController::class);
            Route::put('mrc_status/update_status/{mrcStatus}', [MrcStatusController::class, 'update_status'])
                ->name('mrc_status.update_status');

            Route::post('mrc_status/update_bulk_status}', [MrcStatusController::class, 'update_bulk_status'])
                ->name('mrc_status.update_bulk_status');
    });    
    Route::resource('finance', FinanceController::class)->middleware('admin');

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
    Route::post('/chatbot/pending-answers/{id}', [ChatController::class, 'pending_answers'])->name('chatbot.answers');
    Route::get('/chatbot/pending-questions', [ChatController::class, 'pending_questions'])->name('chatbot.questions');

    // Office Card Routes
    Route::middleware('role:admin,ea')->group(function(){
        Route::resource('departments', DepartmentController::class)->only(['index','create', 'store', 'edit', 'update']);
        Route::resource('designations', DesignationController::class)->only(['index','create', 'store', 'edit', 'update']);
        Route::controller(EmployeeController::class)->group(function () {
            Route::get('/ea/employees', 'index')->name('Employee.index');
            Route::get('/ea/employee/create', 'create')->name('Employee.create');
            Route::post('/ea/employee/store', 'store')->name('Employee.store');
            Route::get('/ea/employee/edit/{id}', 'edit')->name('Employee.edit');
            Route::get('/ea/employee/show/{id}', 'show')->name('Employee.show');
            Route::put('/ea/employee/update/{id}', 'update')->name('Employee.update');
            Route::get('/ea/issuecard/{id}', 'issueCard')->name('issueCard');
            Route::get('/ea/showcard/{id}', 'showCard')->name('showcard');
        });
    });
});
require __DIR__.'/auth.php';