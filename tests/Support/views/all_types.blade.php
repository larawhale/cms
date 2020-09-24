@foreach ($entry->getValues() as $key => $value)
    <label>
        {{ $key }}
    </label>

    @php
        dump($entry->$key);
    @endphp

    <hr>
@endforeach
