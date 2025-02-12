<?php

use App\Models\Category;
use App\Models\Shop;
use App\Models\VatRate;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create( 'products', function (Blueprint $table) {
            $table->uuid( 'id' )->primary();
            $table->foreignIdFor( Category::class )->constrained( 'categories' );
            $table->foreignIdFor( VatRate::class )->constrained( 'vat_rates' );
            $table->foreignIdFor( Shop::class )->constrained( 'shops' );
            $table->string( 'type' );
            $table->string( 'name' );
            $table->string( 'slug' )->unique();
            $table->text( 'description' )->nullable();
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    public function down(): void
    {
        Schema::dropIfExists( 'products' );
    }
};
