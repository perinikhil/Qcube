<?php


class AttachmentsTableSeeder extends Seeder {

	public function run()
	{
		DB::table('attachments')->delete();

		Attachment::create([
			'id' => 1,
			'question_id' => 1,
			'path' => '1_HbICu4Md8c6XsnoF'
		]);

		Attachment::create([
			'id' => 2,
			'question_id' => 2,
			'path' => '1_HbICu4Md8c6XsnoF'
		]);

	}

}
