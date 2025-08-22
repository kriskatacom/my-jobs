<?php require dirname(__DIR__) . '/layout/header.php'; ?>
<?php require dirname(__DIR__) . '/layout/navbar.php'; ?>
<?php require_once dirname(dirname(__DIR__)) . '/Helpers/languages.php'; ?>

<main>
    <div class="flex gap-5">
        <?php require dirname(__DIR__) . '/layout/dashboard-navbar.php'; ?>
        <div class="w-full">
            <h1 class="my-5 text-2xl"><?= __('dashboard') ?></h1>
            <ul class="grid sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
                <li class="border border-gray-200 rounded-md shadow shadow-gray-200 overflow-hidden">
                    <a href="/dashboard/users" class="bg-white block py-5 text-center text-2xl">
                        <?= __('users') ?>
                        <div><?= htmlspecialchars($userCount) ?></div>
                    </a>
                </li>
                <li class="border border-gray-200 rounded-md shadow shadow-gray-200 overflow-hidden">
                    <a href="/dashboard/categories" class="bg-white block py-5 text-center text-2xl">
                        <?= __('categories') ?>
                        <div><?= htmlspecialchars($categoryCount) ?></div>
                    </a>
                </li>
            </ul>
        </div>
    </div>

</main>

<?php require dirname(__DIR__) . '/layout/footer.php'; ?>
