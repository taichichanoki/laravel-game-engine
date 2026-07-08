<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>霧の森から</title>
        @vite(['resources/css/game.css', 'resources/css/menu.css', 'resources/js/title.js'])
    </head>
    <body>
        <div class="game-container title-container">
            <h1 class="game-title">霧の森から</h1>
            <div class="menu-container">
                @auth
                    <a href="/game/resume" class="choice-btn decoration-none" id="title-resume-btn">続きから</a>
                    <a href="/game" class="choice-btn decoration-none" id="title-new-game-btn">はじめから</a>

                    @if(Auth::user()->role === 'admin')
                        <a href="/admin" class="choice-btn">管理画面へ</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}" class="logout">
                        @csrf
                        <button type="submit" class="choice-btn logout-btn">ログアウト ({{ Auth::user()->name }}さん)</button>
                    </form>

                    <form method="POST" action="{{ route('account.delete') }}" class="account-delete" onsubmit="return confirm('本当にこれまでの全プレイデータを削除して、アカウントを消去しますか？（この操作を行うと元には戻せません）');">
                        @csrf
                        @method('DELETE')<button type="submit" class="choice-btn account-delete-btn">プレイヤーデータを削除する</button>
                    </form>

                    @include('components.load-modal')

                @endauth
                @guest
                    <a href="{{ route('login') }}" class="choice-btn login">ログインする</a>
                    <a href="{{ route('register') }}" class="choice-btn register">新規プレイヤー登録</a>
                @endguest
            </div>
        </div>
    </body>
</html>
