<?php

class SubjectController extends \BaseController {

	public function index($departmentId)
	{
		$subjects = Department::find($departmentId)->subjects()->orderBy('name')->get();
    return Response::json([
      'subjects' => $subjects,
      'alert' => ''
    ], 200);
	}


	public function store($departmentId)
	{
		$details = Input::all();
		$details['department_id'] = $departmentId;

		$validate = Validator::make($details, Subject::$rules);

		if($validate->fails())
		{
      return Response::json([
        'alert' => Messages::$validateFail,
        'messages' => $validate->messages()
      ], 403);
		}
		else
		{
			if($subject = Subject::create($details))
        return Response::json([
          'subject' => $subject,
          'alert' => Messages::$createSuccess.'subject'
        ], 200);
	      else
          return Response::json([
            'alert' => Messages::$createFail.'subject'
          ], 500);
		}
	}


	public function show($departmentId, $subjectId)
	{
		$subject = Subject::find($subjectId);
		if($subject)
      return Response::json([
        'subject' => $subject,
        'alert' => ''
      ], 200);
		else
      return Response::json([
        'alert' => 'Subject'.Messages::$notFound
      ], 404);
	}


	public function update($departmentId, $subjectId)
	{
		$subject = Subject::find($subjectId);
		$details = Input::all();

		if($subject)
		{
			if($subject->update($details))
        return Response::json([
          'alert' => Messages::$updateSuccess.'subject'
        ], 200);
		    else
          return Response::json([
            'alert' => Messages::$updateFail.'subject'
          ], 500);
		}
		else
      return Response::json([
        'alert' => 'Subject'.Messages::$notFound
      ], 404);
	}


	public function destroy($departmentId, $subjectId)
	{
		$subject = Subject::find($subjectId);

		if($subject)
		{
			if($subject->delete($details))
        return Response::json([
          'alert' => Messages::$deleteSuccess.'subject'
        ], 200);
		    else
          return Response::json([
            'alert' => Messages::$deleteFail.'subject'
          ], 500);
		}
		else
      return Response::json([
        'alert' => 'Subject'.Messages::$notFound
      ], 404);

	}

	public function getUnits($departmentId, $subjectId)
	{
		$units = Subject::find($subjectId)->questions()->lists('unit');
		$units = array_values(array_unique($units));
    return Response::json([
      'units' => $units,
      'alert' => ''
    ], 200);
	}

}
