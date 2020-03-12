<table class="table table-hover table-click">
    <thead>
        <tr>
            @foreach ($columns as $column)
                <th>
                    {{ $column }}
                </th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach($items as $item)
            <tr class="action-href" href="{{ route('cms.entries.edit', [
                'entry' => $item,
            ]) }}">
                @foreach ($columns as $column)
                    <td>
                        {{ data_get($item, $column) }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
