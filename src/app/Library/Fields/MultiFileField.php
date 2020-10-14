<?php

namespace LaraWhale\Cms\Library\Fields;

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
        dd($value, $this->getValue());
        if (is_array($value)) {
            $value = array_map(function ($v) {
                return parent::getDatabaseValue($v);
            }, $value);
        }
        
        return $this->traitGetDatabaseValue($value);
    }

    /**
     * Returns file field instance for the files in the value.-white
     * 
     * @return array
     */
    public function getFileFieldInstances(): array
    {
        return array_map(function ($v) {
            return (new FileField('', ''))->setValue($v);
        }, $this->getValue());
    }
}
