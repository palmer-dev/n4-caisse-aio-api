<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductAttributeSkuRequest;
use App\Http\Resources\ProductAttributeSkuResource;
use App\Models\ProductAttributeSku;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductAttributeSkuController extends Controller
{
	use AuthorizesRequests;

	public function index()
	{
		$this->authorize( 'viewAny', ProductAttributeSku::class );

		return ProductAttributeSkuResource::collection( ProductAttributeSku::all() );
	}

	public function store(ProductAttributeSkuRequest $request)
	{
		$this->authorize( 'create', ProductAttributeSku::class );

		return new ProductAttributeSkuResource( ProductAttributeSku::create( $request->validated() ) );
	}

	public function show(ProductAttributeSku $productAttributeSku)
	{
		$this->authorize( 'view', $productAttributeSku );

		return new ProductAttributeSkuResource( $productAttributeSku );
	}

	public function update(ProductAttributeSkuRequest $request, ProductAttributeSku $productAttributeSku)
	{
		$this->authorize( 'update', $productAttributeSku );

		$productAttributeSku->update( $request->validated() );

		return new ProductAttributeSkuResource( $productAttributeSku );
	}

	public function destroy(ProductAttributeSku $productAttributeSku)
	{
		$this->authorize( 'delete', $productAttributeSku );

		$productAttributeSku->delete();

		return response()->json();
	}
}
