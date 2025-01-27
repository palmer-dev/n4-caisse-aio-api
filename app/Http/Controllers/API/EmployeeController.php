<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\EmployeeAuthRequest;
use App\Http\Resources\EmployeeResource;
use App\Models\Employee;

class EmployeeController extends Controller
{
    //
    public function auth(EmployeeAuthRequest $request)
    {
        $employee = Employee::with( "shop" )->firstWhere( "code", $request->validated( "code" ) );

        if ($employee) {
            return new EmployeeResource( $employee );
        }

        return response()->json( ["data" => null], 404 );
    }
}
