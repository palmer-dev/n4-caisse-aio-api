<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create( 'vat_rates', function (Blueprint $table) {
			$table->uuid( 'id' )->primary();
			$table->string( 'name' );
			$table->text( 'description' );
			$table->decimal( 'value' );
            $table->timestamps();
			$table->softDeletes();
		} );
	}

	public function down(): void
	{
		Schema::dropIfExists( 'vat_rates' );
	}
};
