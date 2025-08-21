<?php

namespace App\Controllers;

use Core\View;
use Core\Database;
use App\Validations\UserValidator;

use App\Repositories\UserRepository;

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

        for ($i = 0; $i < 100; $i++) {
            imagefilledellipse($image, rand(0, $width), rand(0, $height), 2, 3, $noise_color);
        }

        imagestring($image, 5, 30, 15, $captcha_code, $text_color);

        ob_start();
        imagepng($image);
        $imageData = ob_get_clean();
        imagedestroy($image);

        return 'data:image/png;base64,' . base64_encode($imageData);
    }
}
