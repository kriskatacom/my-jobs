<?php

require_once dirname(dirname(__DIR__)) . '/helpers/languages.php';
$class_names = 'class="hover:text-green-500 transition-colors duration-300"';
?>

<div class="bg-white border border-gray-200 shadow">
    <div class="flex justify-between items-center px-5">
        <div>
            <a href="/" class="text-2xl font-bold text-gray-800 py-3"><?= __('job_announcements') ?></a>
        </div>
        <ul class="flex justify-center items-center gap-5 py-5">
            <li>
                <a href="/" <?= $class_names ?> title="<?= __('home_title') ?>"><?= __('home') ?></a>
            </li>
            <?php if (isset($_SESSION['user']) && !empty($_SESSION['user']['id'])): ?>
                <li>
                    <a href="/users/profile" <?= $class_names ?> title="<?= __('profile_title') ?>"><?= __('hello') ?>, <?= $_SESSION['user']['name'] ?></a>
                </li>
                <li>
                    <a href="/users/logout" <?= $class_names ?> title="<?= __('logout_title') ?>"><?= __('logout') ?></a>
                </li>
            <?php else: ?>
                <li>
                    <a href="/users/register" <?= $class_names ?> title="<?= __('register_title') ?>"><?= __('register') ?></a>
                </li>
                <li>
                    <a href="/users/login" <?= $class_names ?> title="<?= __('login_title') ?>"><?= __('login') ?></a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</div>
