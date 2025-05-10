<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Resources\SkuResource;
use App\Models\Product;
use App\Models\Sku;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $this->authorize( 'viewAny', Product::class );

        return ProductResource::collection( Product::with( ["sku"] )->get() );
    }

    public function store(ProductRequest $request)
    {
        $this->authorize( 'create', Product::class );

        return new ProductResource( Product::create( $request->validated() ) );
    }

    public function show(Product $product)
    {
        $this->authorize( 'view', $product );

        return new ProductResource( $product );
    }

    public function update(ProductRequest $request, Product $product)
    {
        $this->authorize( 'update', $product );

        $product->update( $request->validated() );

        return new ProductResource( $product );
    }

    public function destroy(Product $product)
    {
        $this->authorize( 'delete', $product );

        $product->delete();

        return response()->json();
    }

    public function scan(Sku $sku)
    {
        $this->authorize( 'viewAny', Product::class );

        return new SkuResource( $sku );
    }
}
