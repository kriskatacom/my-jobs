<?php

namespace App\Controllers;

require_once dirname(__DIR__) . '/Helpers/languages.php';

use Core\View;

class CategoryController
{
    public function index()
    {
        View::render('category/listing', ['title' => __('categories')]);
    }
}
