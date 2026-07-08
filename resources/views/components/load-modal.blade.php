<div id="load-modal" class="menu-overlay">
    <div class="menu-content save-content">
        <h3 class="menu-title">LOAD DATA</h3>
        <div class="menu-choices save-choices">
            @if (isset($savedSlots[0]))
                <button class="choice-btn slot-btn load-slot-btn" data-slot="0" id="load-slot-0">
                    <span class="slot-num">AUTO SAVE</span>
                    <span class="slot-date">{{ $savedSlots[0]->updated_at->format('Y/m/d H:i') }}</span>
                </button>
            @else
                <button class="choice-btn slot-btn load-slot-btn empty-slot no-click" data-slot="0" id="load-slot-0">
                    <span class="slot-num">AUTO SAVE</span>
                    <span class="slot-date no-slot-date">- NO DATA -</span>
                </button>
            @endif

            @php
                $maxSlots = 2;
            @endphp

            @for ($i = 1; $i <= $maxSlots; $i++)
                @if (isset($savedSlots[$i]))
                    <button class="choice-btn slot-btn load-slot-btn" data-slot="{{ $i }}" id="load-slot-{{ $i }}">
                        <span class="slot-num">DATA {{ $i }}</span>
                        <span class="slot-date">{{ $savedSlots[$i]->updated_at->format('Y/m/d H:i') }}</span>
                    </button>
                @else
                    <button class="choice-btn slot-btn load-slot-btn empty-slot no-click" data-slot="{{ $i }}" id="load-slot-{{ $i }}">
                        <span class="slot-num">DATA {{ $i }}</span>
                        <span class="slot-date no-slot-date">- NO DATA -</span>
                    </button>
                @endif
            @endfor
        </div>
        <button id="load-modal-close-btn" class="choice-btn save-back-btn">戻る</button>
    </div>
</div>
