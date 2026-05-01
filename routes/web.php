<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ArmsController;
use App\Http\Controllers\AuqafOfficialsController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\PostalServiceExportController;
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
use App\Http\Controllers\MousqueController;
use App\Http\Controllers\NocIctController;
use App\Http\Controllers\NocOtherDistrictController;
use App\Http\Controllers\ExpenseRegisterController;
use App\Models\ApplicationType;
use App\Models\OnlineApplication;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostalServiceController;
use App\Http\Controllers\DomicileCancellationController;
use App\Http\Controllers\BlackListController;
use App\Http\Controllers\VerificationLetterController;
use App\Http\Controllers\suretyController;
use App\Http\Controllers\SuretyDocumentController;

Route::get('/', function () {
    return view('welcome');
})->name('home');
Route::get('/postalservice/postal-status', [PostalServiceController::class, 'getPakistanPostTracking'])->name('postalservice.status');
Route::get('/reports', function () {
    $totalArticles = 12;
    $totalRate = 160 * $totalArticles;
    return view('postalservice.pdf_receiving', compact('totalArticles', 'totalRate'));
})->name('reports');
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
Route::get('/postalservice/create', [PostalServiceController::class, 'create'])->name('postalservice.create');
Route::post('/postalservice/store', [PostalServiceController::class, 'store'])->name('postalservice.store');
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
    

    Route::controller(PostalServiceController::class)->group(function(){
        
        
        Route::get('/postalservice/index', 'index')->name('postalservice.index');
        Route::get('/postalservice/show/{id}', 'show')->name('postalservice.show');
        Route::get('/postalservice/edit/{id}', 'edit')->name('postalservice.edit');
        Route::put('/postalservice/update/{id}', 'update')->name('postalservice.update');
        Route::put('/postalservice/update-status/{id}', 'updateStatus')->name('postalservice.update-status');
        Route::post(
                    '/postalservice/bulk-update-status',
                    [PostalServiceController::class, 'bulkUpdateStatus']
                )->name('postalservice.bulk_update_status');
    });

    // PDF Export Routes
    Route::get('/postalservice/export/pdf-report', [PostalServiceExportController::class, 'exportPdf'])->name('postalservice.export.pdf');
    Route::get('/postalservice/export/pdf-receiving', [PostalServiceExportController::class, 'exportPdfWithReceiving'])->name('postalservice.export.pdf_receiving');
    Route::post('/postalservice/export/pdf-envelope-labels', [PostalServiceExportController::class, 'exportEnvelopeLabels'])->name('postalservice.export.envelope_labels');
    
    Route::get('/domicile/admin', [domicileController::class, 'admin_index'])->name('domicile.admin');
    Route::get('/domicile/form-p/{id}', [domicileController::class,'form_p'])->name('domicile.form_p');
    Route::get('/domicile/noc-ict/create', [NocIctController::class, 'noc_ict_create'])->name('noc-ict.create');
    Route::post('/domicile/noc-ict/store', [NocIctController::class, 'noc_ict_store'])->name('noc-ict.store');
    Route::get('/domicile/noc-ict', [NocIctController::class, 'noc_ict_index'])->name('noc-ict.index');
    Route::get('/domicile/noc-ict/edit/{id}', [NocIctController::class, 'noc_ict_edit'])->name('noc-ict.edit');
    Route::put('/domicile/noc-ict/update/{id}', [NocIctController::class, 'noc_ict_update'])->name('noc-ict.update');
    Route::get('/domicile/noc-ict/letter/{id}', [NocIctController::class, 'generateLetter'])->name('noc-ict.letter');
    
    Route::get('/domicile/noc-other-district', [NocOtherDistrictController::class, 'index'])->name('noc-other-district.index');
    Route::get('/domicile/noc-other-district/create', [NocOtherDistrictController::class, 'create'])->name('noc-other-district.create');
    Route::post('/domicile/noc-other-district/store', [NocOtherDistrictController::class, 'store'])->name('noc-other-district.store');
    Route::get('/domicile/noc-other-district/edit/{id}', [NocOtherDistrictController::class, 'edit'])->name('noc-other-district.edit');
    Route::put('/domicile/noc-other-district/update/{id}', [NocOtherDistrictController::class, 'update'])->name('noc-other-district.update');
    Route::get('/domicile/noc-other-district/letter/{id}', [NocOtherDistrictController::class, 'issueletter'])->name('noc-other-district.letter');

    Route::get('/domicile/cancellation/create', [DomicileCancellationController::class, 'create'])->name('domicile.cancellation.create');
    Route::post('/domicile/cancellation/store', [DomicileCancellationController::class, 'store'])->name('domicile.cancellation.store');
    Route::get('/domicile/cancellation', [DomicileCancellationController::class, 'index'])->name('domicile.cancellation.index');
    Route::get('/domicile/cancellation/edit/{id}', [DomicileCancellationController::class, 'edit'])->name('domicile.cancellation.edit');
    Route::put('/domicile/cancellation/update/{id}', [DomicileCancellationController::class, 'update'])->name('domicile.cancellation.update');
    Route::get('/domicile/cancellation/letter/{id}', [DomicileCancellationController::class, 'issueletter'])->name('domicile.cancellation.letter');

    Route::get('/domicile/blacklist/create', [BlackListController::class, 'create'])->name('domicile.blacklist.create');
    Route::post('/domicile/blacklist/store', [BlackListController::class, 'store'])->name('domicile.blacklist.store');
    Route::get('/domicile/blacklist', [BlackListController::class, 'index'])->name('domicile.blacklist.index');
    Route::get('/domicile/blacklist/edit/{id}', [BlackListController::class, 'edit'])->name('domicile.blacklist.edit');
    Route::put('/domicile/blacklist/update/{id}', [BlackListController::class, 'update'])->name('domicile.blacklist.update');
    
    Route::get('/domicile/verification-letter/create', [VerificationLetterController::class, 'create'])->name('domicile.verification_letter.create');
    Route::post('/domicile/verification-letter/store', [VerificationLetterController::class, 'store'])->name('domicile.verification_letter.store');
    Route::get('/domicile/verification-letter', [VerificationLetterController::class, 'index'])->name('domicile.verification_letter.index');
    Route::get('/domicile/verification-letter/edit/{id}', [VerificationLetterController::class, 'edit'])->name('domicile.verification_letter.edit');
    Route::put('/domicile/verification-letter/update/{id}', [VerificationLetterController::class, 'update'])->name('domicile.verification_letter.update');
    Route::get('/domicile/verification-letter/letter/{id}', [VerificationLetterController::class, 'issueletter'])->name('domicile.verification_letter.letter');

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
        Route::get('/arms/{id}/letter', [ArmsController::class, 'generateLetter'])->name('arms.letter');
        Route::get('/arms/statistics', [ArmsController::class, 'statistics'])->name('arms.statistics');

    });
    Route::middleware('role:admin')->group(function(){
        Route::get('/admin/expense-register', [ExpenseRegisterController::class, 'index'])->name('expense_register.index');
        Route::get('/admin/expense-register/create', [ExpenseRegisterController::class, 'create'])->name('expense_register.create');
        Route::post('/admin/expense-register/store', [ExpenseRegisterController::class, 'store'])->name('expense_register.store');
        Route::get('/admin/expense-register/edit/{id}', [ExpenseRegisterController::class, 'edit'])->name('expense_register.edit');
        Route::put('/admin/expense-register/update/{id}', [ExpenseRegisterController::class, 'update'])->name('expense_register.update');
    });
    Route::middleware('role:auqaf,admin')->group(function(){
        Route::get('/auqaf/mousques', [MousqueController::class, 'index'])->name('mousques.index');
        Route::get('/auqaf/mousques/create', [MousqueController::class, 'create'])->name('mousques.create');
        Route::get('/auqaf/mousques/edit/{id}', [MousqueController::class, 'edit'])->name('mousques.edit');
        Route::put('/auqaf/mousques/update/{id}', [MousqueController::class, 'update'])->name('mousques.update');
        Route::post('/auqaf/mousques/store', [MousqueController::class, 'store'])->name('mousques.store');
        Route::get('/auqaf/mousques/show/{id}', [MousqueController::class, 'show'])->name('mousques.show');

        Route::get('/auqaf/officials', [AuqafOfficialsController::class, 'index'])->name('auqaf-officials.index');
        Route::get('/auqaf/officials/create', [AuqafOfficialsController::class, 'create'])->name('auqaf-officials.create');
        Route::get('/auqaf/officials/edit/{id}', [AuqafOfficialsController::class, 'edit'])->name('auqaf-officials.edit');
        Route::put('/auqaf/officials/update/{id}', [AuqafOfficialsController::class, 'update'])->name('auqaf-officials.update');
        Route::post('/auqaf/officials/store', [AuqafOfficialsController::class, 'store'])->name('auqaf-officials.store');

    });
    Route::middleware('role:surety,admin')->group(function(){
        Route::get('/surety', [suretyController::class, 'index'])->name('surety.index');
        Route::get('/surety/dashboard', [suretyController::class, 'dashboard'])->name('surety.dashboard');
        Route::get('/surety/fetch/{register_id}', [SuretyController::class, 'fetchByRegisterId']);
        Route::post('/surety/store', [suretyController::class, 'store'])->name('surety.store');
        Route::get('/surety/show/{id}', [suretyController::class, 'show'])->name('surety.show');
        Route::get('/surety/edit/{id}', [suretyController::class, 'edit'])->name('surety.edit');
        Route::put('/surety/update/{id}', [suretyController::class, 'update'])->name('surety.update');
        Route::put('/surety/updatestatus/{id}', [suretyController::class, 'updatestatus'])->name('surety.updatestatus');

        Route::get('/surety/documents/{id}/entry', [SuretyController::class, 'create'])
            ->name('surety.create');
        Route::get('/surety/documents', [SuretyDocumentController::class, 'index'])->name('suretydocuments.index');
        Route::get('/surety/documents/create', [SuretyDocumentController::class, 'create'])->name('suretydocuments.create');
        Route::post('/surety/documents/store', [SuretyDocumentController::class, 'store'])->name('suretydocuments.store');
        Route::get('/surety/documents/edit/{id}', [SuretyDocumentController::class, 'edit'])->name('suretydocuments.edit');
        Route::put('/surety/documents/update/{id}', [SuretyDocumentController::class, 'update'])->name('suretydocuments.update');
        Route::post('/surety/documents/{id}/lock', [SuretyDocumentController::class, 'lock'])->name('suretydocuments.lock');
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