<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>霧の森から</title>
        @vite(['resources/css/game.css', 'resources/css/menu.css', 'resources/js/game.js', 'resources/js/menu.js'])
    </head>
    <body>
        <button id="menu-toggle-btn" class="menu-trigger">
            <span></span>
            <span></span>
            <span></span>
        </button>
        <div id="game-menu" class="menu-overlay">
            <div class="menu-content">
                <h3 class="menu-title">MENU</h3>
                <div class="menu-choices">
                    <button id="menu-save-btn" class="choice-btn">セーブ</button>
                    <button id="menu-load-btn" class="choice-btn">ロード</button>
                    <a href="/" class="choice-btn text-center">タイトル画面へ</a>
                    <button id="menu-close-btn" class="choice-btn">ゲームに戻る</button>
                </div>
            </div>
        </div>

        <div id="save-modal" class="menu-overlay">
            <div class="menu-content save-content">
                <h3 class="menu-title">SAVE DATA</h3>
                <div class="menu-choices save-choices">
                    @php
                        $maxSlots = 2;
                    @endphp

                    @for ($i = 1; $i <= $maxSlots; $i++)
                        @if (isset($savedSlots[$i]))
                            <button class="choice-btn slot-btn" data-slot="{{ $i }}" id="slot-{{ $i }}">
                                <span class="slot-num">DATA {{ $i }}</span>
                                <span class="slot-date">{{ $savedSlots[$i]->updated_at->format('Y/m/d H:i') }}</span>
                            </button>
                        @else
                            <button class="choice-btn slot-btn empty-slot" data-slot="{{ $i }}" id="slot-{{ $i }}">
                                <span class="slot-num">DATA {{ $i }}</span>
                                <span class="slot-date no-slot-date">- NO DATA -</span>
                            </button>
                        @endif
                    @endfor
                </div>
                <button id="save-modal-close-btn" class="choice-btn save-back-btn">戻る</button>
            </div>
        </div>

        @include('components.load-modal')

        <div class="game-container" id="game-box">
            <div class="story-text" id="story-text">霧が立ち込めている...</div>
            <div class="choices-container" id="choices-container"></div>
        </div>
    </body>
</html>
