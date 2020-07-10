<?php

use DI\ContainerBuilder;
use FastRoute\RouteCollector;
use League\Plates\Engine;
use Tamtamchik\SimpleFlash\Flash;

$containerBuilder = new ContainerBuilder;

$containerBuilder->addDefinitions([
    /**
     * @note Система шаблонов PHP
     * @see http://platesphp.com/ - полная документация
     */
    Engine::class => function() {
        return new Engine("../app/views");
    },

    /**
     * @note Флэш-уведомления
     * @see https://packagist.org/packages/tamtamchik/simple-flash - полная документация
     */
    Flash::class => function() {
        return new Flash();
    },
]);

$container = $containerBuilder->build();

// Все роуты приложения
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ["App\controllers\HomeController", "index"]);
    $r->addRoute('GET', '/dashboard', ["App\controllers\HomeController", "dashboard"]);
    $r->addRoute('POST', '/login/check', ["App\controllers\HomeController", "login"]);
    $r->addRoute('GET', '/logout', ["App\controllers\HomeController", "logout"]);
});


$httpMethod = $_SERVER['REQUEST_METHOD'];

$uri = $_SERVER['REQUEST_URI'];
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0])
{
    case FastRoute\Dispatcher::NOT_FOUND:
        // Ошибка 404. Страница не найдена
        echo "<div>404 ERROR. Go back</div>";
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        // Ошибка 405. Метод не разрешен
        echo "<div>405 ERROR. Go back</div>";
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        $container->call($handler, $vars);
        break;
}

