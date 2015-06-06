<?php

class PatternsTableSeeder extends Seeder {

	public function run()
	{
		DB::table('patterns')->delete();

		Pattern::create([
			'id' => 1,
			'department_id' => 1,
			'name' => '2010 Scheme',
			'header' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
			'no_sections' => 2,
			'marks_mains' => '20,20,20|10,10'
		]);

		Pattern::create([
			'id' => 2,
			'department_id' => 1,
			'name' => '2014 Scheme',
			'header' => 'Consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
			'no_sections' => 2,
			'marks_mains' => '20,20|10,10,10'
			
		]);
	}
}