<?php

use App\Models\Shop;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create( 'shoppables', function (Blueprint $table) {
            $table->foreignIdFor( Shop::class )->constrained( "shops" )->cascadeOnDelete();
            $table->uuid( 'shoppable_id' );
            $table->string( 'shoppable_type' );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists( 'shoppables' );
    }
};
