<?php

class Messages {
	public static $createSuccess = 'Created ';
	public static $updateSuccess = 'Updated ';
	public static $deleteSuccess = 'Deleted ';
	public static $uploadSuccess = 'Uploaded ';

	public static $createFail = 'Failed to create ';
	public static $updateFail = 'Failed to update ';
	public static $deleteFail = 'Failed to delete ';
	public static $uploadFail = 'Failed to upload ';

	public static $notFound = ' not found!';
	public static $validateFail = 'Validations have failed';

	public static $loginSuccess = 'Logged in';
	public static $alreadyLoggedIn = 'Already logged in';
	public static $loginFail = 'Username or Password incorrect';
	public static $logoutSuccess = 'Logged out';
	public static $logoutFail = 'Failed to logout';

  public static function showAlert ($subjectId, $paperData) {
    $subject = Subject::find($subjectId);
    $fileName = public_path() . '/uploads/tmp/' . $subject->semester . '_' . $subject->abbr;
    File::put($fileName, date('d-m-Y') . "\n\n");
    File::append($fileName, $subject . "\n\n");
    foreach($paperData as $section)
      foreach($section as $main)
        foreach($main["questions"] as $question)
          File::append($fileName, $question->text . "    (" . $question->marks . ")\n\n");
  }
}
