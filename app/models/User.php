<?php
namespace App\models;

use App\core\Database;
use PDO;

class User {

    private PDO $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAll(): array {
        $stmt = $this->db->query("SELECT * FROM usuario ORDER BY usu_id ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByFilter(string $filter): ?array {
        $stmt = $this->db->prepare("SELECT * FROM usuario WHERE usu_nombre LIKE :filter OR usu_papellido LIKE :filter OR usu_sapellido LIKE :filter OR usu_correo LIKE :filter");
        $param = "%$filter%";
        $stmt->bindValue(':filter', $param, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function userById(int $id): ?array {
        $stmt = $this->db->prepare("SELECT * FROM usuario WHERE usu_id = :id LIMIT 1");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ?: null;
    }

    public function updateUser(array $data): bool {
        $stmt = $this->db->prepare("
            UPDATE usuario SET
                usu_nombre     = :nombre,
                usu_papellido  = :papellido,
                usu_sapellido  = :sapellido,
                usu_direccion  = :direccion,
                usu_telefono   = :telefono,
                usu_correo     = :correo,
                usu_genero     = :genero
            WHERE usu_id = :id
        ");

        return $stmt->execute([
            ':nombre'     => $data['usu_nombre'],
            ':papellido'  => $data['usu_papellido'],
            ':sapellido'  => $data['usu_sapellido'],
            ':direccion'  => $data['usu_direccion'],
            ':telefono'   => $data['usu_telefono'],
            ':correo'     => $data['usu_correo'],
            ':genero'     => $data['usu_genero'],
            ':id'         => $data['usu_id']
        ]);
    }

    public function createUser(array $data): bool {
        $stmt = $this->db->prepare("INSERT INTO usuario (usu_id, usu_nombre, usu_papellido, usu_sapellido, usu_direccion, usu_telefono, usu_correo, usu_genero) VALUES (NULL, :usu_nombre, :usu_papellido, :usu_sapellido, :usu_direccion, :usu_telefono, :usu_correo, :usu_genero)");
        return $stmt->execute([
            ':usu_nombre' => $data['usu_nombre'],
            ':usu_papellido' => $data['usu_papellido'],
            ':usu_sapellido' => $data['usu_sapellido'],
            ':usu_direccion' => $data['usu_direccion'],
            ':usu_telefono' => $data['usu_telefono'],
            ':usu_correo' => $data['usu_correo'],
            ':usu_genero' => $data['usu_genero']
        ]);
    }

    public function deteleUser(int $id): bool {
        $stmt = $this->db->prepare("DELETE FROM usuario WHERE usu_id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
