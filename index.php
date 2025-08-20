<?php

require __DIR__ . '/vendor/autoload.php';

use Core\Database;
use Core\Router;
use Dotenv\Dotenv;

use App\Controllers\HomeController;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$pdo = Database::getInstance()->getConnection();

$router = new Router();

$router->get('/', [HomeController::class, 'index']);

session_start();

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);