<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopRequest;
use App\Http\Resources\ShopResource;
use App\Models\Shop;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ShopController extends Controller
{
	use AuthorizesRequests;

	public function index()
	{
		$this->authorize( 'viewAny', Shop::class );

		return ShopResource::collection( Shop::all() );
	}

	public function store(ShopRequest $request)
	{
		$this->authorize( 'create', Shop::class );

		return new ShopResource( Shop::create( $request->validated() ) );
	}

	public function show(Shop $shop)
	{
		$this->authorize( 'view', $shop );

		return new ShopResource( $shop );
	}

	public function update(ShopRequest $request, Shop $shop)
	{
		$this->authorize( 'update', $shop );

		$shop->update( $request->validated() );

		return new ShopResource( $shop );
	}

	public function destroy(Shop $shop)
	{
		$this->authorize( 'delete', $shop );

		$shop->delete();

		return response()->json();
	}
}
