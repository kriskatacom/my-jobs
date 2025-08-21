<?php

namespace App\Controllers;

use Core\MailService;
use Core\Router;
use Core\View;
use Core\Database;

use App\Validations\UserValidator;
use App\Repositories\UserRepository;
use App\Services\UserService;

require_once dirname(__DIR__) . '/helpers/languages.php';

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

    public function getResetPassword(): void
    {
        // $captchaBase64 = $this->generateCaptchaBase64();

        View::render('users/reset-password', [
            'title' => 'Възстановяване на паролата',
            'captcha' => ''
        ]);
    }

    public function postResetPassword(): void
    {
        $data = $_POST;
        
        if ($error = UserValidator::validateResetPassword($data, $this->userRepository)) {
            View::render('users/login', ['title' => 'Вход', 'error' => $error, 'captcha' => $this->generateCaptchaBase64()]);
            return;
        }

        $user = $this->userRepository->findByEmail($data['email']);

        $token = bin2hex(random_bytes(32));
        $resetLink = Router::getDomain() . '/users/change-password' . '/' . $token;
        $fullName = UserService::splitFullName($user['name']);
        $this->userRepository->savePasswordResetToken($token, $user['id']);

        $html = MailService::renderTemplatePlaceholders(
            file_get_contents(dirname(__DIR__) . '/views/email-templates/forgot-password-bg.php'),
            [
                'website_name' => __('website_title'),
                'first_name' => $fullName['firstName'],
                'reset_link' => $resetLink
            ]
        );

        $mail = new MailService();
        $result = $mail->send($user['email'], __('reset_password'), $html);

        if ($result) {
            $_SESSION['message_success'] = __('forgot_password_sent');
            View::redirect('/users/login');
        } else {
            View::render('users/forgot_password', [
                'title' => __('forgot_password_title'),
                'error' => ['email' => __('email_send_failed')]
            ]);
        }
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
