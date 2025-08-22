<?php

namespace App\Controllers;

use Core\Database;
use Core\View;
use App\Repositories\CategoryRepository;

require_once dirname(__DIR__) . '/Helpers/languages.php';


class CategoryController
{
    private $db;
    private $categoryRepository;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->categoryRepository = new CategoryRepository($this->db);
    }

    public function index()
    {
        View::render('category/listing', ['title' => __('categories')]);
    }

    public function getAll()
    {
        $perPage = 10;
        $currentPage = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $offset = ($currentPage - 1) * $perPage;
        
        $categories = $this->categoryRepository->findAll($perPage, $offset);
        $totalCategories = $this->categoryRepository->getCategoryCount();
        $totalPages = ceil($totalCategories / $perPage);

        View::render('/dashboard/categories/index', [
            'title' => __('categories'),
            'categories' => $categories,
            'totalPages' => $totalPages,
            'currentPage' => $currentPage,
        ]);
    }
}
