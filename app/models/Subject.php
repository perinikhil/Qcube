<?php

class Subject extends \Eloquent {
	protected $fillable = ['department_id', 'name', 'subject_code', 'class'];

	public static $rules = [
		'department_id' => 'required',
		'name' => 'required',
		'class' => 'required'
		];

	public function questions()
	{
		return $this->hasMany('Question');
	}

	public function department()
	{
		return $this->belongsTo('Department');
	}
}