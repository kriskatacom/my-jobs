<?php

namespace App\Controllers;

use Core\Database;
use Core\View;
use App\Services\CategoryService;
use App\Repositories\CategoryRepository;

require_once dirname(__DIR__) . '/Helpers/languages.php';

class CategoryController
{
    private $db;
    private $categoryRepository;
    private $categoryService;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->categoryRepository = new CategoryRepository($this->db);
        $this->categoryService = new CategoryService($this->categoryRepository);
    }

    public function index()
    {
        View::render('category/listing', ['title' => __('categories')]);
    }

    public function getAll()
    {
        $perPage = 10;
        $currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

        $data = $this->categoryService->getPaginatedCategories($perPage, $currentPage);

        View::render('/dashboard/categories/index', array_merge([
            'title' => __('categories'),
        ], $data));
    }
}
