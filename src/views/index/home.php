<?php require dirname(__DIR__) . '/layout/header.php'; ?>
<?php require dirname(__DIR__) . '/layout/navbar.php'; ?>
<?php require_once dirname(dirname(__DIR__)) . '/helpers/languages.php'; ?>

<main>
    <div class="container mx-auto px-4">
        <h1 class="my-5 text-4xl text-center"><?= __('announcements') ?></h1>
        
        <ul class="grid md:grid-cols-2 xl:grid-cols-4 gap-5">
            <?php foreach ($categories as $category): ?>
                <a href="/categories/<?= createSlug($category['title']); ?>">
                    <li class="bg-white border border-gray-300 shadow-sm rounded py-3 px-4 flex items-center space-x-3">
                        <img src="<?= $category['icon_url']; ?>" alt="<?= $category['title']; ?>" class="w-10 h-10">
                        <div>
                            <h3 class="font-semibold"><?= $category['title']; ?></h3>
                            <p class="text-sm text-gray-600"><?= $category['description']; ?></p>
                        </div>
                    </li>
                </a>
            <?php endforeach; ?>
        </ul>
    </div>
</main>

<?php require dirname(__DIR__) . '/layout/footer.php'; ?>
