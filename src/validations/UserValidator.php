<?php

namespace App\Validations;

use Core\View;
use App\Services\UserService;

class UserValidator
{
    public static function validateCreate(array $data): string|null
    {
        if (empty($data['name'])) {
            return "Името на потребителя е задължително.";
        }

        if (strlen($data['name']) > 100) {
            return "Името на потребителя не може да бъде по-дълго от 100 символа.";
        }

        if (empty($data['email'])) {
            return "Имейлът е задължителен.";
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return "Имейлът трябва да бъде валиден.";
        }

        if (strlen($data['email']) > 150) {
            return "Имейлът не може да бъде по-дълъг от 150 символа.";
        }

        if (empty($data['password'])) {
            return "Паролата е задължителна.";
        }

        if (strlen($data['password']) < 6) {
            return "Паролата трябва да бъде поне 6 символа.";
        }

        if (!empty($data['role']) && !in_array($data['role'], ['user', 'admin'])) {
            return "Ролята трябва да бъде 'user' или 'admin'.";
        }

        return null;
    }

    public static function validateLogin(array $data, $userRepository): string|null
    {
        if (empty($data['email'])) {
            return "Имейлът е задължителен.";
        }

        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            return "Имейлът трябва да бъде валиден.";
        }

        if (strlen($data['email']) > 150) {
            return "Имейлът не може да бъде по-дълъг от 150 символа.";
        }

        if (empty($data['password'])) {
            return "Паролата е задължителна.";
        }

        if (strlen($data['password']) < 6) {
            return "Паролата трябва да бъде поне 6 символа.";
        }

        $user = $userRepository->findByEmail($data['email']);

        if ($user === null) {
            View::render('users/login', [
                'title' => 'Вход',
                'error' => 'Имейл адресът или паролата са невалидни.',
                'captcha' => UserService::generateCaptchaBase64()
            ]);
        }

        if (!password_verify($data['password'], $user['password'])) {
            View::render('users/login', [
                'title' => 'Вход',
                'error' => 'Имейл адресът или паролата са невалидни.',
                'captcha' => UserService::generateCaptchaBase64()
            ]);
        }

        return null;
    }
}
