<?php require dirname(__DIR__) . '/layout/header.php'; ?>
<?php require dirname(__DIR__) . '/layout/navbar.php'; ?>
<?php require_once dirname(dirname(__DIR__)) . '/helpers/languages.php'; ?>

<main>
    <div class="container mx-auto px-4">
        <h1 class="my-5 text-3xl text-center"><?= __('register') ?></h1>

        <div class="bg-white py-3 px-4 lg:p-8 border border-gray-300 rounded shadow-sm max-w-2xl mx-auto">
            <form action="/users/register" method="POST" class="space-y-4">
                <div>
                    <label for="name" class="block font-medium text-gray-700">Име и фамилия</label>
                    <input type="text" name="name" id="name" required placeholder="Напишете името и фамилията си"
                        class="mt-1 block w-full rounded border border-gray-300 px-3 py-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 focus:outline-none" />
                </div>

                <div>
                    <label for="email" class="block font-medium text-gray-700">Имейл адрес</label>
                    <input type="email" name="email" id="email" required placeholder="Напишете валиден имейл адрес"
                        class="mt-1 block w-full rounded border border-gray-300 px-3 py-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 focus:outline-none" />
                </div>

                <div>
                    <label for="password" class="block font-medium text-gray-700">Парола</label>
                    <input type="password" name="password" id="password" required
                        placeholder="Напишете и запазете сигурна парола"
                        class="mt-1 block w-full rounded border border-gray-300 px-3 py-2 text-gray-900 focus:border-blue-500 focus:ring-blue-500 focus:outline-none" />
                </div>

                <!-- <div class="flex items-center space-x-4">
                    <img src="<= $captcha ?>" alt="Captcha" class="border rounded" />
                    <input type="text" name="captcha" placeholder="Въведете кода" required class="...">
                </div> -->

                <?php if (!empty($error)): ?>
                    <p class="text-red-600"><?= $error ?></p>
                <?php endif; ?>

                <button type="submit"
                    class="rounded-lg bg-blue-600 px-4 py-2 text-white font-semibold shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-400">
                    Регистрация
                </button>
            </form>

            <p class="mt-6 text-gray-600">
                Вече имате акаунт?
                <a href="/login" class="text-blue-600 hover:underline">Вход</a>
            </p>
        </div>
    </div>
</main>

<?php require dirname(__DIR__) . '/layout/footer.php'; ?>
