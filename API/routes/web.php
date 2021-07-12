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

    $router->post('/users', ['uses'=>'UsersController@register']);
    $router->post('/users/login', ['uses'=>'UsersController@login']);


    $router->group(['middleware'=>'user_auth'], function() use ($router){

        $router->get('/users/{id}/friends', ['uses'=>'UsersController@getUserFriends']);
        $router->get('/users/{id}', ['uses'=>'UsersController@getUser']);
        $router->get('/users/profile/{id}', ['uses'=>'UsersController@getUserProfile']);
        $router->patch('/users/{id}', ['uses'=>'UsersController@update']);
        $router->put('/users/see_notif/{bool}', ['uses'=>'UsersController@setSeeNotif']);
        $router->put('/users/see_msg/{bool}', ['uses'=>'UsersController@setSeeMsg']);

        $router->get('/user/friendrequest/incoming', ['uses'=>'FriendRequestController@getIncomingFriends']);
        $router->get('/user/friendrequest/outgoing', ['uses'=>'FriendRequestController@getOutgoingFriends']);
        $router->post('/user/friendrequest/{target_id}', ['uses'=>'FriendRequestController@sendRequest']);
        $router->put('/user/friendrequest/{sender_id}', ['uses'=>'FriendRequestController@acceptFriend']);
        $router->delete('/user/friendrequest/{target_id}', ['uses'=>'FriendRequestController@delete']);

        $router->get('/user/messages', ['uses'=>'UsersController@getFriendsChat']);
        $router->post('/user/messages/{target_id}', ['uses'=>'MessageController@sendMsg']);
        $router->get('/user/messages/{id}', ['uses'=>'UsersController@getMessages']);

        $router->post('/reactions', ['uses'=>'ReactionController@create']);
        $router->put('/reactions', ['uses'=>'ReactionController@update']);
        $router->delete('/reactions', ['uses'=>'ReactionController@delete']);


        $router->post('/posts', ['uses'=>'PostController@create']);
        $router->get('/posts/{limit}', ['uses'=>'PostController@userHome']);
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

        $router->get('/search/{search}', ['uses'=>'SearchController@generalSearch']);

    });
