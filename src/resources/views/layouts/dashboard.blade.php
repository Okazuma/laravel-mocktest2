<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Rese</title>
    <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    @yield('css')
</head>

<body>
    <header class="header">
        <div class="header__inner">
            <h1 class="header__inner-title">Rese:Dashboard</h1>
        </div>
    </header>

    <main>
    @yield('content')
    </main>


</body>
</html>