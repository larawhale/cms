<cms-multi-fields
    name="{{ $name }}"
    :value='@json($value)'
>
    @include('cms::components.form.fields', compact('name', 'fields'))
</cms-multi-fields>
