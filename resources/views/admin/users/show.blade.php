<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>管理者画面 -ユーザー詳細-</title>
        @vite(['resources/css/admin.css', 'resources/css/admin-user.css', 'resources/js/admin.js'])
    </head>
    <body>
        <a href="{{ route('admin.users.index') }}" class="back-link">ユーザー管理一覧へ戻る</a>
        <h1>ユーザー詳細: {{ $user->name }}</h1>

        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif

        @if($errors->any())
            <div class="alert alert-error">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <div class="info-container">
            <div class="info-row"><span class="info-label">ユーザーID:</span> {{ $user->id }}</div>
            <div class="info-row"><span class="info-label">プレイヤー名:</span> {{ $user->name }}</div>
            <div class="info-row"><span class="info-label">メールアドレス:</span> {{ $user->email }}</div>
            <div class="info-row"><span class="info-label">権限:</span> {{ $user->role }}</div>
            <div class="info-row"><span class="info-label">登録日時:</span> {{ $user->created_at }}</div>
        </div>

        <div class="admin-card">
            <h2 class="card-title">パスワードの強制変更</h2>
            <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <input type="password" name="password" placeholder="新しいパスワード" required>
                </div>
                <div class="form-group">
                    <input type="password" name="password_confirmation" placeholder="新しいパスワード（確認用）" required>
                </div>
                <button type="submit" class="btn btn-primary">変更を保存</button>
            </form>
        </div>

        <div class="admin-card card-danger">
            <h2 class="card-title">アカウントの完全削除</h2>
            <p class="card-desc">※この操作は取り消せません。セーブデータもすべて削除されます。</p>
            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('本当にこのユーザーを削除しますか？\n（この操作は取り消せません）');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">ユーザーを削除する</button>
            </form>
        </div>
    </body>
</html>
