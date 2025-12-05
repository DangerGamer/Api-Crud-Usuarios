<?php
use App\core\Router;
use App\controllers\UserController;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/config/config.php';

$router = new Router();
$userController = new UserController();

$router->add('GET', '/users', [$userController, 'index']);
$router->add('GET', '/users/show', function() use ($userController) {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'Parámetro id requerido']);
        return;
    }
    $userController->show((int)$id);
});
$router->add('POST', '/users', [$userController, 'store']);
$router->add('DELETE', '/users/delete', function() use ($userController) {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'Parámetro id requerido']);
        return;
    }
    $userController->destroy((int)$id);
});

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
