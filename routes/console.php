<?php

use App\Jobs\CheckPerishableProducts;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command( 'inspire', function () {
    $this->comment( Inspiring::quote() );
} )->purpose( 'Display an inspiring quote' )->hourly();


Schedule::job( new CheckPerishableProducts )
    ->everyMinute();
