<?php

use App\Middlewares\IsAuthenticated;
use App\Middlewares\IsNotAuthenticated;
use App\Services\UserService;

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
$router->get('/users/register', [UserController::class, 'getRegister'], [IsNotAuthenticated::class]);
$router->get('/users/login', [UserController::class, 'getLogin'], [IsNotAuthenticated::class]);
$router->get('/users/logout', [UserController::class, 'getLogout'], [IsAuthenticated::class]);
$router->get('/users/reset-password', [UserController::class, 'getResetPassword'], [IsNotAuthenticated::class]);

$router->post('/users/register', [UserController::class, 'postRegister'], [IsNotAuthenticated::class]);
$router->post('/users/login', [UserController::class, 'postLogin'], [IsNotAuthenticated::class]);
$router->post('/users/reset-password', [UserController::class, 'postResetPassword'], [IsNotAuthenticated::class]);

session_start();

UserService::validateAndSetUserFromToken();

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
