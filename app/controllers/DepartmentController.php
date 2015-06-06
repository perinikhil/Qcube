<?php

class DepartmentController extends \BaseController {

	public function index($organizationId)
	{
		$departments = Organization::find($organizationId)->departments;
		return Response::json($departments);
	}

	
	public static function storeDepartmentHead($departmentHead, $department)
	{
		if($existingUser = User::where('email', $departmentHead['email'])->first())
		{
			$existingUser->department_id = $department->id;
			$existingUser->permissions = Permissions::addPermissions($existingUser->permissions, 'd');
			if($existingUser->save())
			{
				return true;
				
			}
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

	public function store($organizationId)
	{
		$validate  = Validator::make(Input::all(), Department::$rules);

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
		    	if(self::storeDepartmentHead($details['department_head'], $department))
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

	
	public function show($organizationId, $id)
	{
		$department = Organization::find($organizationId)->departments()->where('id', $id)->get();
		if($department)
			return Response::json($department);
		else
			return Response::json(['alert' => 'Department'.Messages::$notFound]);
		
	}

	
	public static function updateDepartmentHead($departmentHead, $department)
	{
		$newHead = User::where('email', $departmentHead['email'])->first();
		$oldHead = User::where('department_id', $department->id)->where('permissions', 'LIKE', '%d%')->first();
	
		if($oldHead)	//swap permissions for the new and old hod
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

	public function update($organizationId, $id)
	{
		$department = Organization::find($organizationId)->departments()->find($id);
		$details = Input::except('department_head');
		
		if($department)
		{
			if($department->update($details))
			{
				$department = Department::find($department->id);
				if(Input::has('department_head'))
		    	{
		    		if(self::updateDepartmentHead(Input::get('department_head'), $department))
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

}