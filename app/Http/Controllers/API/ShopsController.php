<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShopCollection;
use App\Models\Shop;

class ShopsController extends Controller
{
    //
    public function index()
    {
        $shops = Shop::all();

        return new ShopCollection( $shops );
    }
}
