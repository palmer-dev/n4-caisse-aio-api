<?php

use App\Models\Client;
use App\Models\Employee;
use App\Models\Shop;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create( 'sales', function (Blueprint $table) {
            $table->uuid( 'id' )->primary();
            $table->foreignIdFor( Shop::class )
                ->nullable()
                ->constrained( "shops" )
                ->nullOnDelete();
            $table->foreignIdFor( Employee::class )
                ->nullable()
                ->constrained( "employees" )
                ->nullOnDelete();
            $table->foreignIdFor( Client::class )
                ->nullable()
                ->constrained( "clients" )
                ->nullOnDelete();
            $table->string( 'sale_no' );
            $table->decimal( 'discount' );
            $table->bigInteger( 'sub_total' )->default( 0 );
            $table->bigInteger( 'grand_total' )->default( 0 );
            $table->timestamps();
            $table->softDeletes();

            // Uniqueness of shop_id + sale_no;
            $table->unique( ["shop_id", "sale_no"] );
        } );
    }

    public function down(): void
    {
        Schema::dropIfExists( 'sales' );
    }
};
