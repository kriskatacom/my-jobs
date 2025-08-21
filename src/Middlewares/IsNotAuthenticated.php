<?php

namespace App\Middlewares;

class IsNotAuthenticated
{
    public function handle(): void
    {
        if (!empty($_SESSION['user'])) {
            header('Location: /');
            exit;
        }
    }
}