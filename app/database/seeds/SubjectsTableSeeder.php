<?php

class SubjectsTableSeeder extends Seeder {

	public function run()
	{
		DB::table('subjects')->delete();

		Subject::create([
			'id' => 1,
			'department_id' => 1,
			'name' => 'Concepts of C Programming',
			'abbr' => 'CCP',
			'semester' => '1',
			'subject_code' => '10CS14'
		]);

		Subject::create([
			'id' => 2,
			'department_id' => 1,
			'name' => 'Unix and Shell Programming',
			'abbr' => 'USP',
			'semester' => '2',
			'subject_code' => '10CS24'
		]);
	}
}