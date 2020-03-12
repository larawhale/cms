@component('cms::components.card')
    @slot('cardHeader')
        Pagination
    @endslot

    <nav>
        <ul class="pagination">
            <li class="page-item disabled">
                <a class="page-link" href="#">
                    <i class="fa fa-chevron-left"></i>
                </a>
            </li>

            @foreach (range(0, 4) as $page)
                <li class="page-item {{ $page == 0 ? 'active' : '' }}">
                    <a class="page-link" href="#">
                        {{ $page + 1 }}
                    </a>
                </li>
            @endforeach

            <li class="page-item">
                <a class="page-link" href="#" aria-label="Next">
                    <i class="fa fa-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
@endcomponent
