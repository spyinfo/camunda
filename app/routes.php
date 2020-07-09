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
]);

$container = $containerBuilder->build();

// Все роуты приложения
$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ["App\controllers\HomeController", "index"]);
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
