<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/vendor/autoload.php';

use Core\Database;
use Core\Router;
use Dotenv\Dotenv;

use App\Controllers\HomeController;
use App\Controllers\UserController;

$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();

$pdo = Database::getInstance()->getConnection();

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->get('/users/register', [UserController::class, 'getRegister']);

session_start();

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
