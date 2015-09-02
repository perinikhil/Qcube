<?php

class QuestionController extends \BaseController {


	public function index($departmentId, $subjectId)
	{
		$questions = Subject::find($subjectId)->questions;
		foreach($questions as $question)
		{
			$question->attachment = Attachment::where('question_id', $question->id)->first();
		}
		return Response::json($questions);
	}


	public function store($departmentId, $subjectId)
	{
		$details = Input::all();
		$details['subject_id'] = $subjectId;

		$validate = Validator::make($details, Question::$rules);

		if($validate->fails())
		{
			return Response::json(['alert' => Messages::$validateFail,
				'messages' => $validate->messages()], 403);
		}
		else
		{
			// dd($file);
			if($question = Question::create($details))
				return Response::json(['question' => $question,
      		'alert' => Messages::$createSuccess.'question'],
      		200);
			else
	    	return Response::json(['alert' => Messages::$createFail.'question'], 500);
		}
	}


	public function show($departmentId, $subjectId, $questionId)
	{
		$question = Question::find($questionId);

		if($question)
		{
			$question->attachment = Attachment::where('question_id', $question->id)->first();
			return Response::json($question);
		}
		else
			return Response::json(['alert' => 'Question'.Messages::$notFound], 404);
	}


	public function update($departmentId, $subjectId, $questionId)
	{
		$question = Question::find($questionId);

		$details = Input::all();

		if($question)
		{
			if($question->update($details))
				return Response::json(['alert' => Messages::$updateSuccess.'question'], 200);
			else
      	return Response::json(['alert' => Messages::$updateFail.'question'], 500);
		}
		else
			return Response::json(['alert' => Messages::$notFound], 404);
	}

	public function destroy($departmentId, $subjectId, $questionId)
	{
		$question = Question::find($questionId);

		if($question)
		{
			if($question->delete())
				return Response::json(['alert' => Messages::$deleteSuccess.'question']);
			else
				return Response::json(['alert' => Messages::$deleteFail.'question']);
		}
		else
			return Response::json(['alert' => Messages::$notFound], 404);
	}

}
