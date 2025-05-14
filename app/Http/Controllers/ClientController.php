<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Http\Requests\SearchClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ClientController extends Controller
{
    use AuthorizesRequests;

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

    public function search(SearchClientRequest $request)
    {
        $this->authorize( 'viewAny', Client::class );

        $client = Client::whereLike( 'lastname', '%' . $request->validated( 'lastname' ) . '%' )
            ->whereLike( 'firstname', '%' . $request->validated( 'firstname' ) . '%' )
            ->when( $request->validated( "zipcode" ), function (Builder $query) use ($request) {
                $query->whereLike( 'zipcode', '%' . $request->validated( 'zipcode' ) . '%' );
            } )
            ->get();

        return ClientResource::collection( $client );
    }
}
