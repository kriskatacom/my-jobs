<?php

return [
    'host'     => $_ENV['DB_HOST']     ?? 'localhost',
    'dbname'   => $_ENV['DB_NAME']     ?? 'my_database',
    'username' => $_ENV['DB_USER']     ?? 'root',
    'password' => $_ENV['DB_PASS']     ?? '',
    'charset'  => $_ENV['DB_CHARSET']  ?? 'utf8mb4'
];

function createSlug(string $text): string
{
    $text = mb_strtolower($text, 'UTF-8');

    $transliteration = [
        'а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ж'=>'zh','з'=>'z','и'=>'i','й'=>'y',
        'к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u',
        'ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'sht','ъ'=>'a','ь'=>'','ю'=>'yu','я'=>'ya'
    ];
    $text = strtr($text, $transliteration);

    $text = preg_replace('/[^a-z0-9\-]+/', '-', $text);

    $text = preg_replace('/-+/', '-', $text);

    $text = trim($text, '-');

    return $text;
}
