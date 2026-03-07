<?php

require_once __DIR__ . '/../app/controllers/UserController.php';
require_once __DIR__ . '/../app/core/Router.php';

$router = new Router();

$router->get('/users', function(): void 
{
    $controller = new UserController();

    echo $controller->index();
});

$router->post('/users', function(): void
{
    $controller = new UserController();

    echo $controller->create();
});

$router->dispatch();