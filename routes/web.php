<?php

use App\Http\Controllers\SaleController;
use Illuminate\Support\Facades\Route;

Route::get( '/', function () {
    return view( 'welcome' );
} );

Route::middleware( 'auth' )->group( function () {
    Route::prefix( 'receipts' )->name( 'receipts.' )->group( function () {
        // Route pour afficher le ticket PDF (à adapter si nécessaire)
        Route::get( '/{sale}', [SaleController::class, 'generateTicket'] )
            ->name( 'ticket' );

        // Route pour prévisualiser un reçu PDF
        Route::get( '/{sale}/preview', [SaleController::class, 'previewReceipt'] )->name( 'preview' );
    } );
} );
