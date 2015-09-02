<?php

class QuestionController extends \BaseController {


	public function index($departmentId, $subjectId)
	{
		$questions = Department::find($departmentId)->subjects()->find($subjectId)->questions;
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
	    {
				// if(Input::has('attachment'))
				// {
				// 	$file = Input::file('attachment');
				// 	if(self::storeAttachment($departmentId, $subjectId, $question->id, $file))
				// 		return Response::json(['question' => $question,
				// 			'alert' => Messages::$createSuccess.'question'],
				// 			200);
				// }
				// else
				return Response::json(['question' => $question,
      		'alert' => Messages::$createSuccess.'question'],
      		200);
	    }
			else
	    	return Response::json(['alert' => Messages::$createFail.'question'], 500);
		}
	}


	public function show($departmentId, $subjectId, $questionId)
	{
		// $question = Question::find($questionId);
		$question = Department::find($departmentId)->subjects()->find($subjectId)->questions()->find($questionId);

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
		$question = Department::find($departmentId)->subjects()->find($subjectId)->questions()->find($questionId);

		$details = Input::all();

		if($question)
		{
			if($question->update($details))
			{
				// if(Input::has('attachment'))
				// {
				// 	if(self::storeAttachment($departmentId, $subjectId, $question->id))
				// 		return Response::json(['alert' => Messages::$updateSuccess.'question'],
				// 			200);
				// }
	      return Response::json(['alert' => Messages::$updateSuccess.'question'], 200);
      }
			else
      	return Response::json(['alert' => Messages::$updateFail.'question'], 500);
		}
		else
			return Response::json(['alert' => Messages::$notFound], 404);
	}


	public function destroy($departmentId, $subjectId, $questionId)
	{
		$question = Department::find($departmentId)->subjects()->find($subjectId)->questions()->find($questionId);

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


	public function storeAttachment($departmentId, $subjectId, $questionId, $file)
	{
		if($hasAttachment = Attachment::where('question_id', $questionId)->first())
		{
			$destinationPath = app_path().'/uploads/attachments/';
			$fileName = $destinationPath . $hasAttachment->path;
			if($hasAttachment->delete())
				File::delete($fileName);
			else return false;
		}

		$extension = $file->getClientOriginalExtension();
		$fileName = $questionId . '_' . str_random(16) . '.' . $extension;
		$destinationPath = app_path() . '/uploads/attachments';
		$details['path'] = $fileName;
		if(($file->move($destinationPath, $fileName)))
		{
			if(Attachment::create($details))
			{
				return true;
			}
			else
			{
				File::delete($destinationPath.$fileName);
				return false;
			}
		}
		else
		{
			return false;
		}
	}


}
