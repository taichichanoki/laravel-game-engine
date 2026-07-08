<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>管理者画面 -シーン詳細-</title>
        @vite(['resources/css/admin.css', 'resources/css/admin-scene.css', 'resources/js/admin.js'])
    </head>
    <body>
        <a href="{{ route('admin.scenes.index') }}" class="back-link">シーン管理一覧へ戻る</a>
        <form action="{{ route('admin.scenes.destroy', $scene->id) }}" method="POST" onsubmit="return confirm('このシーンを削除しますか？（中のステップや選択肢も削除されます。）')" class="action-form align-right">
            @csrf
            @method('DELETE')
            <button type="submit" class="action-btn btn-detail">シーンを削除</button>
        </form>

        <form action="{{ route('admin.scenes.update', $scene->id) }}" method="POST" id="title-edit-form">
            @csrf
            @method('PUT')
            <h1>
                <span>シーン詳細: </span>
                <span id="title-text">{{ $scene->title }}</span>
                <input type="text" name="title" id="title-input" value="{{ $scene->title }}" required maxlength="255" style="display: none">
                <button type="button" id="title-edit-btn" class="action-btn btn-detail align-right js-skip" data-mode="view">名前変更</button>
            </h1>
        </form>

        <h3>ステップ一覧</h3>
        <a href="{{ route('admin.scenes.createStep', $scene->id) }}" class="btn-detail">+ 新規ステップ作成</a>
        <table class="table-wide">
            <thead>
                <tr>
                    <th>順序</th>
                    <th>テキスト</th>
                    <th>背景画像</th>
                    <th>BGM / SE</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($scene->sceneSteps as $step)
                    <tr>
                        <td>{{ $step->step_order }}</td>
                        <td>{{ \Illuminate\Support\Str::limit($step->text, 60, '…') }}</td>
                        <td>
                            @if($step->bgImageAsset)
                                {{ $step->bgImageAsset->name }}
                            @else
                                <span>なし</span>
                            @endif
                        </td>
                        <td>
                            BGM:
                            @if($step->bgmAsset)
                                {{ $step->bgmAsset->name }}
                            @else
                                なし
                            @endif
                            <br>
                            SE:
                            @if($step->seAsset)
                                {{ $step->seAsset->name }}
                            @else
                                なし
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.scenes.editStep', [$scene->id, $step->id]) }}" class="btn-detail">編集</a>

                            <form action="{{ route('admin.scenes.destroyStep', [$scene->id, $step->id]) }}" method="POST" onsubmit="return confirm('このステップを削除しますか？');" class="delete-form">
                                @csrf
                                @method('DELETE') <button type="submit" class="action-btn btn-detail">削除</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">このシーンにはまだステップが登録されていません。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h3>選択肢一覧</h3>
        <a href="{{ route('admin.scenes.createChoice', $scene->id) }}" class="btn-detail">+ 新規選択肢作成</a>
        <table class="table-wide">
            <thead>
                <tr>
                    <th>テキスト</th>
                    <th>遷移先シーン</th>
                    <th>出現条件</th>
                    <th>ステータス変動</th>
                    <th>操作</th>
                </tr>
            </thead>
            <tbody>
                @forelse($scene->choices as $choice)
                    <tr>
                        <td>{{ \Illuminate\Support\Str::limit($choice->text, 60, '…') }}</td>
                        <td>
                            ID: {{ $choice->next_scene_id }} <br>
                            @if($choice->nextScene)
                                <a href="{{ route('admin.scenes.show', $choice->next_scene_id) }}" class="scene-link">{{ $choice->nextScene->title }}</a>
                            @else
                                <span>未設定</span>
                            @endif
                        </td>
                        <td>
                            行動: {{ $choice->min_energy_required }}以上 <br>
                            異形度: {{ $choice->min_alignment_required ?? '制限なし'}} ～ {{ $choice->max_alignment_required ?? '制限なし'}}<br>
                            好感度: {{ $choice->min_affection_required }}以上
                        </td>
                        <td>
                            行動: {{ $choice->energy_change >= 0 ? '+'.$choice->energy_change : $choice->energy_change }}<br>
                            異形度: {{ $choice->alignment_change >= 0 ? '+'.$choice->alignment_change : $choice->alignment_change }}<br>
                            好感度: {{ $choice->affection_change >= 0 ? '+'.$choice->affection_change : $choice->affection_change }}
                        </td>
                        <td>
                            <a href="{{ route('admin.scenes.editChoice', [$scene->id, $choice->id]) }}" class="btn-detail">編集</a>

                            <form action="{{ route('admin.scenes.destroyChoice', [$scene->id, $choice->id]) }}" method="POST" onsubmit="return confirm('この選択肢を削除しますか？');" class="action-form">
                                @csrf
                                @method('DELETE') <button type="submit" class="action-btn btn-detail">削除</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">このシーンには選択肢が登録されていません。</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </body>
</html>
