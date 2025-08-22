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
}