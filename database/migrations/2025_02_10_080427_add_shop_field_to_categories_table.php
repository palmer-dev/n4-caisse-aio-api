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
        Schema::table( 'categories', function (Blueprint $table) {
            //
            $table->foreignIdFor( Shop::class )
                ->after( 'parent_id' )
                ->constrained( "shops" );
        } );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table( 'categories', function (Blueprint $table) {
            //
            $table->dropForeign( 'categories_shop_id_foreign' );
            $table->dropConstrainedForeignIdFor( Shop::class );
        } );
    }
};
