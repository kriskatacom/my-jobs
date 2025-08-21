<?php

namespace App\Middlewares;

class IsAuthenticated
{
    public function handle(): void
    {
        if (empty($_SESSION['user'])) {
            header('Location: /users/login');
            exit;
        }
    }
}