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
        $categories = $this->categoryRepository->findAll();

        View::render('/dashboard/categories/index', [
            'title' => __('categories'),
            'categories' => $categories,
        ]);
    }
}