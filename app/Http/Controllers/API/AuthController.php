<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthRequest;
use Laravel\Sanctum\PersonalAccessToken;

class AuthController extends Controller
{
    //
    public function login(AuthRequest $request)
    {
        $user = PersonalAccessToken::findToken( $request->validated( "token" ) );

        if ($user)
            return response()->json( [
                "data" => [
                    "token" => $request->validated( "token" ),
                    "user"  => $user->tokenable
                ]
            ] );

        return response()->json( [
            "data" => null
        ], 404 );
    }
}
