<!DOCTYPE html>
<html lang="bg">

<head>
    <meta charset="UTF-8">
    <title>Възстановяване на парола</title>
    <style>
        .container {
            background-color: #ffffff;
            max-width: 600px;
            margin: 0 auto;
            padding: 30px;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            font-family: Arial, sans-serif !important;
            color: #333 !important;
            font-size: 18px !important;
        }

        h1 {
            font-size: 24px !important;
            margin: 0 0 20px 0 !important;
        }

        .button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #1d4ed8;
            color: white !important;
            font-size: 18px;
            text-decoration: none;
            border-radius: 4px;
        }

        .footer {
            font-size: 14px;
            margin-top: 30px;
            color: #777;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Здравей, {{ first_name }}</h2>
        <p>Получихме заявка за възстановяване на паролата за твоя акаунт.</p>
        <p>Ако ти си направил заявката, натисни бутона по-долу, за да създадеш нова парола:</p>

        <a href="{{ reset_link }}" class="button">Създай нова парола</a>

        <p>Ако не си изпращал тази заявка, можеш да игнорираш това съобщение.</p>

        <p>Поздрави,<br>Екипът на {{ website_name }}</p>

        <div class="footer">
            Това съобщение е изпратено автоматично. Моля, не отговаряй на него.
        </div>
    </div>
</body>

</html>
