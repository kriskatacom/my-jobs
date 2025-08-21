<?php

namespace App\Repositories;

use App\Validations\CategoryValidator;
use PDO;

class CategoryRepository
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function create(array $data): string|array
    {
        if ($error = CategoryValidator::validateCreate($data)) {
            return $error;
        }

        if ($this->findByName($data['title'])) {
            return "Категория с това име вече съществува.";
        }

        $sql = "INSERT INTO job_categories (category_id, title, description, icon_url)
            VALUES (:category_id, :title, :description, :icon_url)";

        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            ':category_id' => $data['category_id'] ?? null,
            ':title' => $data['title'],
            ':description' => $data['description'] ?? null,
            ':icon_url' => $data['icon_url'] ?? null,
        ]);

        if (!$success) {
            return "Грешка при създаване на категория.";
        }

        $id = $this->db->lastInsertId();
        return $this->findById($id);
    }

    public function all(int $categoryId = null): array
    {
        if ($categoryId !== null) {
            $stmt = $this->db->prepare("SELECT * FROM job_categories WHERE category_id = :id ORDER BY id DESC");
            $stmt->execute(['id' => $categoryId]);
        } else {
            $stmt = $this->db->query("SELECT * FROM job_categories WHERE category_id IS NULL ORDER BY id DESC");
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function findByName(string $title): ?array
    {
        $stmt = $this->db->prepare("SELECT * FROM job_categories WHERE title = :title LIMIT 1");
        $stmt->execute([':title' => $title]);
        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        return $category ?: null;
    }

    public function findById(int $id): array|null
    {
        $sql = "SELECT * FROM job_categories WHERE id = :id LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([':id' => $id]);

        $category = $stmt->fetch(PDO::FETCH_ASSOC);

        return $category ?: null;
    }
}