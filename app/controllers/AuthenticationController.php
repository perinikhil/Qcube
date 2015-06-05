<?php

class AuthenticationController extends \BaseController 
{

	public function login()
	{
		$rules = [
			'email' => 'required',
			'password' => 'required | alphaNum | min:3'
		];

		$validator = Validator::make(Input::all(), $rules);

		if ($validator->fails())
		{
			return Response::json([ 'alert' => Messages::$validateFail,
				'messages' => $validator->messages()],
				403);
		}
		else
		{
			$credentials = Input::only('email','password');

			if (Auth::attempt($credentials))
				return Response::json([	'alert' => Messages::$loginSuccess],
					200);
			else
				return Response::json(['alert' => Messages::$loginFail],
					403);
		}
	}

	public function logout()
	{
			if(Auth::logout())
				return Response::json(['alert' => Messages::$logoutSuccess],
					200);
			else
				return Response::json(['alert' => Messages::$logoutFail],
					500);
	}
}