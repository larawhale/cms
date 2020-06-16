<div class="cms-fields">
    @foreach ($fields as $field)
        {!! $field->renderFormGroup() !!}
    @endforeach
</div>
