<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoyaltyOfferRequest;
use App\Http\Resources\LoyaltyOfferResource;
use App\Models\LoyaltyOffer;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class LoyaltyOfferController extends Controller
{
	use AuthorizesRequests;

	public function index()
	{
		$this->authorize( 'viewAny', LoyaltyOffer::class );

		return LoyaltyOfferResource::collection( LoyaltyOffer::all() );
	}

	public function store(LoyaltyOfferRequest $request)
	{
		$this->authorize( 'create', LoyaltyOffer::class );

		return new LoyaltyOfferResource( LoyaltyOffer::create( $request->validated() ) );
	}

	public function show(LoyaltyOffer $loyaltyOffer)
	{
		$this->authorize( 'view', $loyaltyOffer );

		return new LoyaltyOfferResource( $loyaltyOffer );
	}

	public function update(LoyaltyOfferRequest $request, LoyaltyOffer $loyaltyOffer)
	{
		$this->authorize( 'update', $loyaltyOffer );

		$loyaltyOffer->update( $request->validated() );

		return new LoyaltyOfferResource( $loyaltyOffer );
	}

	public function destroy(LoyaltyOffer $loyaltyOffer)
	{
		$this->authorize( 'delete', $loyaltyOffer );

		$loyaltyOffer->delete();

		return response()->json();
	}
}
