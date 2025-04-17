<?php

namespace App\Http\Controllers;

use App\Http\Requests\SaleDetailRequest;
use App\Http\Resources\SaleDetailResource;
use App\Models\SaleDetail;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class SaleDetailController extends Controller
{
	use AuthorizesRequests;

	public function index()
	{
		$this->authorize( 'viewAny', SaleDetail::class );

		return SaleDetailResource::collection( SaleDetail::all() );
	}

	public function store(SaleDetailRequest $request)
	{
		$this->authorize( 'create', SaleDetail::class );

		return new SaleDetailResource( SaleDetail::create( $request->validated() ) );
	}

	public function show(SaleDetail $saleDetail)
	{
		$this->authorize( 'view', $saleDetail );

		return new SaleDetailResource( $saleDetail );
	}

	public function update(SaleDetailRequest $request, SaleDetail $saleDetail)
	{
		$this->authorize( 'update', $saleDetail );

		$saleDetail->update( $request->validated() );

		return new SaleDetailResource( $saleDetail );
	}

	public function destroy(SaleDetail $saleDetail)
	{
		$this->authorize( 'delete', $saleDetail );

		$saleDetail->delete();

		return response()->json();
	}
}
