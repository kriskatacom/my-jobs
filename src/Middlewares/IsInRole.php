<?php

namespace App\Middlewares;

class IsInRole
{
    private string $role;

    public function __construct(string $role = 'admin')
    {
        $this->role = $role;
    }

    public function handle(): void
    {
        if (!empty($_SESSION['user']) && $_SESSION['user']['role'] !== $this->role) {
            header('Location: /');
            exit;
        }
    }
}
