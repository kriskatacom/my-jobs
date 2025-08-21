<?php

namespace App\Controllers;

use Core\Database;

use App\Repositories\CategoryRepository;

require_once dirname(__DIR__) . '/Helpers/languages.php';

use Core\View;

class HomeController
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
        $categories = $this->categoryRepository->all();
        
        View::render('index/home', [
            'title' => __('home'),
            'categories'=> $categories
        ]);
    }
}
