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
				'messages' => $validate->messages()],
				403);
		}
		else
		{
			$details = Input::all();
			$details['password'] = Hash::make('changeme');
			if(Auth::check())
			{
				$details['department_id'] = Auth::user()->department_id;
				if($user = User::create($details))
        	return Response::json(['user' => $user,
						'alert' => Messages::$createSuccess.'user'], 200);
				else
	      	return Response::json(['alert' => Messages::$createFail.'user'], 500);
			}
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
		if(Input::has('old_password') && Input::has('new_password'))
		{
			$validate = Validator::make(Input::all(), User::$newPasswordUpdateRules);

			$credentials = ['email' => $user['email'],
							'password' => $details['old_password']];
			if(!(Auth::validate($credentials)))
			{
				return Response::json(['alert' => 'Old password does not match']);
			}
			else
			{
				$details['email'] = Input::get('email');
				$details['password'] = Hash::make(Input::get('new_password'));
				if($user->update($details))
		        	return Response::json(['alert' => Messages::$updateSuccess.'password'], 200);
		        else
		        	return Response::json(['alert' => Messages::$updateFail.'password'], 500);
			}
		}

		else
		{
	    if($user->update($details))
	    	return Response::json(['alert' => Messages::$updateSuccess.'email'], 200);
	    else
      	return Response::json(['alert' => Messages::$updateFail.'email'], 500);
		}
	}

	public function destroy($id)
	{
		if(User::destroy($id))
			return Response::json(['alert' => Messages::$deleteSuccess.'user']);
		else
			return Response::json(['alert' => Messages::$deleteFail.'user']);
	}

	public function resetPassword($id)
	{
		$user = User::find($id);
		$user->password = Hash::make('changeme');
		if($user->save())
			return Response::json(['alert' => Messages::$updateSuccess.'password'], 200);
		else
			return Response::json(['alert' => Messages::$updateFail.'password'], 500);
	}
}
