<div>
    @foreach ($list as $key => $item)
        @include('cms::components.form.checkable', [
            'name' => $name . "[$key]",
            'checked' => !!data_get($value, $key),
            'type' => 'checkbox',
            'label' => $item,
            'value' => $item,
            'attributes' => [
                'id' => $name . "[$key]",
            ] + $attributes,
        ])
    @endforeach
</div>
