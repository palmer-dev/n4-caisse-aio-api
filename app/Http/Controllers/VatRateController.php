<?php

namespace App\Http\Controllers;

use App\Http\Requests\VatRateRequest;
use App\Http\Resources\VatRateResource;
use App\Models\VatRate;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class VatRateController extends Controller
{
	use AuthorizesRequests;

	public function index()
	{
		$this->authorize( 'viewAny', VatRate::class );

		return VatRateResource::collection( VatRate::all() );
	}

	public function store(VatRateRequest $request)
	{
		$this->authorize( 'create', VatRate::class );

		return new VatRateResource( VatRate::create( $request->validated() ) );
	}

	public function show(VatRate $vatRate)
	{
		$this->authorize( 'view', $vatRate );

		return new VatRateResource( $vatRate );
	}

	public function update(VatRateRequest $request, VatRate $vatRate)
	{
		$this->authorize( 'update', $vatRate );

		$vatRate->update( $request->validated() );

		return new VatRateResource( $vatRate );
	}

	public function destroy(VatRate $vatRate)
	{
		$this->authorize( 'delete', $vatRate );

		$vatRate->delete();

		return response()->json();
	}
}
