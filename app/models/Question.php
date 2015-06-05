<?php

class Question extends \Eloquent {
	protected $fillable = ['subject_id', 'unit', 'question', 'marks', 'tags'];

	public static $rules = [
		'subject_id' => 'required',
		'unit' => 'required',
		'question' => 'required',
		'marks' => 'required'
	];
	
	public function subject()
	{
		return $this->belongsTo('Subject');
	}

	public function attachments()
	{
		return $this->hasMany('Attachment');
	}
}