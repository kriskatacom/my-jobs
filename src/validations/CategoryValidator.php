<?php

namespace App\Validations;

class CategoryValidator
{
    public static function validateCreate(array $data): string|null
    {
        if (empty($data['title'])) {
            return "Името на категорията е задължително.";
        }

        if (strlen($data['title']) > 100) {
            return "Името на категорията не може да бъде по-дълго от 100 символа.";
        }

        if (!empty($data['description']) && strlen($data['description']) > 500) {
            return "Описанието не може да бъде по-дълго от 500 символа.";
        }

        if (!empty($data['icon_url']) && !filter_var($data['icon_url'], FILTER_VALIDATE_URL)) {
            return "Иконата трябва да бъде валиден URL.";
        }

        return null;
    }
}