<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
    return response()->json(['message'=>'You are in the API'], 200);
});

$router->group(['middleware'=>'jsonHead'], function() use ($router){
    $router->post('/users', ['uses'=>'UsersController@register']);
    $router->post('/users/login', ['uses'=>'UsersController@login']);

    $router->group(['middleware'=>'user_auth'], function() use ($router){

        $router->get('/users/{id}', ['uses'=>'UsersController@getUser']);
        $router->patch('/users/{id}', ['uses'=>'UsersController@update']);

        $router->post('/reactions', ['uses'=>'ReactionController@create']);
        $router->put('/reactions', ['uses'=>'ReactionController@update']);
        $router->delete('/reactions', ['uses'=>'ReactionController@delete']);

    });

});

$router->group(['middleware'=>'user_auth'], function() use ($router){

    $router->post('/posts', ['uses'=>'PostController@create']);
    $router->post('/posts/{id}', ['uses'=>'PostController@update']);
    $router->delete('/posts/{id}', ['uses'=>'PostController@delete']);

    $router->get('/posts/reactions/{postid}/', ['uses'=>'ReactionController@getReactionsFromPost']);

    $router->get('/posts/comments/{postid}/', ['uses'=>'CommentController@getCommentsFromPost']);
    $router->post('/posts/comments/{postid}/', ['uses'=>'CommentController@createComment']);
    $router->post('/comments/responses/{commentid}/', ['uses'=>'CommentController@createResponse']);
    $router->get('/comments/responses/{commentid}/', ['uses'=>'CommentController@getResponsesFromComment']);
    $router->post('/comments/{commentid}', ['uses'=>'CommentController@update']);
    $router->delete('/comments/{commentid}', ['uses'=>'CommentController@delete']);

    $router->get('/posts/users/{userid}/{limit}', ['uses'=>'PostController@indexByUserId']);
});
