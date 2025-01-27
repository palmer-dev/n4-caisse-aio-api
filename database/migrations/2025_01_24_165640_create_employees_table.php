<?php

use App\Models\Shop;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create( 'employees', function (Blueprint $table) {
            $table->uuid( 'id' )->primary();
            $table->string( 'firstname' );
            $table->string( 'lastname' );
            $table->string( 'code' )->unique();
            $table->string( 'email' )->nullable();
            $table->string( 'phone' )->nullable();
            $table->foreignIdFor( Shop::class )->constrained( 'shops' );
            $table->timestamps();
            $table->softDeletes();
        } );
    }

    public function down(): void
    {
        Schema::dropIfExists( 'employees' );
    }
};
