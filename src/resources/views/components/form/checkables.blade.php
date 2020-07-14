<div>
    @foreach ($list as $key => $item)
        @php
            $uniqueName = $name . "[$key]";

            $checkableName = $type === 'checkbox'
                ? $uniqueName
                : $name;

            $checked = $type === 'checkbox'
                ? !!data_get($value, $key)
                : $value === $item;
        @endphp

        @include('cms::components.form.checkable', [
            'attributes' => [
                'id' => $uniqueName,
            ] + $attributes,
            'checked' => $checked,
            'label' => $item,
            'name' => $checkableName,
            'type' => $type,
            'value' => $item,
        ])
    @endforeach
</div>
