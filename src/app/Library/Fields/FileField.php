<?php

namespace LaraWhale\Cms\Library\Fields;

use Illuminate\Http\UploadedFile;
use LaraWhale\Cms\Models\Entry as EntryModel;

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
     * Saves the field to the database.
     *
     * @param  \LaraWhale\Cms\Models\Entry  $entryModel
     * @param  mixed  $value
     * @return self
     */
    public function save(EntryModel $entryModel, $value): self
    {
        $path = $this->saveFile($value);

        // TODO: Cleanup old file?

        return parent::save($entryModel, $path);
    }

    /**
     * Saves the file to storage.
     * 
     * @param  \Illuminate\Http\UploadedFile  $file
     * @return string
     */
    public function saveFile(UploadedFile $file): string
    {
        // TODO: Come up with better way to get uniqueness.
        // Maybe make the folder unique.
        $filename = sprintf(
            '%s_%s',
            uniqid(),
            $file->getClientOriginalName(),
        );

        return $file->storeAs($this->getFilePath(), $filename);
    }

    /**
     * Returns the file path of the file.
     * 
     * @return string
     */
    public function getFilePath(): string
    {
        return $this->config('file_path', 'files');
    }
}
