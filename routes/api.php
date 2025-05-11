<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\ShopsController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\SkuController;
use Illuminate\Support\Facades\Route;

//Route::post( "/auth/login", [AuthController::class, "login"] );

//Route::post( "/auth/login/credentials", [AuthController::class, "loginWithCredentials"] );

Route::name( "auth" )->prefix( "auth" )->group( function () {
    Route::post( "/login/credentials", [AuthController::class, "loginWithCredentials"] )->name( "login.credentials" );
    Route::post( "/login", [AuthController::class, "login"] )->name( "login.token" );
    Route::post( "/logout", [AuthController::class, "logout"] )->name( "logout" );

} );

Route::middleware( ["auth:sanctum"] )->group( function () {

    Route::get( "/auth/me", [AuthController::class, "me"] );

    Route::name( "employees." )->prefix( "employees" )->group( function () {
        Route::post( '/auth', [EmployeeController::class, "auth"] );
    } );

    Route::name( "shops." )->prefix( "shops" )->group( function () {
        Route::post( '/', [ShopsController::class, "index"] );
    } );

    Route::resource( "skus", SkuController::class )
        ->only( ["index", "show"] );

    Route::resource( "products", ProductController::class )
        ->only( ["index", "show"] );


    Route::get( "scan/{sku:barcode}", [ProductController::class, "scan"] )->name( "scan" );

    Route::resource( "sales", SaleController::class )
        ->only( ["index", "show", "store"] );

    Route::post( "sales/compute", [SaleController::class, "compute"] )->name( "sales.compute" );

    // == Clients
    Route::post( "clients/search", [ClientController::class, "search"] )->name( "clients.fidelity" );
    Route::get( "clients/{client:code}", [ClientController::class, "show"] )->name( "clients.show" );

    Route::resource( "clients", ClientController::class )
        ->only( ["store", "update", "destroy"] );
} );
