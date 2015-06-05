<?php

class SubjectsTableSeeder extends Seeder {

	public function run()
	{
		DB::table('subjects')->delete();

		Subject::create([
			'id' => 1,
			'department_id' => 1,
			'name' => 'CCP',
			'class' => '1',
			'subject_code' => '10CS14'
		]);

		Subject::create([
			'id' => 2,
			'department_id' => 1,
			'name' => 'Unix',
			'class' => '2',
			'subject_code' => '10CS24'
		]);
	}
}