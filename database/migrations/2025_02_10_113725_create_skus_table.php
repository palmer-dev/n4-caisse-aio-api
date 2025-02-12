<?php

use App\Models\Product;
use App\Models\ProductAttributeSku;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create( 'skus', function (Blueprint $table) {
            $table->uuid( 'id' )->primary();
            $table->foreignIdFor( ProductAttributeSku::class )
                ->nullable()
                ->constrained( 'product_attribute_skus' )
                ->cascadeOnDelete();
            $table->foreignIdFor( Product::class )
                ->nullable()
                ->constrained( 'products' )
                ->cascadeOnDelete();
            $table->string( 'sku' );
            $table->decimal( 'unit_amount' );
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    public function down(): void
    {
        Schema::dropIfExists( 'skus' );
    }
};
