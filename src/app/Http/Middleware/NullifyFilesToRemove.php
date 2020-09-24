<?php

namespace LaraWhale\Cms\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class NullifyFilesToRemove extends TransformsRequest
{
    /**
     * Clean the data in the given array.
     *
     * @param  array  $data
     * @param  string  $keyPrefix
     * @return array
     */
    protected function cleanArray(array $data, $keyPrefix = ''): array
    {
        // Check each key of file for the same key to be present in data and
        // having the 'remove' value. This means the file should be remove. The
        // `FileField` will take care of removing the file when value is `null`.
        foreach ($_FILES as $key => $value) {
            if (data_get($data, $key) === 'remove') {
                $data[$key] = null;
            }
        }

        return $data;
    }
}
