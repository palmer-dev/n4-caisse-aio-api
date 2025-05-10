<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure( basePath: dirname( __DIR__ ) )
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware( function (Middleware $middleware) {
        //
    } )
    ->withExceptions( function (Exceptions $exceptions) {
        //
        $exceptions->renderable( function (ModelNotFoundException $e, $request) {
            $fullClass = $e->getModel();
            $modelName = last( explode( "\\", $fullClass ) );

            $readableModelName = preg_replace( '/(?<=[a-z])(?=[A-Z])|(?<=[A-Z])(?=[A-Z][a-z])/', ' ', $modelName );

            return response()->json( [
                'message' => "$readableModelName not found."
            ], 404 );
        } );
    } )->create();
