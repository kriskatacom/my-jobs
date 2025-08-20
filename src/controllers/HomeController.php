<?php

namespace App\Controllers;

require_once dirname(__DIR__) . '/helpers/languages.php';

use Core\View;

class HomeController {
    public function index() {
        View::render('index/home', ['title' => __('home')]);
    }
}
