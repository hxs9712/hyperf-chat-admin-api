<?php

declare(strict_types=1);

/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://hyperf.wiki
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf/hyperf/blob/master/LICENSE
 */

use Hyperf\HttpServer\Router\Router;

Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');
Router::addRoute(['GET', 'POST', 'HEAD'], '/testdb', 'App\Controller\IndexController@testdb');

Router::get('/favicon.ico', function () {
    return '';
});
Router::addRoute(['POST'], '/login', 'App\Controller\LoginController@login');

// 该 Group 下的所有路由都将应用配置的中间件
Router::addGroup(
    '/admin', function () {
    Router::addGroup(
        '/user', function () {
        //获取用户列表
        Router::get('/list', 'App\Controller\UserController@getUserList');
        //编辑用户
        Router::post('/edit', 'App\Controller\UserController@editUser');
        //发起聊天
        Router::post('/buildChat', 'App\Controller\UserController@buildChat');
    });

    Router::addGroup(
        '/chat', function () {
        //获取聊天记录
        Router::post('/record', 'App\Controller\ChatController@getChatRecord');
        //获取用户列表
        Router::get('/userlist', 'App\Controller\ChatController@getUserList');
        //建立聊天室
        Router::post('/buildChatRoom', 'App\Controller\ChatController@buildChatRoom');
        //获取聊天室
        Router::post('/getChatRoom', 'App\Controller\ChatController@getChatRoom');
        //获取聊天室聊天记录
        Router::post('/getChatRoomRecord', 'App\Controller\ChatController@getChatRoomRecord');
        //未读消息-1
        Router::post('/reduceUnread', 'App\Controller\ChatController@reduceUnread');
    });
    Router::addServer('ws', function () {
        Router::get('/', 'App\Controller\WebSocketController');
    });
},
    ['middleware' => [\App\Middleware\ValidateToken::class]]
);

