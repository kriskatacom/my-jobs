<?php require 'src/views/layout/header.php'; ?>
<?php require 'src/views/layout/navbar.php'; ?>
<?php require_once 'src/Helpers/languages.php'; ?>

<main>
    <div class="flex gap-5">
        <?php require 'src/views/layout/dashboard-navbar.php'; ?>
        <h1 class="my-5 text-2xl text-center"><?= __('categories') ?></h1>
    </div>

</main>

<?php require 'src/views/layout/footer.php'; ?>
