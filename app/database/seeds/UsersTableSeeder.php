<?php
class UsersTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		User::create([
			'name' => 'Peri',
			'email' => 'peri@nikhil',
			'password' => Hash::make('peri'),
			'permissions' => 'o',
			'organization_id' => 1,
			'department_id' => 1
		]);

		User::create([
			'name' => 'Lakie',
			'email' => 'lakie@ranganath',
			'password' => Hash::make('lakie'),
			'permissions' => 'o',
			'organization_id' => 1,
			'department_id' => 1
		]);
	}
}