<?php

use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create( 'clients', function (Blueprint $table) {
            $table->uuid( 'id' )->primary();
            $table->foreignIdFor( Shop::class )
                ->constrained( "shops" )
                ->cascadeOnDelete();
            $table->foreignIdFor( User::class )
                ->nullable()
                ->constrained( "users" )
                ->nullOnDelete();
            $table->string( 'firstname', 50 );
            $table->string( 'lastname', 50 );
            $table->string( 'zipcode', 12 );
            $table->string( 'email', 320 );
            $table->string( 'phone', 22 );
            $table->boolean( 'newsletter' )->default( false );
            $table->date( 'birthdate' );
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    public function down(): void
    {
        Schema::dropIfExists( 'clients' );
    }
};
