<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>管理者画面 -シーン管理一覧-</title>
        @vite(['resources/css/admin.css', 'resources/css/admin-scene.css', 'resources/js/admin.js'])
    </head>
    <body>
        <a href="{{ route('admin.index') }}" class="back-link">管理者トップ画面へ戻る</a>
        <h1>シーン管理一覧</h1>
        <form action="{{ route('admin.scenes.store') }}" method="POST" class="action-form">
            @csrf
            <button type="submit" class="action-btn btn-detail">+ 新規シーン追加</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>シーン名</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @foreach($scenes as $scene)
                    <tr>
                        <td>{{ $scene->id }}</td>
                        <td>{{ $scene->title }}</td>
                        <td>
                            <a href="{{ route('admin.scenes.show', $scene->id) }}" class="btn-detail">詳細</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </body>
</html>
