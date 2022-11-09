<?php

if (!session_id()) @session_start();

use Aura\SqlQuery\QueryFactory;
use Delight\Auth\Auth;
use DI\ContainerBuilder;
use League\Plates\Engine;

require_once '../vendor/autoload.php';

$containerBuilder = new ContainerBuilder();

$containerBuilder->addDefinitions([
    Engine::class => function () {
        return new Engine('../app/views');
    },
    PDO::class => function () {
        return new PDO("mysql:host=localhost;dbname=userlist", 'root', '1234');
    },
    Auth::class => function ($container) {
        return new Delight\Auth\Auth($container->get('PDO'));
    },
    QueryFactory::class => function () {
        return new QueryFactory('mysql');
    }
]);
$container = $containerBuilder->build();

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/register', ["App\Controllers\RegisterController", "index"]);
    $r->addRoute('POST', '/register', ["App\Controllers\RegisterController", "register"]);

    $r->addRoute('GET', '/auth', ["App\Controllers\AuthController", "index"]);
    $r->addRoute('POST', '/auth', ["App\Controllers\AuthController", "login"]);
    $r->addRoute('GET', '/logout', ["App\Controllers\AuthController", "logout"]);

    $r->addRoute('GET', '/', ["App\Controllers\HomeController", "index"]);

    $r->addRoute('GET', '/create_user', ["App\Controllers\CreateUserController", "index"]);
    $r->addRoute('POST', '/create_user', ["App\Controllers\CreateUserController", "createUser"]);

    $r->addRoute('GET', '/delete/{id:\d+}', ["App\Controllers\DeleteUserController", "index"]);

    $r->addRoute('GET', '/edit_user/{id:\d+}', ["App\Controllers\EditController", "editInfo"]);
    $r->addRoute('POST', '/edit_user/{id:\d+}', ["App\Controllers\EditController", "editInfo"]);

    $r->addRoute('GET', '/status/{id:\d+}', ["App\Controllers\EditController", "editStatus"]);
    $r->addRoute('POST', '/status/{id:\d+}', ["App\Controllers\EditController", "editStatus"]);

    $r->addRoute('GET', '/media/{id:\d+}', ["App\Controllers\EditController", "editImage"]);
    $r->addRoute('POST', '/media/{id:\d+}', ["App\Controllers\EditController", "editImage"]);

    $r->addRoute('GET', '/security/{id:\d+}', ["App\Controllers\EditController", "editSecurity"]);
    $r->addRoute('POST', '/security/{id:\d+}', ["App\Controllers\EditController", "editSecurity"]);

    $r->addRoute('GET', '/profile/{id:\d+}', ["App\Controllers\ProfileController", "index"]);
});


$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];


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
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        $container->call($handler, $vars);
        break;
}