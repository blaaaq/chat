<?php

use App\Config\Config;

define('ROOT', __DIR__ . '/../');


require ROOT . 'vendor/autoload.php';


set_error_handler('App\Core\Error::errorHandler');
set_exception_handler('App\Core\Error::exceptionHandler');


header('Access-Control-Allow-Origin: '. Config::CLIENT_FULL_URL());
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Credentials: true');


$router = new App\Core\Router();


$router->add('posts/{id:\d+}/index', ['controller' => 'User', 'action' => 'index2']);
$router->add('api/auth', ['controller' => 'Auth', 'action' => 'auth']);
$router->add('api/register', ['controller' => 'Register', 'action' => 'register']);
$router->add('api/auth/check', ['controller' => 'AuthCheck', 'action' => 'check']);
$router->add('api/logout', ['controller' => 'Logout', 'action' => 'logout']);

$router->add('api/messages/last', ['controller' => 'LastMessages', 'action' => 'view']);
$router->add('api/messages/from/{id:\d+}', ['controller' => 'MessagesFromId', 'action' => 'view']);
//$router->add('api/message/send', ['controller' => 'SendMessage', 'action' => 'view']);
$router->add('api/message/loadfile', ['controller' => 'LoadFile', 'action' => 'load']);

$router->add('api/ws/send', ['controller' => 'WS', 'action' => 'view']);


$router->dispatch($_SERVER['QUERY_STRING']);
