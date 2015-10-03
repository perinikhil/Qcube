<?php

class Department extends \Eloquent {

	protected $fillable = ['name', 'abbr'];

	public static $rules = [
		'name' => 'required'
	];

	public function subjects()
	{
		return $this->hasMany('Subject');
	}

	public function patterns()
	{
		return $this->hasMany('Pattern');
	}
}
