<?php

use App\Models\Shop;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create( 'addresses', function (Blueprint $table) {
            $table->uuid( 'id' )->primary();
            $table->foreignIdFor( Shop::class )
                ->nullable()
                ->constrained( "shops" )
                ->nullOnDelete();
            $table->string( 'street' );
            $table->string( 'city' );
            $table->string( 'state' )->nullable();
            $table->string( 'postal_code' );
            $table->string( 'country' );
            $table->string( 'type' );
            $table->timestamps();
        } );
    }

    public function down(): void
    {
        Schema::dropIfExists( 'addresses' );
    }
};
