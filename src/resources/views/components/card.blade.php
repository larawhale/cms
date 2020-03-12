<div class="card">
    @if (isset($cardHeader))
        <div class="card-header">
            {!! $cardHeader !!}
        </div>
    @endif

    <div class="card-body">
        {!! $slot !!}
    </div>

    @if (isset($cardFooter))
        <div class="card-footer">
            {!! $cardFooter !!}
        </div>
    @endif
</div>
