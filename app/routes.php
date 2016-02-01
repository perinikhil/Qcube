<?php
header('Access-Control-Allow-Origin: *');

Route::get('/', function() {
  return View::make('index');
});

Route::group(array('prefix' => 'v1'), function() {

    Route::post('login','AuthenticationController@login');
    Route::get('logout','AuthenticationController@logout');

    Route::put('users/{userId}/reset-password', 'UserController@resetPassword');
    Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);

    Route::get('departments/candidates', 'DepartmentController@candidates');
    Route::resource('departments', 'DepartmentController', ['except' => ['create', 'edit']]);

    Route::post('departments/{departmentId}/subjects/{subjectId}/generate', ['as' => 'generate', 'uses' => 'RandomGeneratorController@generate']);

    Route::get('departments/{departmentId}/subjects/{subjectId}/units', 'SubjectController@getUnits');
    Route::resource('departments.subjects', 'SubjectController', ['except' => ['create', 'edit']]);

    Route::resource('departments.patterns', 'PatternController', ['except' => ['create', 'edit']]);

    Route::resource('departments.subjects.questions', 'QuestionController', ['except' => ['create', 'edit']]);

    Route::resource('departments.subjects.questions.attachments', 'AttachmentController', ['except' => ['create', 'edit']]);

});
