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
        $captchaBase64 = $this->generateCaptchaBase64();

        View::render('users/register', [
            'title' => __('register'),
            'captcha' => $captchaBase64,
            'data' => [],
        ]);
    }

    public function postRegister(): void
    {
        $data = $_POST;

        if ($error = UserValidator::validateCreate($data)) {
            View::render('users/register', [
                'title' => __('register'),
                'error' => $error,
                'captcha' => $this->generateCaptchaBase64()
            ]);
            return;
        }

        $this->userRepository->create($data);
        View::redirect('/users/login');
    }

    public function getLogin(): void
    {
        $captchaBase64 = $this->generateCaptchaBase64();

        View::render('users/login', [
            'title' => 'Вход',
            'data' => [],
            'captcha' => $captchaBase64,
        ]);
    }

    public function postLogin(): void
    {
        $data = $_POST;

        if ($error = UserValidator::validateLogin($data, $this->userRepository)) {
            View::render('users/login', [
                'title' => 'Вход',
                'error' => $error,
                'captcha' => $this->generateCaptchaBase64(),
                'data' => $data,
            ]);
            return;
        }

        $user = $this->userRepository->findByEmail($data['email']);
        UserService::generateTokenAndSaveSession($user);

        View::redirect('/');
    }

    public function getResetPassword(): void
    {
        $captchaBase64 = $this->generateCaptchaBase64();

        View::render('users/reset-password', [
            'title' => 'Възстановяване на паролата',
            'captcha' => $captchaBase64,
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

    public function getChangePassword(string $token): void
    {
        $user = $this->userRepository->findByPasswordResetToken($token);

        if (!$user || $user['token_expiration'] < time()) {
            $_SESSION['message_error'] = __('invalid_token');
            View::redirect('/users/reset-password');
        }

        $_SESSION['reset_token'] = $token;

        View::render('users/change-password', [
            'title' => __('change_password_title'),
            'token' => $token,
        ]);
    }

    public function postChangePassword(): void
    {
        $formData = $_POST;
        $errors = UserValidator::validateChangePassword($formData);

        if (!empty($errors)) {
            View::render('users/change_password', [
                'title' => __('change_password_title'),
                'errors' => $errors,
            ]);
            return;
        }

        $user = $this->userRepository->findByPasswordResetToken($_SESSION['reset_token']);
        if (!$user || $user['token_expiration'] < time()) {
            $_SESSION['message_error'] = __('invalid_token');
            View::redirect('/users/reset-password');
        }

        
        if (!$this->userRepository->updatePassword($user['id'])) {
            $_SESSION['message_error'] = __('password_change_failed');
            View::render('users/change-password', [
                'title' => __('change_password_title'),
                'error' => __('password_change_failed'),
            ]);
            return;
        }

        $_SESSION['message_success'] = __('password_changed_successfully');
        View::redirect('/users/login');
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