<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$api=app("Dingo\Api\Routing\Router");

$api->version('v1', ['prefix' => 'v1'], function($api){
	
	/**
	* Oauth routs
	**/
	$api->group(['prefix' => 'oauth'], function($api){
		$api->post('token', '\Laravel\Passport\Http\Controllers\AccessTokenController@issueToken');
	});


	/**
	* Note : To meet the client requirement, made the changes in 
	* Middleware/Authenticate.php page. Now middleware auth guard api and 
	* admin (auth:api, auth:admin) both can access the same routes. 
	* For future possibilities i have created another Middleware/
	* AdminOnlyAuthenticate.php "admin_auth"(given below) for providing 
	* only admin accessing routes (route group sample given below). Same 
	* way we can create user only routs too if needed.     
	**/

	/**
	* Routes that can only be access with Authentication 
	* both auth:api and auth:admin
	* 'middleware' => ['auth:api']] here now we can use any guard
	* auth:api or auth:admin both are able to access same routes.
	**/
	$api->group(['namespace' => 'App\Http\Controllers\V1', 'middleware' => ['auth:api', 'cors']], function($api){
		//User route
		$api->post('user/logout', 'UserController@logout');
		$api->post('user/change-password', 'UserController@changePassword');
		$api->post('user/update-email', 'UserController@updateUserEmail');

		$api->get('user/all', 'UserController@allUser');
		$api->get('user/view', 'UserController@viewUser');
		$api->post('user/add', 'UserController@addUser');
		$api->post('user/update', 'UserController@updateUser');
		$api->post('user/delete', 'UserController@deleteUser');
		
		//Synonym Reference routes
		$api->get('synonym-reference/all', 'SynonymReferenceController@allSynonymReference');
		$api->get('synonym-reference/view', 'SynonymReferenceController@viewSynonymReference');
		$api->post('synonym-reference/add', 'SynonymReferenceController@addSynonymReference');
		$api->post('synonym-reference/update', 'SynonymReferenceController@updateSynonymReference');
		$api->post('synonym-reference/delete', 'SynonymReferenceController@deleteSynonymReference');
		
		//Synonym De routes
		$api->get('synonym-de/all', 'SynonymDeController@allSynonymDe');
		$api->get('synonym-de/view', 'SynonymDeController@viewSynonymDe');
		$api->post('synonym-de/add', 'SynonymDeController@addSynonymDe');
		$api->post('synonym-de/update', 'SynonymDeController@updateSynonymDe');
		$api->post('synonym-de/delete', 'SynonymDeController@deleteSynonymDe');
		//Synonym En routes
		$api->get('synonym-en/all', 'SynonymEnController@allSynonymEn');
		$api->get('synonym-en/view', 'SynonymEnController@viewSynonymEn');
		$api->post('synonym-en/add', 'SynonymEnController@addSynonymEn');
		$api->post('synonym-en/update', 'SynonymEnController@updateSynonymEn');
		$api->post('synonym-en/delete', 'SynonymEnController@deleteSynonymEn');
	});

	/**
	* Routes that can only be access with Authentication auth:admin only
	* here another another middleware is added which is blocking the
	* the request if it is not admin. see Middleware/AdminOnlyAuthenticate.php
	**/
	$api->group(['namespace' => 'App\Http\Controllers\V1', 'middleware' => ['auth:api', 'admin_auth', 'cors']], function($api){
		//Controller route
		$api->get('user/test', 'AutorController@getTokenUser');
		
	});

	/**
	* Routes that can be access without Authentication
	**/
	$api->group(['namespace' => 'App\Http\Controllers\V1'], function($api){
		$api->post('user/signup', 'UserController@signUp');
		$api->post('user/login', 'UserController@login');
		$api->post('user/send-reset-password-link', 'UserController@sendResetPasswordLink');
		$api->post('user/reset-password', 'UserController@resetPassword');
		$api->get('user/test-email', 'UserController@testEmail');
	});
	
});
