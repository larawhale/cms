<h1>
    Index entry
</h1>

@include('cms::components.table', [
    'columns' => ['id', 'type', 'updated_at', 'created_at'],
    'items' => $entries,
])
