<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\ShopsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::post( "/auth/login", [AuthController::class, "login"] );

Route::middleware( ["auth:sanctum"] )->group( function () {
    Route::name( "employees." )->prefix( "employees" )->group( function () {
        Route::post( '/auth', [EmployeeController::class, "auth"] );
    } );

    Route::name( "shops." )->prefix( "shops" )->group( function () {
        Route::post( '/', [ShopsController::class, "index"] );
    } );

    Route::resource( "products", ProductController::class )
        ->only( ["index", "show"] );

    Route::resource( "sales", SaleController::class )
        ->only( ["index", "show", "store"] );
} );
