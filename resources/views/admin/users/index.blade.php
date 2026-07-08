<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>管理者画面 -ユーザー管理一覧-</title>
        @vite(['resources/css/admin.css', 'resources/css/admin-user.css', 'resources/js/admin.js'])
    </head>
    <body>
        <a href="{{ route('admin.index') }}" class="back-link">管理者トップ画面へ戻る</a>
        <h1>ユーザー管理一覧</h1>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>プレイヤー名</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>
                            <a href="{{ route('admin.users.show', $user->id) }}" class="btn-detail">詳細</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
