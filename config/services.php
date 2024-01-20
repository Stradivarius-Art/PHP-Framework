<?php

use Artem\PhpFramework\Http\Kernel;
use League\Container\Argument\Literal\ArrayArgument;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Artem\PhpFramework\Routing\RouteContracts\RouterInterface;
use Artem\PhpFramework\Routing\Router;

$routes = include BASE_PATH . '/routes/web.php';
$container = new Container();

$container->add(RouterInterface::class, Router::class);

$container->delegate(new ReflectionContainer(true));

$container->extend(RouterInterface::class)
    ->addMethodCall(
        'registerRoutes',
        [new ArrayArgument($routes)]
    );

$container->add(Kernel::class)
    ->addArguments([RouterInterface::class, $container]);

return $container;
