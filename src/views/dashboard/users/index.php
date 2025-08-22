<?php require 'src/views/layout/header.php'; ?>
<?php require 'src/views/layout/navbar.php'; ?>
<?php require_once 'src/Helpers/languages.php'; ?>

<main>
    <div class="flex gap-5">
        <?php require 'src/views/layout/dashboard-navbar.php'; ?>

        <div class="w-full">
            <h1 class="my-5 text-2xl"><?= __('users') ?></h1>
            <?php if (count($users) === 0): ?>
                <p class="text-center text-gray-500"><?= __('no_users_found') ?></p>
            <?php else: ?>
                <div class="bg-white overflow-x-auto pr-5">
                    <table class="border border-gray-200 w-full">
                        <thead class="border-b">
                            <tr>
                                <th class="px-4 py-2 text-left">ID</th>
                                <th class="px-4 py-2 text-left"><?= __('name') ?></th>
                                <th class="px-4 py-2 text-left"><?= __('email') ?></th>
                                <th class="px-4 py-2 text-left"><?= __('role') ?></th>
                                <th class="px-4 py-2 text-left"><?= __('actions') ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr class="border-b border-gray-200 hover:bg-gray-50">
                                    <td class="px-4 py-2"><?= $user['id'] ?></td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($user['name']) ?></td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($user['email']) ?></td>
                                    <td class="px-4 py-2"><?= __(htmlspecialchars($user['role'])) ?></td>
                                    <td class="px-4 py-2">
                                        <div class="relative inline-block text-left">
                                            <select id="action-<?= $user['id'] ?>" 
                                                    class="border border-gray-300 rounded px-3 py-2"
                                                    onchange="if(this.value) { window.location.href=this.value; this.selectedIndex = 0; }">
                                                <option value=""><?= __('select_action') ?></option>
                                                <option value="/dashboard/users/edit/<?= $user['id'] ?>"><?= __('edit') ?></option>
                                                <option value="/dashboard/users/delete/<?= $user['id'] ?>"><?= __('delete') ?></option>
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
