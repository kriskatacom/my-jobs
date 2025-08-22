<?php

namespace App\Controllers;

use Core\Database;

use App\Repositories\UserRepository;
use App\Repositories\CategoryRepository;

require_once dirname(__DIR__) . '/Helpers/languages.php';

use Core\View;

class DashboardController
{
    private $db;
    private $categoryRepository;
    private $userRepository;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->categoryRepository = new CategoryRepository($this->db);
        $this->userRepository = new UserRepository($this->db);
    }
    
    public function index()
    {
        $categoryCount = $this->categoryRepository->getCategoryCount();
        $userCount = $this->userRepository->getUserCount();
        
        View::render('dashboard/index', [
            'title' => __('dashboard'),
            'categoryCount' => $categoryCount,
            'userCount' => $userCount,
        ]);
    }
}
