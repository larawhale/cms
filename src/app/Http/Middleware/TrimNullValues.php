<?php

namespace LaraWhale\Cms\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\TransformsRequest;

class TrimNullValues extends TransformsRequest
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
        return array_filter_recursive($data);
    }
}
