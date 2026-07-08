<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>管理者画面 -選択肢{{ isset($choice) ? '編集' : '作成' }}-</title>
        @vite(['resources/css/admin.css', 'resources/css/admin-scene.css', 'resources/js/admin.js'])
    </head>
    <body>
        <a href="{{ route('admin.scenes.show', $scene->id) }}" class="back-link">シーン詳細へ戻る</a>

        <h1>選択肢{{ isset($choice) ? '編集' : '作成' }} : {{ $scene->title }}</h1>

        <form action="{{ isset($choice) ? route('admin.scenes.updateChoice', [$scene->id, $choice->id]) : route('admin.scenes.storeChoice', $scene->id) }}" method="POST" class="admin-form">
            @csrf
            @if(isset($choice)) @method('PUT') @endif

            <div class="form-group">
                <label for="text">選択肢テキスト</label>
                <input type="text" name="text" id="text" class="form-control" value="{{ old('text', $choice->text ?? '') }}" required>
                @error('text')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="next_scene_id">遷移先シーン</label>
                <select name="next_scene_id" id="next_scene_id" class="form-control">
                    <option value="">-- 遷移先シーンを選択してください --</option>
                    @foreach($scenes as $s)
                        <option value="{{ $s->id }}" {{ old('next_scene_id', $choice->next_scene_id ?? '') == $s->id ? 'selected' : '' }}>[ID:{{ $s->id }}] {{ $s->title }}</option>
                    @endforeach
                </select>
                @error('next_scene_id')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <h3>出現条件（満たしていないと選択肢が表示されません）</h3>

            <div class="form-group">
                <label for="min_energy_required">出現最低行動力（０以上）</label>
                <input type="number" name="min_energy_required" id="min_energy_required" class="form-control" value="{{ old('min_energy_required', $choice->min_energy_required ?? 0) }}" min="0" required>
                @error('min_energy_required')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="min_alignment_required">出現最低異形度（任意）</label>
                <input type="number" name="min_alignment_required" id="min_alignment_required" class="form-control" value="{{ old('min_alignment_required', $choice->min_alignment_required ?? '') }}">
                @error('min_alignment_required')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="max_alignment_required">出現最高異形度（任意）</label>
                <input type="number" name="max_alignment_required" id="max_alignment_required" class="form-control" value="{{ old('max_alignment_required', $choice->max_alignment_required ?? '') }}">
                @error('max_alignment_required')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="min_affection_required">出現最低友好度（０以上）</label>
                <input type="number" name="min_affection_required" id="min_affection_required" class="form-control" value="{{ old('min_affection_required', $choice->min_affection_required ?? 0) }}" min="0" required>
                @error('min_affection_required')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <h3>ステータス変化（選択した際の値の増減。０、マイナス値も可）</h3>

            <div class="form-group">
                <label for="energy_change">行動力変化量</label>
                <input type="number" name="energy_change" id="energy_change" class="form-control" value="{{ old('energy_change', $choice->energy_change ?? 0) }}" required>
                @error('energy_change')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="alignment_change">異形度変化量</label>
                <input type="number" name="alignment_change" id="alignment_change" class="form-control" value="{{ old('alignment_change', $choice->alignment_change ?? 0) }}" required>
                @error('alignment_change')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="affection_change">好感度変化量</label>
                <input type="number" name="affection_change" id="affection_change" class="form-control" value="{{ old('affection_change', $choice->affection_change ?? 0) }}" required>
                @error('affection_change')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-success">{{ isset($choice) ? '変更を保存する' : '選択肢を追加する' }}</button>
            </div>
        </form>
    </body>
</html>
