<?php

require_once __DIR__ . '/../app/controllers/UserController.php';
require_once __DIR__ . '/../app/config/Database.php';
require_once __DIR__ . '/../app/core/Router.php';

$conn = new Database();
$router = new Router();

$router->get('/users', function(): void 
{
    $controller = new UserController();

    echo $controller->index();
});

$router->dispatch();