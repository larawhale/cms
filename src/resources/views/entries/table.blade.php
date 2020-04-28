@php
    $columns = $entryClass->getTableColumns();

    $rows = [];

    foreach ($items as $entry) {
        $row = [];

        $entryClass = $entry->toEntryClass();

        foreach ($columns as $column) {
            if (Str::startsWith($column, 'entry_model:')) {
                $property = Arr::last(explode(':', $column));

                $value = data_get($entry, $property);
            } else {
                $value = data_get($entryClass, $column);
            }

            $row[$column] = $value;
        }

        $rows[] = $row;
    }
@endphp

<table class="table table-hover table-click">
    <thead>
        <tr>
            @foreach ($columns as $column)
                <th>
                    {{ __('cms::entries.index.columns.' . $column) }}
                </th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach($rows as $key => $row)
            <tr class="action-href" href="{{ route('cms.entries.edit', [
                'entry' => $items[$key],
            ]) }}">
                @foreach ($row as $value)
                    <td>
                        {{ $value }}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
