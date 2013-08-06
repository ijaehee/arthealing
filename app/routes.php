<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::get('/', function()
{
	return View::make('hello');
});

App::bind('Program\Repositories\ProgramRepositoryInterface','Program\Repositories\DummyProgramRepository'); 

Route::get('signup','MemberController@signupForm');
Route::post('signup','MemberController@signup'); 

Route::get('login','MemberController@loginForm');
Route::post('login','MemberController@login'); 

Route::post('member/modify','MemberController@modify'); 
Route::get('member/modify/{id?}','MemberController@modifyForm'); 

Route::get('member/delete/{id?}','MemberController@destroy'); 

Route::get('member/list','MemberController@memberList'); 

Route::get('member/leave','MemberController@leaveForm');
Route::post('member/leave','MemberController@leave'); 

Route::get('group/create','GroupController@createForm');
Route::post('group/create','GroupController@create'); 

Route::get('group/list','GroupController@groupList'); 

Route::get('group/delete/{id?}','GroupController@destroy'); 

//Program
Route::get('program/form','ProgramController@createForm');
Route::post('program/create','ProgramController@register'); 
Route::get('program/list/{page?}/{searchKey?}/{searchValue?}','ProgramController@programList'); 
Route::get('program/form/{id?}','ProgramController@modifyForm'); 
Route::post('program/modify','ProgramController@register'); 
Route::get('program/delete/{id?}','ProgramController@destroy'); 

Route::get('register/list','RegisterController@registerList');

Route::get('register/create','RegisterController@createForm');
Route::post('register/create','RegisterController@register');

Route::get('register/activated/{id?}','RegisterController@activated');
Route::get('register/inactivated/{id?}','RegisterController@inactivated');

Route::get('register/modify/{id?}','RegisterController@modifyForm'); 
Route::post('register/modify','RegisterController@register'); 

Route::get('register/delete/{id?}','RegisterController@destroy'); 

Route::get('gate/list','GateController@tourList');

Route::get('gate/apply/{id?}','GateController@applyForm'); 
Route::post('gate/apply','GateController@apply'); 
