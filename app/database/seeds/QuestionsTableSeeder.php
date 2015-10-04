<?php

class QuestionsTableSeeder extends Seeder {

	public function run()
	{
		DB::table('questions')->delete();

		Question::create([
			'id' => 1,
			'subject_id' => 1,
			'unit' => '1',
			'course_outcome' => '1,2',
			'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
			'marks' => 10
		]);

		Question::create([
			'id' => 2,
			'subject_id' => 1,
			'unit' => '1',
			'course_outcome' => '1,2',
			'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
			'marks' => 20
		]);

		Question::create([
			'id' => 3,
			'subject_id' => 1,
			'unit' => '1',
			'course_outcome' => '3,4,5',
			'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
			'marks' => 10
		]);

		Question::create([
			'id' => 4,
			'subject_id' => 1,
			'unit' => '1',
			'course_outcome' => '3,4,5',
			'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
			'marks' => 20
		]);

		Question::create([
			'id' => 5,
			'subject_id' => 1,
			'unit' => '2',
			'course_outcome' => '1,2',
			'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
			'marks' => 10
		]);

		Question::create([
			'id' => 6,
			'subject_id' => 1,
			'unit' => '2',
			'course_outcome' => '1,2',
			'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
			'marks' => 20
		]);

		Question::create([
			'id' => 7,
			'subject_id' => 1,
			'unit' => '2',
			'course_outcome' => '3,4,5',
			'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
			'marks' => 10
		]);

		Question::create([
			'id' => 8,
			'subject_id' => 1,
			'unit' => '2',
			'course_outcome' => '3,4,5',
			'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
			'marks' => 20
		]);

		Question::create([
			'id' => 9,
			'subject_id' => 2,
			'unit' => '1',
			'course_outcome' => '1,2',
			'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
			'marks' => 10
		]);

		Question::create([
			'id' => 10,
			'subject_id' => 2,
			'unit' => '1',
			'course_outcome' => '1,2',
			'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
			'marks' => 20
		]);

		Question::create([
			'id' => 11,
			'subject_id' => 2,
			'unit' => '1',
			'course_outcome' => '3,4,5',
			'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
			'marks' => 10
		]);

		Question::create([
			'id' => 12,
			'subject_id' => 2,
			'unit' => '1',
			'course_outcome' => '3,4,5',
			'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
			'marks' => 20
		]);

		Question::create([
			'id' => 13,
			'subject_id' => 2,
			'unit' => '2',
			'course_outcome' => '1,2',
			'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
			'marks' => 10
		]);

		Question::create([
			'id' => 14,
			'subject_id' => 2,
			'unit' => '2',
			'course_outcome' => '1,2',
			'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
			'marks' => 20
		]);

		Question::create([
			'id' => 15,
			'subject_id' => 2,
			'unit' => '2',
			'course_outcome' => '3,4,5',
			'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
			'marks' => 10
		]);

		Question::create([
			'id' => 16,
			'subject_id' => 2,
			'unit' => '2',
			'course_outcome' => '3,4,5',
			'text' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
							tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
							quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo',
			'marks' => 20
		]);
	}
}
