<cms-multi-select
    :list='@json($list)'
    name="{{ $name }}"
    :value='@json($value)'
    {!! Html::attributes($attributes) !!}
></cms-multi-select>
