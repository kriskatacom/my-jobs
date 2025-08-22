<?php

namespace App\Controllers;

require_once dirname(__DIR__) . '/Helpers/languages.php';

use Core\View;

class DashboardController
{
    public function index()
    {
        View::render('dashboard/index', ['title' => __('dashboard')]);
    }
}
