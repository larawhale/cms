<table class="table {{ $class ?? '' }}">
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
            <tr>
                @foreach ($columns as $column)
                    <td>
                        {{ data_get($item, $column) }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
