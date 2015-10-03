<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('DepartmentsTableSeeder');
		$this->call('UsersTableSeeder');
		$this->call('SubjectsTableSeeder');
		$this->call('PatternsTableSeeder');
		$this->call('QuestionsTableSeeder');
		$this->call('AttachmentsTableSeeder');
	}

}
