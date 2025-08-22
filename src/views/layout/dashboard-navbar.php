<?php
// Функция за проверка дали текущият URL съвпада с даден път
function isActive($path) {
    $currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    return $currentPath === $path ? 'bg-gray-200' : '';
}
?>

<aside class="w-full max-w-[350px] min-h-screen">
    <div class="bg-white h-full border-r border-gray-200 shadow">
        <div class="text-center text-2xl py-5 border-b border-gray-200"><?= __('administration') ?></div>
        <ul class="flex flex-col">
            <li class="border-b border-gray-200">
                <a href="/dashboard" class="w-full block py-3 px-5 hover:bg-gray-200 <?= isActive('/dashboard') ?>">
                    <?= __('dashboard') ?>
                </a>
            </li>
            <li class="border-b border-gray-200">
                <a href="/dashboard/users" class="w-full block py-3 px-5 hover:bg-gray-200 <?= isActive('/dashboard/users') ?>">
                    <?= __('users') ?>
                </a>
            </li>
            <li class="border-b border-gray-200">
                <a href="/dashboard/categories" class="w-full block py-3 px-5 hover:bg-gray-200 <?= isActive('/dashboard/categories') ?>">
                    <?= __('categories') ?>
                </a>
            </li>
            <li class="border-b border-gray-200">
                <a href="/dashboard/announcements" class="pointer-events-none cursor-default w-full block py-3 px-5 hover:bg-gray-200 <?= isActive('/dashboard/announcements') ?>">
                    <?= __('announcements') ?>
                    <span class="bg-gray-200 py-1 px-2 rounded-full">Скоро</span>
                </a>
            </li>
            <li class="border-b border-gray-200">
                <a href="/dashboard/settings" class="pointer-events-none cursor-default w-full block py-3 px-5 hover:bg-gray-200 <?= isActive('/dashboard/settings') ?>">
                    <?= __('settings') ?>
                    <span class="bg-gray-200 py-1 px-2 rounded-full">Скоро</span>
                </a>
            </li>
        </ul>
    </div>
</aside>