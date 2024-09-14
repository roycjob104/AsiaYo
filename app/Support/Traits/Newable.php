<?php

namespace App\Support\Traits;

trait Newable
{
    /**
     * @return static
     */
    public static function new()
    {
        $args = func_get_args();
        if (count($args) === 0) {
            return app(static::class);
        }

        return app()->makeWith(static::class, ...$args);
    }
}
