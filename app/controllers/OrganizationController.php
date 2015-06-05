<?php

class OrganizationController extends \BaseController {

	public function index()
	{
		$organizations = Organization::all();
		return Response::json($organizations);
	}

	
	public function store()
	{
		$validate  = Validator::make(Input::all(), Organization::$rules);
		if($validate->fails())
		{
			return Response::json(['alert' => Messages::$validateFail,
				'messages' => $valdate->messages()],
				403);
		}
		else
		{
			$details = Input::all();

		    if($organization = Organization::create($details))
	        	return Response::json(['organization' => $organization,
	        		'alert' => Messages::$createSuccess.'organization'],
	        		 200);
	        else
	        	return Response::json(['alert' => Messages::$createFail.'organization'], 500);
	   	}
	}

	
	public function show($id)
	{
		$organization = Organization::find($id);
		if($organization)
			return Response::json($organization);
		else
			return Response::json(['alert' => 'Organization'.Messages::$notFound], 404);
		
	}

	
	public function update($id)
	{
		$organization = Organization::find($id);
		$details = Input::all();

		if($organization->update($details))
        	return Response::json(['alert' => Messages::$updateSuccess.'organization'], 200);
        else
        	return Response::json(['alert' => Messages::$updateFail.'organization'], 500);
	}

	
	public function destroy($id)
	{
		if(Organization::destroy($id))
			return Response::json(['alert' => Messages::$deleteSuccess.'organization'], 200);
		else
			return Response::json(['alert' => Messages::$deleteFail.'organization'], 500);
	}

}