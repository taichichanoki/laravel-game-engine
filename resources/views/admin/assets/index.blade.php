<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>管理者画面 -素材管理一覧-</title>
        @vite(['resources/css/admin.css', 'resources/css/admin-asset.css', 'resources/js/admin.js'])
    </head>
    <body>
        <a href="{{ route('admin.index') }}" class="back-link">管理者トップ画面へ戻る</a>
        <h1>素材管理一覧</h1>
        @if(session('success')) <div>{{ session('success') }}</div> @endif

        <div class="admin-card">
            <h2 class="card-title">新しい素材を登録</h2>
            <form action="{{ route('admin.assets.store') }}" method="POST" enctype="multipart/form-data" class="action-form">
                @csrf
                <div class="form-group">
                    <label>管理用の名前:</label>
                    <input type="text" name="name" value="{{ old('name') }}" required maxlength="255">
                    @error('name') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>ファイルを選択:</label>
                    <input type="file" name="file" required>
                    @error('file') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <div class="form-group">
                    <label>素材の種類:</label>
                    <select name="type" required>
                        <option value="image" {{ old('type') == 'image' ? 'selected' : '' }}>背景画像</option>
                        <option value="bgm" {{ old('type') == 'bgm' ? 'selected' : '' }}>BGM</option>
                        <option value="se" {{ old('type') == 'se' ? 'selected' : '' }}>SE</option>
                    </select>
                    @error('type') <span class="error-msg">{{ $message }}</span> @enderror
                </div>
                <button type="submit" class="action-btn btn-detail">素材を登録する</button>
            </form>
        </div>

        <h3>背景画像一覧</h3>
        <table class="table-wide">
            <thead>
                <tr>
                    <th>名前</th>
                    <th>ファイル名</th>
                    <th>プレビュー / 操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assets->where('type', 'image') as $asset)
                    <tr>
                        <td>{{ $asset->name }}</td>
                        <td>{{ $asset->filename }}</td>
                        <td>
                            <img src="{{ asset('images/' . $asset->filename) }}" alt="{{ $asset->name }}" class="img-preview">

                            <form action="{{ route('admin.assets.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('この素材を削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-detail">削除</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">登録されている背景画像はありません。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h3>BGM一覧</h3>
        <table class="table-wide">
            <thead>
                <tr>
                    <th>名前</th>
                    <th>ファイル名</th>
                    <th>プレビュー / 操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assets->where('type', 'bgm') as $asset)
                    <tr>
                        <td>{{ $asset->name }}</td>
                        <td>{{ $asset->filename }}</td>
                        <td>
                            <audio controls src="{{ asset('bgms/' . $asset->filename) }}"></audio>

                            <form action="{{ route('admin.assets.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('この素材を削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-detail">削除</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">登録されているBGMはありません。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h3>SE一覧</h3>
        <table class="table-wide">
            <thead>
                <tr>
                    <th>名前</th>
                    <th>ファイル名</th>
                    <th>プレビュー / 操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($assets->where('type', 'se') as $asset)
                    <tr>
                        <td>{{ $asset->name }}</td>
                        <td>{{ $asset->filename }}</td>
                        <td>
                            <audio controls src="{{ asset('ses/' . $asset->filename) }}"></audio>

                            <form action="{{ route('admin.assets.destroy', $asset->id) }}" method="POST" onsubmit="return confirm('この素材を削除しますか？');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn btn-detail">削除</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3">登録されているSEはありません。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </body>
</html>
