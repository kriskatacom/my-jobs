<?php require 'src/views/layout/header.php'; ?>
<?php require 'src/views/layout/navbar.php'; ?>
<?php require_once 'src/Helpers/languages.php'; ?>

<main>
    <div class="flex gap-5">
        <?php require 'src/views/layout/dashboard-navbar.php'; ?>
        <div class="w-full">
            <h1 class="my-5 text-2xl"><?= __('create_category') ?></h1>

            <div class="grid gap-5 bg-white py-3 px-4 lg:p-8 border border-gray-300 rounded shadow-sm mr-5">
                <div>
                    <strong><?= __('category_name') ?></strong>:
                    <div><?= $category['title'] ?></div>
                </div>
                <div>
                    <strong><?= __('category_description') ?></strong>:
                    <div><?= $category['description'] ?></div>
                </div>
                <div>
                    <form action="/dashboard/categories/delete/<?= $category['id'] ?>" method="POST" class="flex items-center gap-3">
                        <button type="submit" class="px-4 py-2 font-bold text-white bg-red-500 rounded hover:bg-red-700"><?= __('delete_category') ?></button>
                        <a href="/dashboard/categories" class="hover:text-blue-700 transition-colors duration-300"><?= __('cancel') ?></a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>

<?php require 'src/views/layout/footer.php'; ?>
