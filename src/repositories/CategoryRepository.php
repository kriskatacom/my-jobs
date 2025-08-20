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

    public function create(array $data): string|object
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
        return $stmt->execute([
            ':category_id' => $data['category_id'] ?? null,
            ':title' => $data['title'],
            ':description' => $data['description'] ?? null,
            ':icon_url' => $data['icon_url'] ?? null,
        ]);
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
}
