<?php
header('Access-Control-Allow-Origin: *');

Route::group(array('prefix' => 'api'), function() {

    Route::post('login','AuthenticationController@login');
    Route::get('logout','AuthenticationController@logout');

    // specify number of random questions required
    // Route::get('departments/{departmentId}/subjects/{subjectId}/random-questions', ['as' => 'random-questions', 'uses' => 'RandomGeneratorController@randomQuestions']);
    // Route::get('departments/{departmentId}/subjects/{subjectId}/random-main', ['as' => 'random-main', 'uses' => 'RandomGeneratorController@randomMain']);
    Route::post('departments/{departmentId}/subjects/{subjectId}/generate', ['as' => 'generate', 'uses' => 'RandomGeneratorController@generate']);

    Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);
    Route::put('users/{userId}/resetPassword', 'UserController@resetPassword');

    Route::resource('organizations', 'OrganizationController', ['except' => ['create', 'edit']]);


    Route::resource('organizations.departments', 'DepartmentController', ['except' => ['create', 'edit']]);
    Route::get('organizations/{organizationId}/departments/candidates', 'DepartmentController@candidates');


    Route::resource('departments.subjects', 'SubjectController', ['except' => ['create', 'edit']]);
    Route::get('organizations/{organizationId}/departments/{departmentId}/subjects/{subjectId}/units', 'SubjectController@getUnits');


    Route::resource('departments.subjects.questions', 'QuestionController', ['except' => ['create', 'edit']]);


    Route::resource('departments.subjects.questions.attachments', 'AttachmentController', ['except' => ['create', 'edit']]);


    Route::resource('departments.patterns', 'PatternController', ['except' => ['create', 'edit']]);

});
