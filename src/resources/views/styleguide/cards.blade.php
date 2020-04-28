@component('cms::components.card')
    @slot('cardHeader')
        Cards
    @endslot

    @component('cms::components.card')
        @slot('cardHeader')
            Card header
        @endslot

        <h5 class="card-title">
            Card title
        </h5>

        <h6 class="card-subtitle mb-2 text-muted">
            Card subtitle
        </h6>

        <p class="card-text">
            Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quidem nulla deserunt dolores, eum tempore, similique unde? Similique, sapiente blanditiis quibusdam vitae necessitatibus quidem minus nam, optio dolorum vel, consequatur ullam.
        </p>

        @slot('cardFooter')
            Card footer
        @endslot
    @endcomponent
@endcomponent
