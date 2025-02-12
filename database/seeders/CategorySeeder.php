<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
	public function run(): void
	{
		$this->command->getOutput()->progressStart( 10 );

		for ($i = 0; $i < 10; $i++) {
			Category::factory()
				->create();

			$this->command->getOutput()->progressAdvance();
		}

		$this->command->getOutput()->progressFinish();
	}
}
