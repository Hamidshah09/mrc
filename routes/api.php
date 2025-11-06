<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DomicileController;
use App\Http\Controllers\Api\IdpController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/nitbuser', [IdpController::class, 'get_user']);
    Route::get('/user', [IdpController::class, 'test_method']); 
    Route::post('/nitbuser/store', [IdpController::class, 'store_nitbuser']);   // Example GET route
    Route::post('/users/update-password', [IdpController::class, 'update_password']);
    Route::post('/idp/store-oldid', [IdpController::class, 'store_old_id']);
    Route::post('/idp/store', [IdpController::class, 'store']);
    Route::post('/idp/update/{id}', [IdpController::class, 'update']);
    Route::get('/idp', [IdpController::class, 'index']);
    Route::get('/idp/card/{id}', [IdpController::class, 'card_data']);
    Route::get('/idp/get-oldid', [IdpController::class, 'get_old_id']);
    Route::post('/idp/update-oldid/{oldid}', [IdpController::class, 'update_old_id']);
    Route::post('/idp-history/store', [IdpController::class, 'idp_his_store']); 
    Route::post('/domicile/update', [DomicileController::class, 'update']);
});
