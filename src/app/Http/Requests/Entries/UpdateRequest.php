<?php

namespace LaraWhale\Cms\Http\Requests\Entries;

use Illuminate\Foundation\Http\FormRequest;
use LaraWhale\Cms\Http\Requests\Concerns\CopiesDotKeys;

class UpdateRequest extends FormRequest
{
    use CopiesDotKeys;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $entry = request()->route()->entry;

        return $entry->toEntryClass()->getRules();
    }
}
