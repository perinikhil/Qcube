<?php

class DepartmentController extends \BaseController {

	public function index($organizationId)
	{
		$departments = Organization::find($organizationId)->departments;
		foreach($departments as $department)
		{
			$department->department_head = User::where('department_id', $department->id)->where('permissions', 'like', '%d%')->first();
		}

		return Response::json($departments);
	}

	public function store($organizationId)
	{
		$validate = Validator::make(Input::all(), Department::$rules);

		if($validate->fails())
		{
			return Response::json(['alert' => Messages::$validateFail,
				'messages' => $validate->messages()],
				403);
		}
		else
		{
			$details = Input::all();
			$details['organization_id'] = $organizationId;

		    if($department = Department::create($details))
		    {
		    	if(self::storeDepartmentHead($details['department_head_email'], $department))
			    	return Response::json(['department' => $department,
			        	'alert' => Messages::$createSuccess.'department and department head'],
			        	200);
			    else
	        		return Response::json(['alert' => Messages::$createFail.'department head'], 500);
		    }
	        else
	        	return Response::json(['alert' => Messages::$createFail.'department'], 500);
	   	}
	}

	public static function storeDepartmentHead($departmentHeadEmail, $department)
	{
		if($existingUser = User::where('email', $departmentHeadEmail)->first())
		{
			$existingUser->department_id = $department->id;
			$existingUser->permissions = Permissions::addPermissions($existingUser->permissions, 'd');
			if($existingUser->save())
				return true;
			else
				return false;
		}
		else
		{
			$details['name'] = $departmentHead['name'];
			$details['email'] = $departmentHead['email'];
			$details['password'] = Hash::make('changeme');
			$details['permissions'] = 'd';
			$details['department_id'] = $department->id;
			$details['organization_id'] = Auth::user()->organization_id;
			if($user = User::create($details))
				return true;
	        else
	        	return false;

		}
	}

	public function show($organizationId, $id)
	{
		$department = Organization::find($organizationId)->departments()->where('id', $id)->get();
		if($department)
			return Response::json($department);
		else
			return Response::json(['alert' => 'Department'.Messages::$notFound]);

	}


	public function update($organizationId, $id)
	{
		$department = Organization::find($organizationId)->departments()->find($id);
		$details = Input::except('department_head');

		if($department)
		{
			if($department->update($details))
			{
				$department = Department::find($department->id);
				if(Input::has('department_head_email'))
		    	{
		    		if(self::updateDepartmentHead(Input::get('department_head_email'), $department))
		    			return Response::json(['department' => $department,
		        			'alert' => Messages::$updateSuccess.'department and department head'],
		        			200);
		    		else
	        			return Response::json(['alert' => Messages::$updateFail.'department head'], 500);
		    	}
			}
	        else
	        	return Response::json(['alert' => Messages::$updateFail.'department'], 500);
		}
		else
	        return Response::json(['alert' => 'Department'.Messages::$notFound], 404);
	}


	public static function updateDepartmentHead($departmentHeadEmail, $department)
	{
		//swap permissions for the new and old hod
		$newHead = User::where('email', $departmentHeadEmail)->first();
		$oldHead = User::where('department_id', $department->id)->where('permissions', 'LIKE', '%d%')->first();

		if(!$newHead)
			if(self::storeDepartmentHead($departmentHeadEmail, $department))
				$newHead = User::where('email', $departmentHeadEmail)->first();

		if($oldHead)
		{
			$newHead->permissions = Permissions::addPermissions($newHead->permissions, 'd');
			$oldHead->permissions = Permissions::removePermissions($oldHead->permissions, 'd');
			$newHead->department_id = $department->id;
			if($oldHead->save() && $newHead->save())
			{
				return true;
			}
			else
				return false;
		}
		else if($newHead)
		{
			$newHead->permissions = Permissions::addPermissions($newHead->permissions, 'd');
			$newHead->department_id = $department->id;

			if($newHead->save())
				return true;
	    else
	    	return false;
		}
		else
		{
			$details['name'] = $departmentHead['name'];
			$details['email'] = $departmentHead['email'];
			$details['password'] = Hash::make('changeme');
			$details['permissions'] = 'd';
			$details['department_id'] = $department->id;
			$details['organization_id'] = Auth::user()->organization_id;
			if($user = User::create($details))
				return true;
	    else
	    	return false;
		}
	}


	public function destroy($organizationId, $id)
	{
		$department = Organization::find($organizationId)->departments()->where('id', $id);

		if($department)
		{
			if($department->delete())
				return Response::json(['alert' => Messages::$deleteSuccess.'department'], 200);
			else
				return Response::json(['alert' => Messages::$deleteFail.'department'], 500);
		}
		else
	        return Response::json(['alert' => 'Department'.Messages::$notFound], 404);
	}

	public function candidates($organizationId, $id)
	{
		$candidates = User::where('department_id', $id)->where('permissions', 'not like', '%d%')->get();

		return Response::json($candidates);
	}
}
