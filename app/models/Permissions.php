<?php

class Permissions 
{
	public static function addPermissions($permissions, $permToAdd)
	{
		if(strstr($permissions, $permToAdd) === false)
			$permissions = $permissions.$permToAdd;
		return $permissions;
	}

	public static function removePermissions($permissions, $permToRemove)
	{
		$permissions = str_replace($permToRemove, '', $permissions);
		return $permissions;
	}
}