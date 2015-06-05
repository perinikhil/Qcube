<?php

class QuestionController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /question
	 *
	 * @return Response
	 */
	public function index($departmentId, $subjectId)
	{
		$questions = Subject::find($subjectId)->questions;
		return Response::json($questions);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /question/create
	 *
	 * @return Response
	 */
	// public function create()
	// {
	// 	//
	// }

	/**
	 * Store a newly created resource in storage.
	 * POST /question
	 *
	 * @return Response
	 */
	public function store($departmentId, $subjectId)
	{
		$details = Input::all();
		$details['subject_id'] = $subjectId;

		$validate = Validator::make($details, Question::$rules);

		if($validate->fails())
		{
			return Responese::json(['success' => false,
									'alert' => 'Failed to validate']);
		}
		else
		{
			if(Question::create($details))
	        	return Response::json(['success' => true,
	        							'alert' => 'Successfully added question']);
	        else
	        	return Response::json(['success' => false,
	        							'alert' => 'Failed to add question']);
		}
	}

	/**
	 * Display the specified resource.
	 * GET /question/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($departmentId, $subjectId, $questionId)
	{
		$question = Question::find($questionId);
		if($question && $question['subject_id']==$subjectId)
			return Response::json($question);
		else
			return Response::json(['success' => false,
	        						'alert' => 'Question not found']);
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /question/{id}/edit
	 *
	 * @param  int  $id
	 * @return Response
	 */
	// public function edit($id)
	// {
	// 	//
	// }

	/**
	 * Update the specified resource in storage.
	 * PUT /question/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($departmentId, $subjectId, $questionId)
	{
		$question = Question::find($questionId);
		$details = Input::all();
		$details['subject_id'] = $subjectId;

		$validate = Validator::make($details, Question::$rules);

		if($validate->fails())
		{
			return Response::json(['success' => false,
									'alert' => 'Failed to validate']);
		}
		else
		{
			if($question['subject_id']==$subjectId && $question->update($details))
	        	return Response::json(['success' => true,
	        							'alert' => 'Successfully updated question']);
	        else
	        	return Response::json(['success' => false,
	        							'alert' => 'Failed to update question']);
		}
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /question/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($departmentId, $subjectId, $questionId)
	{
		$question = Question::find($questionId);

		if($question['subject_id']==$subjectId && Question::destroy($questionId))
			return Response::json(['success' => true,
									'alert' => 'Successfully removed question']);
		else
			return Response::json(['success' => false,
									'alert' => 'Failed to remove question']);
	}

}