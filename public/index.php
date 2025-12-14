<?php
use App\core\Router;
use App\controllers\UserController;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/config/config.php';

$router = new Router();
$userController = new UserController();

$router->add('GET', '/users', [$userController, 'index']);

$router->add('GET', '/users/filter', function() use ($userController) {
    $filter = $_GET['filter'] ?? null;
    if (!$filter) {
        http_response_code(400);
        echo json_encode(['error' => 'Parámetro filter requerido']);
        return;
    }
    $userController->filter($filter);
});

$router->add('GET', '/users/byid', function() use ($userController) {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'Parámetro id requerido']);
        return;
    }
    $userController->userById($id);
});

$router->add('PUT', '/users/update', function() use ($userController){
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (!$data) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "error" => "Los datos no se enviaron correctamente"
        ]);
        return;
    }

    echo json_encode($userController->updateUser($data));
});

$router->add('POST', '/users/create', function() use ($userController){
    $input = file_get_contents("php://input");
    $data = json_decode($input, true);

    if (!$data) {
        http_response_code(400);
        echo json_encode([
            "success" => false,
            "error" => "Los datos no se enviaron correctamente"
        ]);
        return;
    }

    echo json_encode($userController->createUser($data));
});

$router->add('DELETE', '/users/delete', function() use ($userController) {
    $id = $_GET['id'] ?? null;
    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'Parámetro id requerido']);
        return;
    }
    $userController->deteleUser((int)$id);
});

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
