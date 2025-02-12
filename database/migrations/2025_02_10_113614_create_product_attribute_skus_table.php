<?php

use App\Models\ProductAttribute;
use App\Models\Sku;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create( 'product_attribute_skus', function (Blueprint $table) {
            $table->uuid( 'id' )->primary();
            $table->foreignIdFor( ProductAttribute::class )->constrained( 'product_attributes' )->cascadeOnDelete();
            $table->string( 'value' );
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    public function down(): void
    {
        Schema::dropIfExists( 'product_attribute_skus' );
    }
};
