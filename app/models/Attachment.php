<?php

class Attachment extends \Eloquent {
	protected $fillable = ['question_id','path'];

	public static $rules = [
		'question_id' => 'required',
		'path' => 'required'
	];

	public function question()
	{
		return $this->belongsTo('Question');
	}
}
