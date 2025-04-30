<?php

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\ShopsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

//Route::post( "/auth/login", [AuthController::class, "login"] );

//Route::post( "/auth/login/credentials", [AuthController::class, "loginWithCredentials"] );

Route::name("auth")->prefix("auth")->group(function () {
    Route::post("/login/credentials", [AuthController::class, "loginWithCredentials"]);
    Route::post("/login", [AuthController::class, "login"]);
    Route::post("/logout", [AuthController::class, "logout"]);

});

Route::middleware( ["auth:sanctum"] )->group( function () {

    Route::get("/auth/me", [AuthController::class, "me"]);

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
