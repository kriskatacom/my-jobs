<div class="mt-4 flex justify-center gap-2">
    <?php if ($currentPage > 1): ?>
        <a href="?page=<?= $currentPage - 1 ?>" class="px-5 py-3 border border-gray-300 rounded hover:bg-gray-200">
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
        <a href="?page=<?= $currentPage + 1 ?>" class="px-5 py-3 border border-gray-300 rounded hover:bg-gray-200">
            <?= __('next_page') ?> &raquo;
        </a>
    <?php endif; ?>
</div>