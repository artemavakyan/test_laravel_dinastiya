<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Блог')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-900">

<header class="bg-white shadow-md">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
        <a href="{{ route('articles.index') }}" class="text-2xl font-bold text-blue-600">
            Блог
        </a>

        <nav class="flex items-center space-x-4">
            @auth
                <a href="{{ route('platform.index') }}" class="inline-block mt-4 px-4 py-2 bg-red-500 text-white rounded hover:bg-blue-600 transition">Админ-панель</a>
            @endauth
        </nav>
    </div>
</header>

<main class="container mx-auto py-10 px-6">
    @yield('content')
</main>

<footer class="bg-white shadow-md mt-10 py-4">
    <div class="container mx-auto text-center text-gray-600">
        &copy; {{ date('Y') }}. Все права защищены.
    </div>
</footer>

</body>
</html>
