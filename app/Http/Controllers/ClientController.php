<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ClientController extends Controller
{
	use AuthorizesRequests;

	public function index()
	{
		$this->authorize( 'viewAny', Client::class );

		return ClientResource::collection( Client::all() );
	}

	public function store(ClientRequest $request)
	{
		$this->authorize( 'create', Client::class );

		return new ClientResource( Client::create( $request->validated() ) );
	}

	public function show(Client $client)
	{
		$this->authorize( 'view', $client );

		return new ClientResource( $client );
	}

	public function update(ClientRequest $request, Client $client)
	{
		$this->authorize( 'update', $client );

		$client->update( $request->validated() );

		return new ClientResource( $client );
	}

	public function destroy(Client $client)
	{
		$this->authorize( 'delete', $client );

		$client->delete();

		return response()->json();
	}
}
