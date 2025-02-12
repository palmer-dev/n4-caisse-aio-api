<?php

use App\Models\Sku;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create( 'stock_movements', function (Blueprint $table) {
            $table->uuid( 'id' )->primary();
            $table->foreignIdFor( Sku::class )
                ->constrained( 'skus' );
            $table->unsignedInteger( 'quantity' );
            $table->string( 'movement_type' );
            $table->text( 'description' )
                ->nullable();
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    public function down(): void
    {
        Schema::dropIfExists( 'stock_movements' );
    }
};
