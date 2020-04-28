@component('cms::components.card')
    @slot('cardHeader')
        Buttons
    @endslot

    @php
        $buttons = [
            'primary', 'secondary', 'success', 'danger', 'warning', 'info',
            'light', 'dark', 'link',
        ];
    @endphp

    <div>
        @foreach ($buttons as $button)
            <button class="btn btn-{{ $button }}">
                {{ $button }}
            </button>
        @endforeach
    </div>

    <br>

    <div>
        @foreach ($buttons as $button)
            <button class="btn btn-{{ $button }}" disabled="disabled">
                {{ $button }}
            </button>
        @endforeach
    </div>

    <br>

    <div>
        @foreach ($buttons as $button)
            <button class="btn btn-outline-{{ $button }}">
                {{ $button }}
            </button>
        @endforeach
    </div>

    <br>

    <div>
        @foreach ($buttons as $button)
            <button class="btn btn-outline-{{ $button }}" disabled="disabled">
                {{ $button }}
            </button>
        @endforeach
    </div>
@endcomponent
