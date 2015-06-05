<?php

class AttachmentController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 * GET /attachment
	 *
	 * @return Response
	 */
	public function index($departmentId, $subjectId, $questionId)
	{
		$attachments = Question::where('id', $questionId)->where('subject_id',$subjectId)->first()->attachments;
		return Response::json($attachments);
	}

	/**
	 * Show the form for creating a new resource.
	 * GET /attachment/create
	 *
	 * @return Response
	 */
	// public function create()
	// {
	// 	//
	// }

	/**
	 * Store a newly created resource in storage.
	 * POST /attachment
	 *
	 * @return Response
	 */
	public function store($departmentId, $subjectId, $questionId)
	{
		$details = Input::all();
		$details['question_id'] = $questionId;

		if(Input::hasFile('attachment'))
		{
			$file = Input::file('attachment');
	        $extension = $file->getClientOriginalExtension();
	        $fileName = $questionId . '_' . str_random(16) . '.' . $extension;
	        $destinationPath = 'uploads/attachments';
	        $details['attachment'] = $fileName;
	        if(($file->move($destinationPath, $fileName)))
	        {
	        	if(Attachment::create($details))
	        	{
	        		return Response::json(['success' => true,
	        								'alert' => 'Sucessfully uploaded attachment']);
	        	}
	        	else
	        	{
	        		File::delete($destinationPath.$fileName);
	        		return Response::json(['success' => false,
	        								'alert' => 'Failed to upload attachment']);
	        	}
	        }
	        else
	        {
	        	return Response::json(['success' => false,
	        								'alert' => 'Failed to upload attachment']);
	        }
		}
		else
		{
			return Response::json(['success' => false,
									'alert' => 'No attachment found']);
		}
	}

	/**
	 * Display the specified resource.
	 * GET /attachment/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}

	/**
	 * Show the form for editing the specified resource.
	 * GET /attachment/{id}/edit
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
	 * PUT /attachment/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /attachment/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($departmentId, $subjectId, $questionId, $attachmentId)
	{
		$attachment = Attachment::where('id', $attachmentId)->where('question_id',$questionId)->first();
		if(Question::where('id', $questionId)->where('subject_id', $subjectId)->first())
		{
			$destinationPath = 'uploads/attachments/';
			$fileName = $destinationPath . $attachment->attachment;
			if($attachment->delete())
			{
				File::delete($fileName);
				return Response::json(['success' => true,
										'alert' => 'Successfully deleted attachment']);
			}
			else
			{
				return Response::json(['success' => false,
										'alert' => 'Failed to delete attachment']);
			}
		}
		else
		{
			return Response::json(['success' => false,
									'alert' => 'Attachment not found']);
		}
	}
}