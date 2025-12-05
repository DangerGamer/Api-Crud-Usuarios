<?php
namespace App\models;

use App\core\Database;
use PDO;

class User {
    public function getAll(): array {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM usuario ORDER BY usu_id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById(int $id): ?array {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM usuario WHERE usu_id = :id");
        $stmt->execute([':id' => $id]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function create(array $data): bool {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO usuario (usu_id, usu_nombre, usu_papellido, usu_sapellido, usu_direccion, usu_telefono, usu_correo) VALUES (NULL, :usu_nombre, :usu_papellido, :usu_sapellido, :usu_direccion, :usu_telefono, :usu_correo)");
        return $stmt->execute([
            ':usu_nombre' => $data['usu_nombre'],
            ':usu_papellido' => $data['usu_papellido'],
            ':usu_sapellido' => $data['usu_sapellido'],
            ':usu_direccion' => $data['usu_direccion'],
            ':usu_telefono' => $data['usu_telefono'],
            ':usu_correo' => $data['usu_correo'],
        ]);
    }

    public function delete(int $id): bool {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM usuario WHERE usu_id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
