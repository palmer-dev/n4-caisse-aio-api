<?php

use App\Models\Shop;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create( 'loyalty_offers', function (Blueprint $table) {
            $table->uuid( 'id' )->primary();
            $table->integer( 'points' );
            $table->timestamp( 'start_date' );
            $table->timestamp( 'end_date' )->nullable();
            $table->string( 'is_active' );
            $table->foreignIdFor( Shop::class )
                ->constrained( 'shops' )
                ->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    public function down(): void
    {
        Schema::dropIfExists( 'loyalty_offers' );
    }
};
