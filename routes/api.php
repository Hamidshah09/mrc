<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\IdpController;
use Illuminate\Support\Facades\Route;


Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/nitbuser/{id}', [IdpController::class, 'get_nitbuser']); 
    Route::post('/nitbuser/store', [IdpController::class, 'store_nitbuser']);   // Example GET route
    Route::post('/users/update-password', [IdpController::class, 'update_password']);
    Route::post('/idp/store', [IdpController::class, 'store']); 
});
