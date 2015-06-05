<?php

class UserController extends \BaseController {

	public function index()
	{
		$users = User::all();
		return Response::json($users);
	}

	
	public function store()
	{
		$validate = Validator::make(Input::all(), User::$storeRules);
		if($validate->fails())
		{
			return Response::json(['alert' => Messages::$validateFail,
				'messages' => $valdate->messages()],
				403);
		}
		else
		{
			$details = Input::all();
			$details['password'] = Hash::make('changeme');


		    if(User::create($details))
	        	return Response::json(['alert' => Messages::$createSuccess.'user'], 200);
	        else
	        	return Response::json(['alert' => Messages::$createFail.'user'], 500);
	   	}
	}

	
	public function show($id)
	{
		$user = User::find($id);
		if($user)
			return Response::json($user);
		else
			return Response::json(['alert' => 'User'.Messages::$notFound], 404);
	}

	
	public function update($id)
	{
		$details = Input::all();
		$user = User::find($id);

		//change password
		if(Input::has('oldPassword') && Input::has('newPassword'))
		{
			$validate = Validator::make(Input::all(), User::$newPasswordUpdateRules);

			$credentials = ['email' => $user['email'],
							'password' => $details['oldPassword']];
			if(!(Auth::validate($credentials)))
			{
				return Response::json(['alert' => 'Old password does not match']);
			}
			else
			{
				$details['email'] = Input::get('email');
				$details['password'] = Hash::make(Input::get('newPassword'));
				if($user->update($details))
		        	return Response::json(['alert' => Messages::$updateSuccess.'password'], 200);
		        else
		        	return Response::json(['alert' => Messages::$updateFail.'password'], 500);
			}
		}

		//update only email
		else
		{
			$validate = Validator::make(Input::all(), User::$emailUpdateRules);
		
			if($validate->fails())
			{
				return Response::json(['alert' => Messages::$validateFail,
					'messages' => $validate->messages()],
					403);
			}

			else
			{
		        if($user->update($details))
		        	return Response::json(['alert' => Messages::$updateSuccess.'email'], 200);
		        else
		        	return Response::json(['alert' => Messages::$updateFail.'email'], 500);
		   	}
	   	}	
	}

	
	public function destroy($id)
	{
		if(User::destroy($id))
			return Response::json(['alert' => Messages::$deleteSuccess.'user']);
		else
			return Response::json(['alert' => Messages::$deleteFail.'user']);
	}
}