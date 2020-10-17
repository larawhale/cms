<?php

namespace LaraWhale\Cms\Library\Fields;

use Illuminate\Http\UploadedFile;
use LaraWhale\Cms\Library\Fields\Concerns\HasArrayValue;

class MultiFileField extends FileField
{
    use HasArrayValue {
        getDatabaseValue as traitGetDatabaseValue;
    }
    
    /**
     * Returns a rendered input.
     *
     * @return string
     */
    public function renderInput(): string
    {
        return view('cms::components.form.multi-file', [
            'name' => $this->getKey(),
            'attributes' => $this->getInputAttributes(),
            'value' => $this->getInputValue(),
        ])->render();
    }

    /**
     * Returns the css id for the rendered input.
     *
     * @return string
     */
    public function getInputId(): string
    {
        $id = parent::getInputId();

        return $id ? $id . '[]' : $id;
    }

    /**
     * Returns a representation of how the value should be stored in the
     * database.
     *
     * @param  mixed  $value
     * @return string
     */
    public function getDatabaseValue($value): string
    {
        if (is_array($value)) {
            $value = $value + $this->getValue();

            $value = array_map(function ($f) use ($value) {
                $key = $f->getKey();

                $newValue = $value[$key];

                // Regard the value to be changed when a file was uploaded or
                // `null` was provided. Other values types are regarded as
                // "unchanged".
                if ($newValue instanceof UploadedFile
                    || is_null($newValue)
                ) {
                    return $f->getDatabaseValue($newValue);
                }

                return $f->getValue();
            }, $this->getFileFieldInstances($value));

            $value = [...array_filter($value)];
        }
        
        return $this->traitGetDatabaseValue($value);
    }

    /**
     * Returns file field instance for the files in the value.-white
     * 
     * @param  array  $value
     * @return array
     */
    public function getFileFieldInstances(array $value = null): array
    {
        $value = $value ?? $this->getValue();

        return array_map(function ($v, $k) {
            return (new FileField($k, ''))->setValue($v);
        }, $value, array_keys($value));
    }
}
