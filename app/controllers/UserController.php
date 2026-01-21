<?php
namespace App\controllers;

use App\models\User;

class UserController {

    private User $model;

    public function __construct() {
        $this->model = new User();
    }

    public function index(): void {
        $model = new User();
        $users = $model->getAll();
        echo json_encode(['success' => true, 'data' => $users, 'message' => '', 'error' => 'exito']);
    }

    public function filter($filter): void {
        $model = new User();
        $user = $model->getByFilter($filter);

        if (!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'Usuario no encontrado']);
            return;
        }

        echo json_encode(['success' => true, 'data' => $user]);
    }

    public function userById($id): void {
        $model = new User();
        $user = $model->userById($id);

        if (!$user) {
            http_response_code(404);
            echo json_encode(['error' => 'Usuario no encontrado']);
            return;
        }

        echo json_encode(['success' => true, 'data' => $user]);
    }


    public function updateUser(array $data): array {
        if (!isset($data['usu_id'])) {
            return ["success" => false, "error" => "ID requerido"];
        }

        return [
            "success" => $this->model->updateUser($data)
        ];
    }

    public function createUser(array $data): array {
        if (
            !isset($data['usu_id']) ||
            !isset($data['usu_nombre']) ||
            !isset($data['usu_papellido']) ||
            !isset($data['usu_direccion']) ||
            !isset($data['usu_telefono']) ||
            !isset($data['usu_correo']) ||
            !isset($data['usu_genero']) 
        ) {
            return ["success" => false, "error" => "Campos incompletos"];
        }

        return [
            "success" => $this->model->createUser($data)
        ];
    }

    public function deleteUsers(array $ids): void {
        $ok = $this->model->deleteUsers($ids);

        echo json_encode([
            'success' => $ok,
            'message' => $ok ? 'Usuarios eliminados' : 'Error al eliminar'
        ]);
    }


}
