<?php

namespace App\Repositories;

use App\Validations\UserValidator;
use PDO;

class UserRepository
{
    protected PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function create(array $data): string|array
    {
        if ($error = UserValidator::validateCreate($data)) {
            return $error;
        }

        if ($this->findByEmail($data['email'])) {
            return "Потребител с този имейл адрес вече съществува.";
        }

        $sql = "INSERT INTO users (name, email, password, role)
            VALUES (:name, :email, :password, :role)";

        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
            ':role' => $data['role'] ?? 'user'
        ]);

        if (!$success) {
            return "Грешка при създаване на потребител.";
        }

        $id = $this->db->lastInsertId();
        return $this->findById($id);
    }

    public function findByEmail(string $email): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function findById(int $id): array|null
    {
        $sql = "SELECT * FROM users WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        return $category ?: null;
    }
}
