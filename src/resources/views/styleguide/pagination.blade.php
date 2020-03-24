@component('cms::components.card')
    @slot('cardHeader')
        Pagination
    @endslot

    @php
        $paginator = new Illuminate\Pagination\LengthAwarePaginator(
            range(1, 50),
            50,
            1,
            null,
            [
                'path' => Route::current()->uri,
            ],
        );
    @endphp

    {{ $paginator->links() }}
@endcomponent
