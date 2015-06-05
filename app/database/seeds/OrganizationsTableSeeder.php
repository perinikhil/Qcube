<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class OrganizationsTableSeeder extends Seeder {

	public function run()
	{
		Organization::create([
			'id' => '1',
			'name' => 'Dayananda Sagar College of Engineering',
			'abbr' => 'DSCE',
		]);
		Organization::create([
			'id' => '2',
			'name' => 'Dayananda Sagar Academy of Technology and Management',
			'abbr' => 'DSATM',
		]);
	}
}