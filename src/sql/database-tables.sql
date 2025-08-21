CREATE TABLE IF NOT EXISTS users (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `name` VARCHAR(100) NOT NULL,
    `email` VARCHAR(150) NOT NULL UNIQUE,
    `password` VARCHAR(255) NOT NULL,
    `role` ENUM('admin', 'user') DEFAULT 'user',
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO users (name, email, password, role) VALUES
('Иван Петров', 'ivan@example.com', SHA2('123456', 256), 'user'),
('Мария Георгиева', 'maria@example.com', SHA2('password123', 256), 'user'),
('Админ Админов', 'admin@example.com', SHA2('adminpass', 256), 'admin'),
('Георги Иванов', 'georgi@example.com', SHA2('qwerty', 256), 'user');


CREATE TABLE IF NOT EXISTS job_categories (
    `id` INT AUTO_INCREMENT PRIMARY KEY,
    `category_id` INT NULL,
    `title` VARCHAR(100) NOT NULL,
    `description` TEXT,
    `icon_url` VARCHAR(255),
    `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES job_categories(id) ON DELETE CASCADE
);

INSERT INTO job_categories (title, description, icon_url) VALUES
('Търговия и Продажби', 'Работа като търговски представители, консултанти и специалисти по продажби.', 'https://img.icons8.com/fluency/48/shopping-cart.png'),
('IT и Технологии', 'Програмиране, поддръжка на софтуер, системна администрация и киберсигурност.', 'https://img.icons8.com/fluency/48/computer.png'),
('Клиентско обслужване', 'Работа в кол центрове, помощни линии и обслужване на клиенти.', 'https://img.icons8.com/fluency/48/customer-support.png'),
('Здравеопазване', 'Лекари, медицински сестри, фармацевти и други здравни специалисти.', 'https://img.icons8.com/fluency/48/stethoscope.png'),
('Образование и Наука', 'Учители, университетски преподаватели, изследователи и обучители.', 'https://img.icons8.com/fluency/48/graduation-cap.png'),
('Логистика и Транспорт', 'Шофьори, складови работници, куриери и специалисти по транспорт.', 'https://img.icons8.com/fluency/48/fork-truck.png'),
('Строителство', 'Майстори, инженери, архитекти и специалисти в строителния сектор.', 'https://img.icons8.com/fluency/48/helmet.png'),
('Хотелиерство и Туризъм', 'Работа в хотели, ресторанти, туроператорски и туристически агенции.', 'https://img.icons8.com/fluency/48/kitchen-room.png'),
('Финанси и Счетоводство', 'Счетоводители, финансови анализатори и банкови специалисти.', 'https://img.icons8.com/fluency/48/accounting.png'),
('Дизайн и Креатив', 'Графични дизайнери, маркетинг специалисти, фотографи и творци.', 'https://img.icons8.com/fluency/48/paint-palette.png');

INSERT INTO job_categories (category_id, title, description) VALUES
(2, 'Програмиране', 'Работа за програмисти и софтуерни инженери.'),
(2, 'Системна администрация', 'Администриране на сървъри и мрежи.'),
(2, 'Киберсигурност', 'Специалисти по информационна сигурност.');