<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\ShopsController;
use Illuminate\Support\Facades\Route;

Route::post( "/auth/login", [AuthController::class, "login"] );

Route::name( "employees." )->prefix( "employees" )->middleware( ["auth:sanctum"] )->group( function () {
    Route::post( '/auth', [EmployeeController::class, "auth"] );
} );

Route::name( "shops." )->prefix( "shops" )->middleware( ["auth:sanctum"] )->group( function () {
    Route::post( '/', [ShopsController::class, "index"] );
} );
