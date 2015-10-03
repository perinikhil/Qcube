<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class DepartmentsTableSeeder extends Seeder {

	public function run()
	{
		Department::create([
			'id' => '1',
			'name' => 'Computer Science',
			'abbr' => 'CSE',
		]);
		Department::create([
			'id' => '2',
			'name' => 'Information Science',
			'abbr' => 'ISE',
		]);
	}
}
