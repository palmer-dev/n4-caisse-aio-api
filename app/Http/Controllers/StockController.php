<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockRequest;
use App\Http\Resources\StockResource;
use App\Models\Stock;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StockController extends Controller
{
	use AuthorizesRequests;

	public function index()
	{
		$this->authorize( 'viewAny', Stock::class );

		return StockResource::collection( Stock::all() );
	}

	public function store(StockRequest $request)
	{
		$this->authorize( 'create', Stock::class );

		return new StockResource( Stock::create( $request->validated() ) );
	}

	public function show(Stock $stock)
	{
		$this->authorize( 'view', $stock );

		return new StockResource( $stock );
	}

	public function update(StockRequest $request, Stock $stock)
	{
		$this->authorize( 'update', $stock );

		$stock->update( $request->validated() );

		return new StockResource( $stock );
	}

	public function destroy(Stock $stock)
	{
		$this->authorize( 'delete', $stock );

		$stock->delete();

		return response()->json();
	}
}
