<?php

use App\Models\Sale;
use App\Models\Sku;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create( 'sale_details', function (Blueprint $table) {
            $table->uuid( 'id' )->primary();
            $table->foreignIdFor( Sale::class )
                ->constrained( 'sales' )
                ->cascadeOnDelete();
            $table->foreignIdFor( Sku::class )
                ->constrained( 'skus' )
                ->cascadeOnDelete();
            $table->integer( 'quantity' );
            $table->bigInteger( 'unit_price' );
            $table->decimal( 'vat' );
            $table->timestamps();
        } );
    }

    public function down(): void
    {
        Schema::dropIfExists( 'sale_details' );
    }
};
