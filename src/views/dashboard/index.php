<?php require dirname(__DIR__) . '/layout/header.php'; ?>
<?php require dirname(__DIR__) . '/layout/navbar.php'; ?>
<?php require_once dirname(dirname(__DIR__)) . '/Helpers/languages.php'; ?>

<main>
    <div class="flex gap-5">
        <?php require dirname(__DIR__) . '/layout/dashboard-navbar.php'; ?>
        <h1 class="my-5 text-2xl text-center"><?= __('dashboard') ?></h1>
    </div>

</main>

<?php require dirname(__DIR__) . '/layout/footer.php'; ?>
