<?php

class DepartmentController extends \BaseController {

	public function index($organizationId)
	{
		$departments = Organization::find($organizationId)->departments;
		return Response::json($departments);
	}

	
	public function store($organizationId)
	{
		$validate  = Validator::make(Input::all(), Department::$rules);
		if($validate->fails())
		{
			return Response::json(['alert' => Messages::$validateFail,
				'messages' => $valdate->messages()],
				403);
		}
		else
		{
			$details = Input::all();
			$details['organization_id'] = $organizationId;

		    if(Department::create($details))
	        	return Response::json(['alert' => Messages::$createSuccess.'department'], 200);
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

	
	public function update($organizationId, $id)
	{
		$department = Organization::find($organizationId)->departments()->where('id', $id);
		$details = Input::all();

		if($department)
		{
			if($department->update($details))
	        	return Response::json(['alert' => Messages::$updateSuccess.'department'], 200);
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