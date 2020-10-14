<?php

namespace LaraWhale\Cms\Library\Fields;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileField extends InputField
{
    /**
     * Returns a rendered input.
     *
     * @return string
     */
    public function renderInput(): string
    {
        return view('cms::components.form.file', [
            'name' => $this->getKey(),
            'attributes' => $this->getInputAttributes(),
            'value' => $this->getInputValue(),
        ])->render();
    }

    /**
     * Returns the css class for the rendered input.
     *
     * @return string
     */
    public function getInputClass(): array
    {
        $classes = parent::getInputClass();

        $classes[] = 'custom-file-input';

        return array_unique($classes);
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
        if (! $value instanceof UploadedFile) {
            return parent::getDatabaseValue($value);
        }

        $path = $this->saveFile($value);

        $this->deleteFile();

        return $path;
    }

    /**
     * Saves the file to storage.
     *
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return string
     */
    public function saveFile(UploadedFile $file): string
    {
        $filename = sprintf(
            '%s_%s',
            uniqid(),
            $file->getClientOriginalName(),
        );

        return $file->storeAs($this->getFilePath(), $filename);
    }

    /**
     * Deletes the value of the field.
     *
     * @return void
     */
    public function deleteFile(): void
    {
        // There is no file when value is `null`. This happens when this field
        // has not been stored in the database before, or the value stored in
        // the database is `null`.
        if (is_null($this->value)) {
            return;
        }

        Storage::delete($this->value);
    }

    /**
     * Returns the file path of the file.
     *
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->config('file_path', '');
    }
}
