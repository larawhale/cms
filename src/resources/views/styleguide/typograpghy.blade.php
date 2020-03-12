@component('cms::components.card')
    @slot('cardHeader')
        Headings
    @endslot

    @for ($i = 1; $i < 7; $i++)
        <h{{ $i }}>
            h{{ $i }}. Heading
        </h{{ $i }}>
    @endfor
@endcomponent
