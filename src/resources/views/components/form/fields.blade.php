<div>
    @foreach ($fields as $field)
        {!! $field->renderFormGroup() !!}
    @endforeach
</div>
