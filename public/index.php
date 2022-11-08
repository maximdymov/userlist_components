<?php

if( !session_id() ) @session_start();

use App\Controllers\RegisterController;

require_once '../vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r)
{
    $r->addRoute('GET', '/register', ["App\Controllers\RegisterController", "index"]);
    $r->addRoute('POST', '/register', ["App\Controllers\RegisterController", "register"]);
    $r->addRoute('GET', '/auth', ["App\Controllers\AuthController", "index"]);
    $r->addRoute('POST', '/auth', ["App\Controllers\AuthController", "login"]);
    $r->addRoute('GET', '/logout', ["App\Controllers\AuthController", "logout"]);
    $r->addRoute('GET', '/', ["App\Controllers\HomeController", "index"]);
    $r->addRoute('GET', '/create_user', ["App\Controllers\CreateUserController", "index"]);
    $r->addRoute('POST', '/create_user', ["App\Controllers\CreateUserController", "createUser"]);
    $r->addRoute('GET', '/edit_user/{id:\d+}', ["App\Controllers\EditUserController", "index"]);
    $r->addRoute('POST', '/edit_user/{id:\d+}', ["App\Controllers\EditUserController", "editUser"]);


//    // {id} must be a number (\d+)
//    $r->addRoute('GET', '/user/{id:\d+}', 'get_user_handler');
//    // The /{title} suffix is optional
//    $r->addRoute('GET', '/articles/{id:\d+}[/{title}]', 'get_article_handler');
});



// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo 404;
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // ... 405 Method Not Allowed
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $controller = new $handler[0];

        call_user_func([$controller, $handler[1]], $vars);

        break;
}