<?php

namespace LaraWhale\Cms\Http\Requests\Entries;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $entry = request()->route()->entry;

        return $entry->toEntryClass()->rules();
    }
}
