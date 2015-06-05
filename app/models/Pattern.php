<?php

class Pattern extends \Eloquent {
	protected $fillable = ['department_id', 'name', 'no_sections', 'marks_mains'];

	public $rules = [
		'department_id' => 'required',
		'name' => 'required',
		'no_sections' => 'required',
		'marks_mains' => 'required'
	];

	public function department()
	{
		return $this->belongsTo('Department');
	}
}