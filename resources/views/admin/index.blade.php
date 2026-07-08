<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>管理者画面 -トップ-</title>
        @vite(['resources/css/admin.css', 'resources/js/admin.js'])
    </head>
    <body>
        <h1>管理者画面</h1>
        <div class="admin-menu">
            <a href="{{ route('admin.users.index') }}" class="admin-btn btn-user">ユーザー管理</a>
            <a href="{{ route('admin.scenes.index') }}" class="admin-btn btn-scene">シーン管理</a>
            <a href="{{ route('admin.assets.index') }}" class="admin-btn btn-asset">素材管理</a>
            <a href="{{ route('admin.exportSeeder') }}" class="admin-btn btn-back js-skip">現在の素材とシーンのデータをSeederとして出力</a>
            <a href="/" class="admin-btn btn-back">タイトル画面へ戻る</a>
        </div>
    </body>
</html>
