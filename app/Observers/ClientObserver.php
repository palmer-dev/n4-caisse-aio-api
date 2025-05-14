<?php

namespace App\Observers;

use App\Helpers\UniqueClientCodeHelper;
use App\Models\Client;

class ClientObserver
{
    /**
     * Handle the Client "creating" event.
     */
    public function creating(Client $client): void
    {
        if (empty( $client->code )) {
            $client->code = UniqueClientCodeHelper::generate( $client->shop_id );
        }
    }
}
