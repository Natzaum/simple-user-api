<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

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