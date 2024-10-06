<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/backend.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <a class="header__inner__title" href="/">Rese:Dashboard</a>
    </header>
    <main>
        @yield('content')
    </main>
</body>
</html>