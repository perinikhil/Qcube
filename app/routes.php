<?php

Route::get('/', function() {
    return View::make('hello');
});

Route::get('/hello', function() {
    $str = Auth::user()->email;
	return Response::json([$str], 200);
});

Route::group(array('prefix' => 'api'), function() {

    Route::post('login','AuthenticationController@login');
    Route::get('logout','AuthenticationController@logout');

    // specify number of random questions required
    // Route::get('departments/{departmentId}/subjects/{subjectId}/random-questions', ['as' => 'random-questions', 'uses' => 'RandomGeneratorController@randomQuestions']);
    // Route::get('departments/{departmentId}/subjects/{subjectId}/random-main', ['as' => 'random-main', 'uses' => 'RandomGeneratorController@randomMain']);

    Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);

    Route::resource('organizations', 'OrganizationController', ['except' => ['create', 'edit']]);


    Route::resource('organizations.departments', 'DepartmentController', ['except' => ['create', 'edit']]);


    Route::get('departments/{departmentId}/subjects/{subjectId}/units', 'SubjectController@getUnits');
    Route::resource('departments.subjects', 'SubjectController', ['except' => ['create', 'edit']]);


    Route::resource('departments.subjects.questions', 'QuestionController', ['except' => ['create', 'edit']]);


    Route::resource('departments.subjects.questions.attachments', 'AttachmentController', ['except' => ['create', 'edit']]);


    Route::resource('departments.patterns', 'PatternController', ['except' => ['create', 'edit']]);

});
