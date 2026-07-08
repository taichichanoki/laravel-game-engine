<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ログイン -霧の森から-</title>
        @vite(['resources/css/game.css', 'resources/css/register.css', 'resources/js/register.js'])
    </head>
    <body>
        <div class="game-container title-container">
            <h2 class="h2-title">ログイン</h2>
            <form action="{{ url('/login') }}" method="POST" class="auth-form">
                @csrf
                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required autofocus>
                    @error('email') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="password">パスワード</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    @error('password') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <label class="checkbox-group">
                    <input type="checkbox" name="remember" id="remember">
                    <span>ログイン状態を保持する</span>
                </label>

                <div class="div-btn">
                    <button type="submit" class="choice-btn btn">ログイン</button>
                </div>
                <a href="/" class="title_button">タイトルへ戻る</a>
            </form>
        </div>
    </body>
</html>
