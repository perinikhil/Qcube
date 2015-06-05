<?php
class UsersTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		User::create([
			'name' => 'Peri',
			'password' => 'peri',
			'email' => 'peri@nikhil',
			'permissions' => 'odt',
			'organization_id' => 1,
			'department_id' => 1
		]);

		User::create([
			'name' => 'Lakie',
			'password' => 'lakie',
			'email' => 'lakie@ranganath',
			'permissions' => 'odt',
			'organization_id' => 1,
			'department_id' => 1
		]);
	}
}