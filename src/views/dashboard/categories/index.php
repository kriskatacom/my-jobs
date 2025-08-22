<?php require 'src/views/layout/header.php'; ?>
<?php require 'src/views/layout/navbar.php'; ?>
<?php require_once 'src/Helpers/languages.php'; ?>

<main>
    <div class="flex gap-5">
        <?php require 'src/views/layout/dashboard-navbar.php'; ?>

        <div class="w-full">
            <div class="flex justify-between items-center mr-5">
                <h1 class="my-5 text-2xl"><?= __('categories') ?></h1>
                <a href="/dashboard/categories/create" class="rounded-lg bg-blue-600 px-4 py-2 text-white font-semibold shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400"><?= __('create') ?></a>
            </div>
            <?php if (count($categories) === 0): ?>
                <p class="text-center text-gray-500"><?= __('no_categories_found') ?></p>
            <?php else: ?>
                <div class="bg-white overflow-x-auto pr-5">
                    <table class="border border-gray-200 w-full">
                        <thead class="border-b">
                            <tr>
                                <th class="px-4 py-2 text-left">ID</th>
                                <th class="px-4 py-2 text-left"><?= __('title') ?></th>
                                <th class="px-4 py-2 text-left"><?= __('actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($categories as $user): ?>
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-4 py-2"><?= $user['id'] ?></td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($user['title']) ?></td>
                                    <td class="px-4 py-2">
                                        <div class="relative inline-block text-left">
                                            <select id="action-<?= $user['id'] ?>" 
                                                    class="border border-gray-300 rounded px-3 py-2"
                                                    onchange="if(this.value) { window.location.href=this.value; this.selectedIndex = 0; }">
                                                <option value=""><?= __('select_action') ?></option>
                                                <option value="/dashboard/categories/edit/<?= $user['id'] ?>"><?= __('edit') ?></option>
                                                <option value="/dashboard/categories/delete/<?= $user['id'] ?>"><?= __('delete') ?></option>
                                            </select>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php require 'src/views/layout/pagination.php'; ?>
            <?php endif; ?>
        </div>
    </div>

</main>

<?php require 'src/views/layout/footer.php'; ?>
