<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductAttributeRequest;
use App\Http\Resources\ProductAttributeResource;
use App\Models\ProductAttribute;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductAttributeController extends Controller
{
	use AuthorizesRequests;

	public function index()
	{
		$this->authorize( 'viewAny', ProductAttribute::class );

		return ProductAttributeResource::collection( ProductAttribute::all() );
	}

	public function store(ProductAttributeRequest $request)
	{
		$this->authorize( 'create', ProductAttribute::class );

		return new ProductAttributeResource( ProductAttribute::create( $request->validated() ) );
	}

	public function show(ProductAttribute $productAttribute)
	{
		$this->authorize( 'view', $productAttribute );

		return new ProductAttributeResource( $productAttribute );
	}

	public function update(ProductAttributeRequest $request, ProductAttribute $productAttribute)
	{
		$this->authorize( 'update', $productAttribute );

		$productAttribute->update( $request->validated() );

		return new ProductAttributeResource( $productAttribute );
	}

	public function destroy(ProductAttribute $productAttribute)
	{
		$this->authorize( 'delete', $productAttribute );

		$productAttribute->delete();

		return response()->json();
	}
}
