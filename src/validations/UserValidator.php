<?php

namespace App\Validations;

use App\Repositories\UserRepository;

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

    public static function validateLogin(array $data, UserRepository $userRepository): string|null
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

        if (!$user) {
            return "Имейл адресът или паролата са невалидни.";
        }

        if (!password_verify($data['password'], $user['password'])) {
            return "Имейл адресът или паролата са невалидни.";
        }

        return null;
    }

    public static function validateResetPassword(array $data, $userRepository): string|null
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

        $user = $userRepository->findByEmail($data['email']);

        if (!$user) {
            return "Потребител с този имейл адрес не съществува.";
        }

        return null;
    }

    public static function validateChangePassword(array $data): string|null
    {
        if (empty($data['password'])) {
            return "Паролата е задължителна.";
        }

        if (strlen($data['password']) < 6) {
            return "Паролата трябва да бъде поне 6 символа.";
        }

        return null;
    }
}
