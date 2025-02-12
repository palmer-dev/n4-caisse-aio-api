<?php

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create( 'product_attributes', function (Blueprint $table) {
            $table->uuid( 'id' )->primary();
            $table->foreignIdFor( Product::class )->constrained( 'products' )->cascadeOnDelete();
            $table->string( 'name' );
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    public function down(): void
    {
        Schema::dropIfExists( 'product_attributes' );
    }
};
