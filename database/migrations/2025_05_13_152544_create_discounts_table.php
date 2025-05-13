<?php

use App\Models\Discount;
use App\Models\Shop;
use App\Models\Sku;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create( 'discounts', function (Blueprint $table) {
            $table->uuid( 'id' )->primary();
            $table->string( 'name' );
            $table->string( 'type' );
            $table->decimal( 'value' );
            $table->dateTime( 'start_date' );
            $table->dateTime( 'end_date' );
            $table->boolean( 'is_active' );
            $table->foreignIdFor( Shop::class )->constrained()->cascadeOnDelete();
            $table->timestamps();
        } );


        Schema::create( 'discount_sku', function (Blueprint $table) {
            $table->foreignIdFor( Discount::class )
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignIdFor( Sku::class )
                ->constrained()
                ->cascadeOnDelete();
        } );
    }

    public function down(): void
    {
        Schema::dropIfExists( 'discount_sku' );

        Schema::dropIfExists( 'discounts' );
    }
};
