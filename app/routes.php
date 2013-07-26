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

Route::get('signup','MemberController@signupForm');
Route::post('signup','MemberController@signup'); 

Route::get('login','MemberController@loginForm');
Route::post('login','MemberController@login'); 

Route::post('member/modify','MemberController@modify'); 

Route::get('member/list','MemberController@memberList'); 
Route::get('member/view/{id?}','MemberController@view'); 

Route::get('member/leave','MemberController@leaveForm');
Route::post('member/leave','MemberController@leave'); 

Route::get('group/create','GroupController@createForm');
Route::resource('group','GroupController@create'); 
