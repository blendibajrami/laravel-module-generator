<?php

namespace Modular\ModuleGenerator\Support;

use Illuminate\Support\Str;

class Naming
{
    public static function class(string $name): string
    {
        return Str::studly($name);
    }

    public static function camel(string $name): string
    {
        return Str::camel($name);
    }

    public static function plural(string $name): string
    {
        return Str::plural(self::class($name));
    }

    public static function pluralCamel(string $name): string
    {
        return Str::camel(self::plural($name));
    }

    public static function snakePlural(string $name): string
    {
        return Str::snake(self::plural($name));
    }
}
