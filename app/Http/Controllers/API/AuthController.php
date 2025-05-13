<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthCredentialsRequest;
use App\Http\Requests\AuthRequest;
use App\Http\Resources\ClientProfileResource;
use Illuminate\Support\Facades\Auth;
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

    //
    public function loginWithCredentials(AuthCredentialsRequest $request)
    {
        $loggedIn = Auth::attempt( ["email" => $request->validated( "email" ), "password" => $request->validated( "password" )], true );

        if ($loggedIn) {
            $user = Auth::user();
            $user->load( ["clientShops", "clients"] );
            
            return response()->json( [
                "data" => [
                    "token" => $user->createToken( "mobile_app_token" )->plainTextToken,
                    "user"  => new ClientProfileResource( $user )
                ]
            ] );
        }

        return response()->json( [
            "data" => null
        ], 404 );
    }

    public function me()
    {
        $user = Auth::user()
            ->load( ["clientShops", "clients"] );

        return new ClientProfileResource( $user );
    }
}
