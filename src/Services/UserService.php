<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Core\Database;
use Core\JwtHelper;

class UserService
{
    public static function generateTokenAndSaveSession(array $user): void
    {
        $firstName = self::splitFullName($user['name'])['firstName'];

        $token = JwtHelper::encode([
            'id' => $user['id'],
            'email' => $user['email'],
            'role' => $user['role'],
            'name' => $firstName,
            'expiration' => $_ENV['JWT_EXPIRATION'] + time()
        ], $_ENV['JWT_SECRET_KEY']);

        $_SESSION['jwt_token'] = $token;
    }

    public static function logout(): void
    {
        $_SESSION['jwt_token'] = null;
        $_SESSION['user'] = null;
    }

    public static function validateAndSetUserFromToken(): ?array
    {
        $token = $_SESSION['jwt_token'] ?? null;

        if (!$token) {
            self::clearSessionUser();
            return null;
        }

        $decoded = JwtHelper::decode($token, $_ENV['JWT_SECRET_KEY']);

        if (!$decoded || !isset($decoded['id'], $decoded['email'], $decoded['role'])) {
            self::clearSessionUser();
            return null;
        }

        $userRepository = new UserRepository(Database::getInstance()->getConnection());
        $user = $userRepository->findByEmail($decoded['email']);

        if (!$user) {
            self::clearSessionUser();
            return null;
        }

        if ($decoded['expiration'] < time()) {
            self::clearSessionUser();
            return null;
        }

        $_SESSION['user'] = $decoded;
        return $decoded;
    }

    private static function clearSessionUser(): void
    {
        $_SESSION['jwt_token'] = null;
        $_SESSION['user'] = null;
    }

    public static function generateCaptchaBase64(): string
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

    public static function splitFullName(string $fullName): array
    {
        $fullName = trim($fullName);

        if (empty($fullName)) {
            return ['firstName' => '', 'lastName' => ''];
        }

        $parts = explode(' ', $fullName);

        $firstName = array_shift($parts);
        $lastName = implode(' ', $parts);

        return [
            'firstName' => $firstName,
            'lastName' => $lastName
        ];
    }
}
