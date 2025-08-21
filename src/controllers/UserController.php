<?php
// UserController.php

namespace App\Controllers;

use Core\View;
use Core\Database;
use App\Validations\UserValidator;

class UserController
{
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
    }

    // Показва формата за регистрация
    public function getRegister(): void
    {
        // Генерираме captcha като Base64
        // $captchaBase64 = $this->generateCaptchaBase64();

        View::render('users/register', [
            'title' => 'Регистрация',
            'captcha' => ''
        ]);
    }

    // Създаване на нов потребител
    public function postRegister(): void
    {
        $data = $_POST;

        // Проверка на captcha
        // if (empty($data['captcha']) || strtolower($data['captcha']) !== strtolower($_SESSION['captcha'])) {
        //     $error = "Captcha е грешна.";
        //     View::render('users/register', ['title' => 'Регистрация', 'error' => $error, 'captcha' => $this->generateCaptchaBase64()]);
        //     return;
        // }

        // Валидация на потребителя
        if ($error = UserValidator::validateCreate($data)) {
            View::render('users/register', ['title' => 'Регистрация', 'error' => $error, 'captcha' => $this->generateCaptchaBase64()]);
            return;
        }

        // Проверка дали имейлът вече съществува
        $stmt = $this->db->prepare("SELECT id FROM users WHERE email = :email");
        $stmt->execute([':email' => $data['email']]);
        if ($stmt->fetch()) {
            $error = "Потребител с този имейл вече съществува.";
            View::render('users/register', ['title' => 'Регистрация', 'error' => $error, 'captcha' => $this->generateCaptchaBase64()]);
            return;
        }

        // Вкарваме потребителя в базата
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, role) VALUES (:name, :email, :password, :role)");
        $stmt->execute([
            ':name' => $data['name'],
            ':email' => $data['email'],
            ':password' => password_hash($data['password'], PASSWORD_DEFAULT),
            ':role' => 'user'
        ]);

        // Регистрацията успешна
        View::render('users/success', ['title' => 'Регистрация успешна']);
    }

    // Генерира captcha и връща Base64
    private function generateCaptchaBase64(): string
    {
        $captcha_code = substr(str_shuffle("ABCDEFGHJKLMNPQRSTUVWXYZ23456789"), 0, 5);
        $_SESSION['captcha'] = $captcha_code;

        $width = 150;
        $height = 50;
        $image = imagecreate($width, $height);

        $bg_color = imagecolorallocate($image, 255, 255, 255);
        imagefill($image, 0, 0, $bg_color);

        $text_color = imagecolorallocate($image, 0, 0, 0);
        $noise_color = imagecolorallocate($image, 100, 120, 180);

        // Шум
        for ($i = 0; $i < 100; $i++) {
            imagefilledellipse($image, rand(0, $width), rand(0, $height), 2, 3, $noise_color);
        }

        // Текст
        imagestring($image, 5, 30, 15, $captcha_code, $text_color);

        // Конвертираме в Base64
        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);

        return 'data:image/png;base64,' . base64_encode($imageData);
    }
}
