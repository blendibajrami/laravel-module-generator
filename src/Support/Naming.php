<?php

namespace Modular\ModuleGenerator\Support;

use Illuminate\Support\Str;

class Naming
{
    public static function plural(string $name): string
    {
        return Str::plural($name);
    }

    public static function camel(string $name): string
    {
        return lcfirst($name);
    }

    public static function snakePlural(string $name): string
    {
        return Str::plural(Str::snake($name));
    }
}
