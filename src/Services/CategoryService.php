<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService
{
    private $repository;

    public function __construct(CategoryRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getPaginatedCategories(int $perPage, int $currentPage): array
    {
        $offset = ($currentPage - 1) * $perPage;

        $categories = $this->repository->findAll($perPage, $offset);
        $totalCategories = $this->repository->getCategoryCount();
        $totalPages = ceil($totalCategories / $perPage);

        return [
            'categories' => $categories,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
        ];
    }

    public function uploadImage(array $file): ?string
    {
        if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
        $fileType = mime_content_type($file['tmp_name']);

        if (!in_array($fileType, $allowedTypes)) {
            throw new \Exception("Invalid file type. Allowed: jpeg, png, gif, webp.");
        }

        $uploadDir = __DIR__ . '/../../public/uploads/categories/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = uniqid('cat_', true) . '.' . $extension;
        $filePath = $uploadDir . $fileName;

        if (!move_uploaded_file($file['tmp_name'], $filePath)) {
            throw new \Exception("Failed to upload file.");
        }

        return '/uploads/categories/' . $fileName;
    }
}
