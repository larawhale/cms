<?php

namespace LaraWhale\Cms\Http\Requests\Concerns;

use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Validation\Validator;

trait CopiesDotKeys
{
    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator(Validator $validator): void
    {
        // Some fields have child fields of which the key pattern is like
        // "parent[child]". The validator returns messages for field with dot
        // notated keys "parent.child". The retrieval of errors for these
        // fields is done by using the input name, "parent[child]", and thus
        // results in no error shown. This can be prevented by adding duplicate
        // messages under keys that are "bracked notated". 
        $validator->after(function ($validator) {
            $messages = $validator->messages()->toArray();

            $keys = array_keys($messages);

            $dotKeys = Arr::where($keys, fn ($k) => Str::contains($k, '.'));

            $extraMessages = collect($dotKeys)
                ->mapWithKeys(function ($k) use ($messages) {
                    $exploded = explode('.', $k);

                    $squareBrackets = array_map(function ($k, $i) {
                        // Do not apply the square brackets to the first part
                        // of the key. It would otherwise result in
                        // "[parent][child]" which does not make sense at all.
                        if ($i === 0) {
                            return $k;
                        }

                        return "[$k]";
                    }, $exploded, array_keys($exploded));

                    return [implode($squareBrackets) => $messages[$k]];
                })->all();

            $validator->messages()->merge($extraMessages);
        });
    }
}
