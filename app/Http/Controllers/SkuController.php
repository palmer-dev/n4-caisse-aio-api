<?php

namespace App\Http\Controllers;

use App\Http\Requests\SkuRequest;
use App\Http\Resources\SkuResource;
use App\Models\Sku;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SkuController extends Controller
{
	use AuthorizesRequests;

	public function index()
	{
		$this->authorize( 'viewAny', Sku::class );

		return SkuResource::collection( Sku::all() );
	}

	public function store(SkuRequest $request)
	{
		$this->authorize( 'create', Sku::class );

		return new SkuResource( Sku::create( $request->validated() ) );
	}

	public function show(Sku $sku)
	{
		$this->authorize( 'view', $sku );

		return new SkuResource( $sku->load("product") );
	}

	public function update(SkuRequest $request, Sku $sku)
	{
		$this->authorize( 'update', $sku );

		$sku->update( $request->validated() );

		return new SkuResource( $sku );
	}

	public function destroy(Sku $sku)
	{
		$this->authorize( 'delete', $sku );

		$sku->delete();

		return response()->json();
	}
}
