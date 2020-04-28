@php
    $inputs = [
        [
            'name' => 'text',
            'options' => [
                'placeholder' => 'Placeholder',
            ],
            'type' => 'text',
        ],
        [
            'name' => 'date',
            'options' => [
                'placeholder' => 'Placeholder',
            ],
            'type' => 'date',
        ],
        [
            'list' => range(0, 2),
            'name' => 'select',
            'options' => [
                'placeholder' => 'Placeholder',
            ],
            'type' => 'select',
        ],
        [
            'name' => 'checkbox',
            'type' => 'checkbox',
        ],
        [
            'name' => 'radio',
            'type' => 'radio',
        ],
        [
            'name' => 'textarea',
            'options' => [
                'placeholder' => 'Placeholder',
            ],
            'type' => 'textarea',
        ],
        [
            'name' => 'file',
            'options' => [
                'placeholder' => 'Placeholder',
            ],
            'type' => 'file',
        ],
    ];
@endphp

@component('cms::components.card')
    @slot('cardHeader')
        Form
    @endslot

    <table class="table table-borderless">
        @foreach ($inputs as $properties)
            <tr>
                <td width="{{ 1/3*100 }}%">
                    @include('cms::components.form.group', $properties)
                </td>

                <td width="{{ 1/3*100 }}%">
                    @php
                        $disabled = $properties;

                        data_set($disabled, 'options.disabled', true);

                        $disabled['name'] = $disabled['name'] . '_disabled';
                    @endphp

                    @include('cms::components.form.group', $disabled)
                </td>

                <td width="{{ 1/3*100 }}%">
                    @php
                        $error = $properties;

                        $error['name'] = $error['name'] . '_error';

                        $errors = $errors->add($error['name'], 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.');

                        $error['errors'] = $errors;
                    @endphp

                    @include('cms::components.form.group', $error)
                </td>
            </tr>
        @endforeach
    </table>

    @include('cms::components.form.group', [
        'helpText' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.',
        'name' => 'help text',
        'options' => [
            'placeholder' => 'Placeholder',
        ],
        'type' => 'text',
    ])
@endcomponent
