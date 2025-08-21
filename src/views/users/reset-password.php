<?php require dirname(__DIR__) . '/layout/header.php'; ?>
<?php require dirname(__DIR__) . '/layout/navbar.php'; ?>
<?php require_once dirname(dirname(__DIR__)) . '/helpers/languages.php'; ?>

<main>
    <div class="container mx-auto px-4">
        <h1 class="my-5 text-3xl text-center"><?= __('reset_password') ?></h1>

        
        <div class="bg-white py-3 px-4 lg:p-8 border border-gray-300 rounded shadow-sm max-w-2xl mx-auto">
            <p class="mb-5 text-gray-600">
                За да възстановите паролата си, моля, въведете вашия имейл адрес в полето по-долу. Ще получите имейл с линк
                за нулиране на паролата.
            </p>

            <form action="/users/reset-password" method="POST" class="space-y-4">
                <div>
                    <label for="email" class="block"><?= __('email_address') ?></label>
                    <input type="email" name="email" id="email" required placeholder="<?= __('enter_email_address') ?>"
                        class="mt-1 block w-full rounded border border-gray-300 px-3 py-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 focus:outline-none" />
                </div>

                <div>
                    <label for="captcha" class="block"><?= __('enter_code') ?></label>
                    <input type="text" name="captcha" placeholder="<?= __('enter_image_code') ?>" required class="my-1 block w-full rounded border border-gray-300 px-3 py-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 focus:outline-none">
                    <img src="<?= $captcha ?>" alt="Captcha" class="border rounded" />
                </div>

                <?php if (!empty($error)): ?>
                    <p class="text-red-600"><?= $error ?></p>
                <?php endif; ?>

                <button type="submit"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-white font-semibold shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    <?= __('submit_link') ?>
                </button>
            </form>

            <p class="mt-6 text-gray-600">
            <div>
                <?= __('remember_password') ?>?
                <a href="/users/login" class="text-blue-600 hover:underline"><?= __('login') ?></a>
            </div>
            </p>
        </div>
    </div>
</main>

<?php require dirname(__DIR__) . '/layout/footer.php'; ?>
