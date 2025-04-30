<?php

use App\Models\StockMovements;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create( 'stock_expirations', function (Blueprint $table) {
            $table->uuid( 'id' )->primary();
            $table->foreignIdFor( StockMovements::class )
                ->constrained( 'stock_movements' )
                ->cascadeOnDelete();
            $table->date( 'expiration_date' );
            $table->timestamps();
        } );
    }

    public function down(): void
    {
        Schema::dropIfExists( 'stock_expirations' );
    }
};
