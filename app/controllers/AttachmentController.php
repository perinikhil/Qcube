<?php

class AttachmentController extends \BaseController {


	public function index($departmentId, $subjectId, $questionId)
	{
		$attachments = Department::find($departmentId)->subjects()->find($subjectId)->questions()->find($questionId)->attachments;
		return Response::json($attachments);
	}


	public function store($departmentId, $subjectId, $questionId)
	{
		$details = Input::all();
		$details['question_id'] = $questionId;

		if(Input::hasFile('attachment'))
		{
			if($hasAttachment = Attachment::where('question_id', $questionId)->first())
			{
				self::destroy($departmentId, $subjectId, $questionId, $hasAttachment->id);
			}
			$file = Input::file('attachment');
	        $extension = Input::file('Attachment')->getClientOriginalExtension();
	        $fileName = $questionId . '_' . str_random(16) . '.' . $extension;
	        $destinationPath = app_path() . '/uploads/attachments';
	        $details['path'] = $fileName;
	        if(($file->move($destinationPath, $fileName)))
	        {
	        	if(Attachment::create($details))
	        	{
	        		return Response::json(['alert' => Messages::$uploadSuccess.'attachment'], 200);
	        	}
	        	else
	        	{
	        		File::delete($destinationPath.$fileName);
	        		return Response::json(['alert' => Messages::$uploadFail.'attachment'], 500);
	        	}
	        }
	        else
	        {
						return Response::json(['alert' => Messages::$uploadFail.'attachment'], 500);
					}
		}
		else
		{
			return Response::json(['alert' => 'No attachment found'], 403);
		}
	}

	public function destroy($departmentId, $subjectId, $questionId, $attachmentId)
	{
		$attachment = Department::find($departmentId)->subjects()->find($subjectId)->questions()->find($questionId)->attachments()->find($attachmentId);

		if($attachment)
		{
			$destinationPath = app_path().'/uploads/attachments/';
			$fileName = $destinationPath . $attachment->path;
			if($attachment->delete())
			{
				File::delete($fileName);
				return Response::json(['alert' => Messages::$deleteSuccess.'attachment'], 200);
			}
			else
			{
				return Response::json(['alert' => Messages::$deleteFail.'attachment'], 500);
			}
		}
		else
		{
			return Response::json(['alert' => 'Attachment not found'], 404);
		}
	}
}

	// public function update($departmentId, $subjectId, $questionId, $attachmentId)
	// {
	// 	$attachment = Department::find($departmentId)->subjects()->find($subjectId)->questions()->find($questionId)->attachments()->find($attachmentId);
	// 	$oldAttachment = $attachment;
	// 	$destinationPath = app_path().'/uploads/attachments';
	//
	// 	if($attachment)
	// 	{
	// 		if(Input::hasFile('attachment'))
	// 		{
	// 			$newFile = Input::file('attachment');
	// 	        $extension = $newFile->getClientOriginalExtension();
	// 	        $newFileName = $questionId . '_' . str_random(16) . '.' . $extension;
	// 	        $details['path'] = $newFileName;
	// 	        if(($newFile->move($destinationPath, $newFileName)))
	// 	        {
	// 	        	if($attachment->update($details))
	// 	        	{
	// 	        		File::delete($destinationPath.$oldAttachment->path);
	// 	        		return Response::json(['alert' => 'Sucessfully uploaded attachment'], 200);
	// 	        	}
	// 	        	else
	// 	        	{
	// 	        		File::delete($destinationPath.$newFileName);
	// 	        		return Response::json(['alert' => 'Failed to update attachment'], 500);
	// 	        	}
	// 	        }
	// 	        else
	// 	        {
	// 	        	return Response::json(['alert' => 'Failed to upload attachment'], 404);
	// 	        }
	// 		}
	// 	}
	// }
