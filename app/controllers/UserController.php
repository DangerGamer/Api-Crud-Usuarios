<?php
namespace App\controllers;

use App\models\User;

class UserController {

    public function index(): void {
        $model = new User();
        $users = $model->getAll();
        echo json_encode(['success' => true, 'data' => $users, 'message' => '', 'error' => 'exito']);
    }

    public function show($id): void {
        $model = new User();
        $user = $model->getById((int)$id);

        if (!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'Usuario no encontrado']);
            return;
        }

        echo json_encode(['success' => true, 'data' => $user]);
    }

    public function store(): void {
        $body = json_decode(file_get_contents('php://input'), true);

        if (empty($body['name']) || empty($body['email'])) {
            http_response_code(400);
            echo json_encode(['error' => 'Campos requeridos: name, email']);
            return;
        }

        $model = new User();
        $ok = $model->create($body);

        echo json_encode([
            'success' => $ok,
            'message' => $ok ? 'Usuario creado correctamente' : 'Error al crear usuario'
        ]);
    }

    public function destroy($id): void {
        $model = new User();
        $ok = $model->delete((int)$id);
        echo json_encode([
            'success' => $ok,
            'message' => $ok ? 'Usuario eliminado' : 'Error al eliminar usuario'
        ]);
    }
}
