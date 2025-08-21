<?php

namespace App\Controllers;

use Core\View;
use Core\Database;
use App\Validations\UserValidator;

use App\Repositories\UserRepository;
use App\Services\UserService;

class UserController
{
    private $db;
    private $userRepository;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->userRepository = new UserRepository($this->db);

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    public function getRegister(): void
    {
        // Генерираме captcha като Base64
        // $captchaBase64 = $this->generateCaptchaBase64();

        View::render('users/register', [
            'title' => 'Регистрация',
            'captcha' => ''
        ]);
    }

    public function postRegister(): void
    {
        $data = $_POST;

        // Проверка на captcha
        // if (empty($data['captcha']) || strtolower($data['captcha']) !== strtolower($_SESSION['captcha'])) {
        //     $error = "Captcha е грешна.";
        //     View::render('users/register', ['title' => 'Регистрация', 'error' => $error, 'captcha' => $this->generateCaptchaBase64()]);
        //     return;
        // }

        if ($error = UserValidator::validateCreate($data)) {
            View::render('users/register', ['title' => 'Регистрация', 'error' => $error, 'captcha' => $this->generateCaptchaBase64()]);
            return;
        }

        $newUser = $this->userRepository->create($data);
        View::redirect('/');
    }

    public function getLogin(): void
    {
        // $captchaBase64 = $this->generateCaptchaBase64();

        View::render('users/login', [
            'title' => 'Вход',
            'captcha' => ''
        ]);
    }

    public function postLogin(): void
    {
        $data = $_POST;

        if ($error = UserValidator::validateLogin($data, $this->userRepository)) {
            View::render('users/login', ['title' => 'Вход', 'error' => $error, 'captcha' => $this->generateCaptchaBase64()]);
            return;
        }

        $user = $this->userRepository->findByEmail($data['email']);
        UserService::generateTokenAndSaveSession($user);

        View::redirect('/');
    }

    public function getLogout(): void
    {
        UserService::logout();
        View::redirect('/users/login');
    }

    private function generateCaptchaBase64(): string
    {
        return UserService::generateCaptchaBase64();
    }
}
