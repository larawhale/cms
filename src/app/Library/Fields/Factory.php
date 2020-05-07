<?php

namespace LaraWhale\Cms\Library\Fields;

use LaraWhale\Cms\Models\Field as FieldModel;
use LaraWhale\Cms\Exceptions\RequiredConfigKeyNotFoundException;
use LaraWhale\Cms\Library\Fields\Contracts\AbstractFieldInterface;

class Factory
{
    /**
     * The type and field map.
     *
     * @var array
     */
    public static array $fields = [];

    /**
     * Makes an instance of field according to the given config.
     *
     * @param  array  $config
     * @param  \LaraWhale\Cms\Models\Field  $fieldModel
     * @return \LaraWhale\Cms\Library\Fields\Contracts\AbstractFieldInterface
     */
    public static function make(array $config, FieldModel $fieldModel = null): AbstractFieldInterface
    {
        $key = static::getFromConfig('key', $config);

        $type = static::getFromConfig('type', $config);

        $class = static::resolve($type);

        return new $class(
            $key,
            $type,
            data_get($config, 'config', []),
            $fieldModel,
        );
    }

    /**
     * Resolves the type to a field class.
     *
     * @param  strin  $type
     * @return string
     */
    public static function resolve(string $type): string
    {
        return data_get(
            static::$fields,
            $type,
            static::defaultFieldClass(),
        );
    }

    /**
     * Tries to retrieve a type from the given config.
     *
     * @param  string  $key
     * @param  array  $config
     * @return string
     * @throws \LaraWhale\Cms\Exceptions\RequiredConfigKeyNotFoundException
     */
    public static function getFromConfig(string $key, array $config): string
    {
        $value = data_get($config, $key);

        if (! is_null($value)) {
            return $value;
        }

        throw new RequiredConfigKeyNotFoundException($config, $key);
    }

    /**
     * Returns the default field class.
     *
     * @return string
     */
    public static function defaultFieldClass(): string
    {
        return data_get(static::$fields, 'default', InputField::class);
    }
}
