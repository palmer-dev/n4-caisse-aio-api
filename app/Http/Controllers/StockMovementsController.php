<?php

namespace App\Http\Controllers;

use App\Http\Requests\StockMovementsRequest;
use App\Http\Resources\StockMovementsResource;
use App\Models\StockMovements;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class StockMovementsController extends Controller
{
	use AuthorizesRequests;

	public function index()
	{
		$this->authorize( 'viewAny', StockMovements::class );

		return StockMovementsResource::collection( StockMovements::all() );
	}

	public function store(StockMovementsRequest $request)
	{
		$this->authorize( 'create', StockMovements::class );

		return new StockMovementsResource( StockMovements::create( $request->validated() ) );
	}

	public function show(StockMovements $stockMovements)
	{
		$this->authorize( 'view', $stockMovements );

		return new StockMovementsResource( $stockMovements );
	}

	public function update(StockMovementsRequest $request, StockMovements $stockMovements)
	{
		$this->authorize( 'update', $stockMovements );

		$stockMovements->update( $request->validated() );

		return new StockMovementsResource( $stockMovements );
	}

	public function destroy(StockMovements $stockMovements)
	{
		$this->authorize( 'delete', $stockMovements );

		$stockMovements->delete();

		return response()->json();
	}
}
