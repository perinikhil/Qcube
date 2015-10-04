<?php
class UsersTableSeeder extends Seeder {

	public function run()
	{
		DB::table('users')->delete();

		User::create([
			'name' => 'Lakie',
			'email' => 'lakie@ranganath.com',
			'password' => Hash::make('lakie'),
			'permissions' => 'odt',
			'department_id' => 1
		]);

		User::create([
			'name' => 'Peri',
			'email' => 'peri@nikhil.com',
			'password' => Hash::make('peri'),
			'permissions' => 't',
			'department_id' => 1
		]);
	}
}
