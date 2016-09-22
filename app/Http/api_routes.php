<?php
	
$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

	$api->post('auth/login', 'App\Api\V1\Controllers\AuthController@login');
	$api->post('auth/signup', 'App\Api\V1\Controllers\AuthController@signup');
	$api->post('auth/fb_login', 'App\Api\V1\Controllers\AuthController@fb_login');
	$api->post('auth/fb_signup', 'App\Api\V1\Controllers\AuthController@fb_signup');
	$api->post('auth/recovery', 'App\Api\V1\Controllers\AuthController@recovery');
	$api->post('auth/reset', 'App\Api\V1\Controllers\AuthController@reset');


	$api->get('user/index','App\Api\V1\Controllers\UserController@index');
	$api->get('user/{name}','App\Api\V1\Controllers\UserController@get');
	$api->get('user/token/{token}','App\Api\V1\Controllers\UserController@getUserByToken');
	$api->get('user/id/{id}','App\Api\V1\Controllers\UserController@getUserById');
	$api->post('user/search','App\Api\V1\Controllers\UserController@search');
	$api->post('user/update','App\Api\V1\Controllers\UserController@update');
	$api->post('user/upload','App\Api\V1\Controllers\UserController@uploadImage');

	$api->post('connection/connect','App\Api\V1\Controllers\ConnectionController@connect');
	$api->post('connection/search_following','App\Api\V1\Controllers\ConnectionController@search_following');
    $api->post('connection/search_followers','App\Api\V1\Controllers\ConnectionController@search_followed');
	$api->post('connection/delete','App\Api\V1\Controllers\ConnectionController@delete');


	$api->get('post/index','App\Api\V1\Controllers\PostController@index');
	$api->post('post/store','App\Api\V1\Controllers\PostController@store');
	$api->post('post/search','App\Api\V1\Controllers\PostController@search');
	$api->post('post/searchbyid','App\Api\V1\Controllers\PostController@search_by_id');
	$api->post('post/feed','App\Api\V1\Controllers\PostController@news_feed');
	$api->post('post/upload','App\Api\V1\Controllers\PostController@image_upload');
	$api->post('post/delete','App\Api\V1\Controllers\PostController@delete');


	$api->post('baby/store','App\Api\V1\Controllers\BabyController@store');
	$api->post('baby/search','App\Api\V1\Controllers\BabyController@search');
	$api->post('baby/searchbyid','App\Api\V1\Controllers\BabyController@search_by_id');
	$api->post('baby/upload','App\Api\V1\Controllers\BabyController@image_upload');
	$api->post('baby/delete','App\Api\V1\Controllers\BabyController@delete');


    $api->post('like/press_like','App\Api\V1\Controllers\LikeController@press_like');
    $api->post('like/cancel_like','App\Api\V1\Controllers\LikeController@cancel_like');



    $api->post('comment/comment','App\Api\V1\Controllers\CommentController@comment');
    $api->post('comment/delete','App\Api\V1\Controllers\CommentController@delete_comment');


    $api->post('album/html2pdf','App\Api\V1\Controllers\AlbumController@htmltoPdf');






	// example of protected route
	$api->get('protected', ['middleware' => ['api.auth'], function () {		
		return \App\User::all();
    }]);

	// example of free route
	$api->get('free', function() {
		return \App\User::all();
	});

});
