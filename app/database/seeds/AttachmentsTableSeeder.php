<?php


class AttachmentsTableSeeder extends Seeder {

	public function run()
	{
		DB::table('attachments')->delete();

		Attachment::create([
			'id' => 1,
			'question_id' => 1,
			'path' => '1_58Kxn47JA6WRGeU2.jpg'
		]);
		Attachment::create([
			'id' => 2,
			'question_id' => 1,
			'path' => '1_W6CWn5wGhamaZ3ZH.jpg'
		]);

		Attachment::create([
			'id' => 3,
			'question_id' => 2,
			'path' => '2_Cm3sdfi6MtzPfMDG.png'
		]);
		Attachment::create([
			'id' => 4,
			'question_id' => 2,
			'path' => '2_O2OgbRkmfqWGC1zX.jpg'
		]);

	}

}