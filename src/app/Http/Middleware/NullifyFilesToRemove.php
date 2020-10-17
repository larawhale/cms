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
        // TODO: check nested values.

        // Check each key of file for the same key to be present in data and
        // having the 'remove' value. This means the file should be remove. The
        // `FileField` will take care of removing the file when value is `null`.
        $this->nullifyRemove($data, array_keys($_FILES));

        return $data;
    }

    /**
     * Loops given keys and check if they need to be nullified in the data
     * array.
     * 
     * @param  array  &$data
     * @param  array  $keys
     * @param  string  $parentKey
     * @return void
     */
    private function nullifyRemove(array &$data, array $keys, string $parentKey = ''): void
    {
        foreach ($keys as $i => $key) {
            $dataKey = $parentKey ? "$parentKey.$key" : $key;

            $dataValue = data_get($data, $dataKey);

            if (is_array($dataValue)) {
                $this->nullifyRemove(
                    $data,
                    array_keys($dataValue),
                    $dataKey,
                );
            } else if ($dataValue === 'remove') {
                data_set($data, $dataKey, null);
            }
        }
    }
}
