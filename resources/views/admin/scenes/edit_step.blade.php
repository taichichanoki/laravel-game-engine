<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>管理者画面 -ステップ{{ isset($step) ? '編集' : '作成' }}-</title>
        @vite(['resources/css/admin.css', 'resources/css/admin-scene.css', 'resources/js/admin.js'])
    </head>
    <body>
        <a href="{{ route('admin.scenes.show', $scene->id) }}" class="back-link">シーン詳細へ戻る</a>

        <h1>ステップ{{ isset($step) ? '編集' : '作成' }} : {{ $scene->title }}</h1>

        <form action="{{ isset($step) ? route('admin.scenes.updateStep', [$scene->id, $step->id]) : route('admin.scenes.storeStep', $scene->id) }}" method="POST" class="admin-form">
            @csrf
            @if(isset($step)) @method('PUT') @endif

            <div class="form-group">
                <lavel for="step-order">順序</lavel>
                <select name="step_order" id="step_order" class="form-control">
                    @php
                        $loopMax = isset($step) ? $scene->sceneSteps()->max('step_order') : $nextOrder;
                        $currentOrder = isset($step) ? $step->step_order : $nextOrder;
                    @endphp

                    @for($i = 1; $i <= $loopMax; $i++)
                        <option value="{{ $i }}" {{ $currentOrder == $i ? 'selected' : '' }}>{{ $i }}番目に挿入</option>
                    @endfor
                </select>
                @error('step-order')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="text">テキスト</label>
                <textarea name="text" id="text" rows="6" class="form-control" required>{{ old('text', $step->text ?? '') }}</textarea>
                @error('text')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="bg_image">背景画像（任意）</label>
                <select name="bg_image" id="bg_image" class="form-control">
                    <option value="" {{ old('bg_image', $step->bg_image ?? '') == '' ? 'selected' : ''}}>-- 選択なし（設定しない） --</option>
                    @foreach ($bgImages as $asset)
                        <option value="{{ $asset->filename }}" {{ old('bg_image', $step->bg_image ?? '') == $asset->filename ? 'selected' : ''}}>{{ $asset->name }} （{{ $asset->filename }}）</option>
                    @endforeach
                </select>
                @error('bg_image')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="bgm">BGM（任意）</label>
                <select name="bgm" id="bgm" class="form-control">
                    <option value="" {{ old('bgm', $step->bgm ?? '') == '' ? 'selected' : ''}}>-- 選択なし（設定しない） --</option>
                    @foreach ($bgms as $asset)
                        <option value="{{ $asset->filename }}" {{ old('bgm', $step->bgm ?? '') == $asset->filename ? 'selected' : ''}}>{{ $asset->name }} （{{ $asset->filename }}）</option>
                    @endforeach
                </select>
                @error('bgm')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="se">SE（任意）</label>
                <select name="se" id="se" class="form-control">
                    <option value="" {{ old('se', $step->se ?? '') == '' ? 'selected' : ''}}>-- 選択なし（設定しない） --</option>
                    @foreach ($ses as $asset)
                        <option value="{{ $asset->filename }}" {{ old('se', $step->se ?? '') == $asset->filename ? 'selected' : ''}}>{{ $asset->name }} （{{ $asset->filename }}）</option>
                    @endforeach
                </select>
                @error('se')
                    <span class="error-msg">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-success">{{ isset($step) ? '変更を保存する' : 'ステップを追加する' }}</button>
            </div>
        </form>
    </body>
</html>
