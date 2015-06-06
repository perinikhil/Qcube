<?php

class Pattern extends \Eloquent {
	protected $fillable = ['department_id', 'name', 'header', 'no_sections', 'marks_mains'];

	public static $rules = [
		'department_id' => 'required',
		'name' => 'required',
		'header' => 'required',
		'no_sections' => 'required',
		'marks_mains' => 'required'
	];

	public function department()
	{
		return $this->belongsTo('Department');
	}
}