<?php require 'src/views/layout/header.php'; ?>
<?php require 'src/views/layout/navbar.php'; ?>
<?php require_once 'src/Helpers/languages.php'; ?>

<main>
    <div class="flex gap-5">
        <?php require 'src/views/layout/dashboard-navbar.php'; ?>
        <div class="w-full">
            <h1 class="my-5 text-2xl"><?= __('create_category') ?></h1>

            <div class="bg-white py-3 px-4 lg:p-8 border border-gray-300 rounded shadow-sm mr-5">
                <form action="/dashboard/categories/create" method="POST" enctype="multipart/form-data" class="space-y-4">

                    <?php if (!empty($error)): ?>
                        <div class="p-4 mb-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                            <?= htmlspecialchars($error) ?>
                        </div>
                    <?php endif; ?>
                    
                    <div>
                        <label for="title" class="block font-medium"><?= __('category_name') ?></label>
                        <input type="text" name="title" value="<?= $data['title'] ?? '' ?>" id="title" required placeholder="<?= __('enter_category_name') ?>"
                            class="mt-1 block w-full rounded border border-gray-300 px-3 py-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 focus:outline-none" />
                    </div>

                    <div>
                        <label for="description" class="block font-medium"><?= __('category_description') ?></label>
                        <textarea name="description" id="description" rows="6" required placeholder="<?= __('enter_category_description') ?>"
                            class="mt-1 block w-full rounded border border-gray-300 px-3 py-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 focus:outline-none"><?= $data['description'] ?? '' ?></textarea>
                    </div>

                    <div>
                        <label for="image" class="block font-medium"><?= __('category_image') ?></label>
                        <input type="file" name="image" id="image" accept="image/*"
                            class="mt-1 block w-full border border-gray-300 rounded cursor-pointer bg-gray-50 focus:border-blue-500 focus:ring-blue-500" />
                    </div>

                    <div>
                        <button type="submit" class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700">
                            <?= __('create') ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

<?php require 'src/views/layout/footer.php'; ?>
