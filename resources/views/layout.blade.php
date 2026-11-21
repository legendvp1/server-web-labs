<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }
        header {
            background-color: #2c3e50;
            padding: 15px 30px;
        }
        header a {
            color: white;
            text-decoration: none;
            margin-right: 20px;
            font-size: 18px;
        }
        header a:hover {
            text-decoration: underline;
        }
        main {
            background-color: white;
            margin: 30px auto;
            padding: 20px 30px;
            max-width: 800px;
            min-height: 300px;
        }
        footer {
            background-color: #2c3e50;
            color: white;
            text-align: center;
            padding: 15px;
        }
        table {
            border-collapse: collapse;
        }
        td, th {
            border: 1px solid #ccc;
            padding: 8px 15px;
            vertical-align: top;
        }
        th {
            background-color: #eee;
        }
        .article-table {
            overflow-x: auto;
        }
        .article-table table {
            width: 100%;
            overflow-wrap: anywhere;
        }
        .article-actions form {
            margin-top: 8px;
        }
        .pagination {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 16px;
            margin-top: 20px;
        }
        .article-form label {
            display: block;
            margin-bottom: 4px;
        }
        .article-form input[type="text"], .article-form textarea {
            box-sizing: border-box;
            width: 100%;
            padding: 8px;
            font: inherit;
        }
        .article-images {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }
        .article-images label {
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .article-body {
            white-space: pre-line;
            overflow-wrap: anywhere;
        }
    </style>
</head>
<body>

    <header>
        <nav>
            <a href="/">Главная</a>
            <a href="/about">О нас</a>
            <a href="/contacts">Контакты</a>
            <a href="{{ route('signin') }}">Регистрация</a>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>

    <footer>
        Михайлец Владислав Павлович, группа 251-3210
    </footer>

</body>
</html>
