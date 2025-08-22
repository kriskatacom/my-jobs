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
                                <tr class="border-b hover:bg-gray-50">
                                    <td class="px-4 py-2"><?= $user['id'] ?></td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($user['name']) ?></td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($user['email']) ?></td>
                                    <td class="px-4 py-2"><?= htmlspecialchars($user['role']) ?></td>
                                    <td class="px-4 py-2">
                                        <a href="/dashboard/users/edit/<?= $user['id'] ?>"
                                            class="text-blue-500 hover:underline"><?= __('edit') ?></a>
                                        |
                                        <a href="/dashboard/users/delete/<?= $user['id'] ?>"
                                            class="text-red-500 hover:underline"><?= __('delete') ?></a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-4 flex justify-center gap-2">
                    <?php if ($currentPage > 1): ?>
                        <a href="?page=<?= $currentPage - 1 ?>"
                            class="px-5 py-3 border border-gray-300 rounded hover:bg-gray-200">
                            &laquo; <?= __('prev_page') ?>
                        </a>
                    <?php endif; ?>

                    <?php
                    $range = 2;
                
                    for ($i = 1; $i <= $totalPages; $i++):
                        if ($i == 1 || $i == $totalPages || ($i >= $currentPage - $range && $i <= $currentPage + $range)):
                            ?>
                            <a href="?page=<?= $i ?>"
                                class="px-5 py-3 border border-gray-300 rounded <?= $i === $currentPage ? 'bg-gray-200 cursor-default pointer-events-none' : 'hover:bg-gray-200' ?>">
                                <?= $i ?>
                            </a>
                            <?php
                        elseif ($i == 2 && $currentPage - $range > 2):
                            echo '<span class="px-3 py-3">...</span>';
                        elseif ($i == $totalPages - 1 && $currentPage + $range < $totalPages - 1):
                            echo '<span class="px-3 py-3">...</span>';
                        endif;
                    endfor;
                    ?>

                    <?php if ($currentPage < $totalPages): ?>
                        <a href="?page=<?= $currentPage + 1 ?>"
                            class="px-5 py-3 border border-gray-300 rounded hover:bg-gray-200">
                            <?= __('next_page') ?> &raquo;
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

</main>

<?php require 'src/views/layout/footer.php'; ?>
