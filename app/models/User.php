<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'users';

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');



	protected $fillable = ['name', 'password', 'email', 'permissions', 'organization_id', 'department_id'];

	public static $storeRules = [
			'email' => 'required | unique:users,email',
			'name' => 'required',
		];

	public static $emailUpdateRules = [
			'email' => 'unique:users,email',
		];

	public static $newPasswordUpdateRules = [
			'email' => 'unique:users,email',
			'old_password' => 'required | min:3',
			'new_password' => 'required | min:3'
		];
}
