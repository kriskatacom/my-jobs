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



        $numberOfUsers = $this->getUserCount($this->db);
        $role = $numberOfUsers === 0 ? 'admin' : 'user';

        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
            ':role' => $role,
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

    public function savePasswordResetToken(string $token, int $userId): bool
    {
        $expiration = time() + 3600;

        $stmt = $this->db->prepare("
        UPDATE users 
        SET password_reset_token = :token, token_expiration = :expiration 
        WHERE id = :id
    ");

        return $stmt->execute([
            ':token' => $token,
            ':expiration' => $expiration,
            ':id' => $userId
        ]);
    }

    public function findByPasswordResetToken(string $token): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE password_reset_token = :token LIMIT 1");
        $stmt->execute([':token' => $token]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    public function updatePassword(int $userId): bool
    {
        $stmt = $this->db->prepare("
        UPDATE users 
        SET password = :password, 
            password_reset_token = :token, 
            token_expiration = :expiration 
        WHERE id = :id
    ");

        return $stmt->execute([
            ':password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            ':token' => null,
            ':expiration' => null,
            ':id' => $userId
        ]);
    }

    public function getUserCount(PDO $pdo): int
    {
        $stmt = $pdo->query("SELECT COUNT(*) FROM users");
        return (int) $stmt->fetchColumn();
    }
}