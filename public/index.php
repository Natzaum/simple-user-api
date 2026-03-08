<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

require_once __DIR__ . '/../app/controllers/UserController.php';
require_once __DIR__ . '/../app/core/Router.php';

$router = new Router();
$controller = new UserController();

$router->get('/users', [$controller, 'index']);
$router->post('/users', [$controller, 'create']);
$router->put('/users/{id}', [$controller, 'update']);
$router->delete('/users/{id}', [$controller, 'delete']);

$router->dispatch();