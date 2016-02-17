<?php

class PatternController extends \BaseController {

	public function index($departmentId)
	{
		$patterns = Department::find($departmentId)->patterns()->orderBy('name')->get();
    return Response::json([
      'patterns' => $patterns
    ], 200);
	}


	public function store($departmentId)
	{
		$details = Input::all();
		$details['department_id'] = $departmentId;

		$validate = Validator::make($details, Pattern::$rules);

		if($validate->fails())
		{
      return Response::json([
        'alert' => Messages::$validateFail,
        'messages' => $validate->messages()
      ], 403);
		}
		else
		{
			if($pattern = Pattern::create($details))
        return Response::json([
          'pattern' => $pattern,
          'alert' => Messages::$createSuccess.'pattern'
        ], 200);
        else
          return Response::json([
            'alert' => Messages::$createFail.'pattern'
          ], 500);
		}
	}


	public function show($departmentId, $patternId)
	{
		$pattern = Pattern::find($patternId);
		if($pattern)
      return Response::json([
        'pattern' => $pattern,
        'alert' => ''
      ], 200);
		else
      return Response::json([
        'alert' => 'Pattern'.Messages::$notFound
      ], 404);
	}


	public function update($departmentId, $patternId)
	{
		$pattern = Pattern::find($patternId);
		$details = Input::all();

		if($pattern)
		{
			if($pattern->update($details))
        return Response::json([
          'alert' => Messages::$updateSuccess.'pattern'
        ], 200);
		    else
          return Response::json([
            'alert' => Messages::$updateFail.'pattern'
          ], 500);
		}
		else
      return Response::json([
        'alert' => 'Pattern'.Messages::$notFound
      ], 404);
	}


	public function destroy($departmentId, $patternId)
	{
		$pattern = Pattern::find($patternId);

		if($pattern)
		{
			if($pattern->delete())
        return Response::json([
          'alert' => Messages::$deleteSuccess.'pattern'
        ], 200);
		    else
          return Response::json([
            'alert' => Messages::$deleteFail.'pattern'
          ], 500);
		}
		else
      return Response::json([
        'alert' => 'Pattern'.Messages::$notFound
      ], 404);
	}

}
