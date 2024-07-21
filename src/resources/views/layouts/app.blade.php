<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Rese</title>
  <link rel="stylesheet" href="{{ asset('css/sanitize.css') }}">
  <link rel="stylesheet" href="{{ asset('css/common.css') }}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" integrity="..." crossorigin="anonymous" />
  @yield('css')
</head>

<body>
  <header class="header">
    <div class="header__container">
      <div class="header__inner">

      @auth
        <a id="menu-button" class="burger-icon {{ request()->is('menu1') ? 'close-icon' : '' }}" href="{{ route('restaurants.menu1') }}">
          <span></span>
          <span></span>
          <span></span>
        </a>
      @else
        <a id="menu-button" class="burger-icon {{ request()->is('menu2') ? 'close-icon' : '' }}" href="{{ route('restaurants.menu2') }}">
          <span></span>
          <span></span>
          <span></span>
        </a>
      @endauth


        <h1 class="header__logo">Rese</h1>
      </div>

      <div class="header__search">
        @yield('search')
        
      </div>



  </header>

  <main>
    @yield('content')
  </main>

<script>

document.addEventListener('DOMContentLoaded', function() {
    const menuButton = document.getElementById('menu-button');
    const currentPath = window.location.pathname;

    // メニュー画面にいる場合は戻るボタンにする
    if (currentPath.includes('menu1') || currentPath.includes('menu2')) {
        menuButton.addEventListener('click', function(event) {
            event.preventDefault(); // デフォルトのクリック動作をキャンセル
            window.history.back(); // ブラウザの履歴を一つ戻る（前のページに戻る）
        });
        menuButton.classList.add('close-icon');
    }
});
</script>

@yield('scripts')


</body>

</html>