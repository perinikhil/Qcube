<?php

class Attachment extends \Eloquent {
	protected $fillable = ['question_id','attachment'];

	public static $rules = [
		'question_id' => 'required',
		'attachment' => 'required'
	];

	public function question()
	{
		return $this->belongsTo('Question');
	}
}
