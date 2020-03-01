<?php

namespace LaraWhale\Cms\Http\Requests\Entries;

use LaraWhale\Cms\Library\Entries\Factory;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [
            'entry_type' => [
                'required',
                'string',
                function (string $attribute, $value, callable $fail) {
                    if (! Factory::exists($value)) {
                        $fail(__(
                            'validation.exists',
                            ['attribute' => 'entry type'],
                        ));
                    }
                },
            ],
            'fields' => 'array',
        ];

        // Add rules of the fields for the specified entry type. These only
        // have to be added when type is present. The required rule on type
        // should fail if not.
        if ($type = request()->get('entry_type')) {
            $entry = Factory::make($type);

            $rules = array_merge($rules, $entry->rules());
        }

        return $rules;
    }
}
