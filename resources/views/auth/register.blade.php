<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>新規プレイヤー登録 -霧の森から-</title>
        @vite(['resources/css/game.css', 'resources/css/register.css', 'resources/js/register.js'])
    </head>
    <body>
        <div class="game-container title-container">
            <h2 class="h2-title">新規プレイヤー登録</h2>
            <form action="{{ url('/register') }}" method="POST" class="auth-form">
                @csrf
                <div class="form-group">
                    <label for="name">プレイヤー名</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required maxlength="16" autofocus>
                    @error('name') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="email">メールアドレス</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required>
                    @error('email') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="password">パスワード（8文字以上）</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                    @error('password') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <div class="form-group">
                    <label for="password_confirmation">パスワード（確認用）</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>

                <div class="div-btn">
                    <button type="submit" class="choice-btn btn">登録</button>
                </div>
                <a href="/" class="title_button">タイトルへ戻る</a>
            </form>
        </div>
    </body>
</html>
