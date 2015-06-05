<?php

class Organization extends \Eloquent {

	protected $fillable = ['name', 'abbr'];

	public static $rules = [
		'name' => 'required'
	];

	public function departments()
	{
		return $this->hasMany('Department');
	}
}