<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;

Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index']);
    Route::post('/create', [UserController::class, 'create']);
    Route::post('/login', [UserController::class, 'login']);
    
    Route::put('/update_username', [UserController::class, 'updateUsername']);
    Route::put('/update_email', [UserController::class, 'updateEmail']);
    Route::put('/update_password', [UserController::class, 'updatePassword']);
    
    Route::delete('/delete', [UserController::class, 'delete']);
});