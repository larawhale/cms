<?php

namespace LaraWhale\Cms\Library\Fields;

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
     * @return \LaraWhale\Cms\Library\Fields\Contracts\AbstractFieldInterface
     */
    public static function make(array $config): AbstractFieldInterface
    {
        $type = static::getType($config);

        $class = static::resolve($type);

        return new $class($config);
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
     * @param  array  $config
     * @return string
     * @throws \LaraWhale\Cms\Exceptions\RequiredConfigKeyNotFoundException
     */
    public static function getType(array $config): string
    {
        $type = data_get($config, 'type');

        if (! is_null($type)) {
            return $type;
        }

        throw new RequiredConfigKeyNotFoundException($config, 'type');
    }

    /**
     * Returns the default field class.
     *
     * @return string
     */
    public static function defaultFieldClass(): string
    {
        return data_get(static::$fields, 'default', DefaultField::class);
    }
}
