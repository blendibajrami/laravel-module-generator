<?php

namespace Modular\ModuleGenerator\Generators;

use Illuminate\Support\Facades\File;

class ResourceGenerator
{
    public static function make(string $module, string $model): void
    {
        $class = "{$model}Resource";
        $path = app_path("Modules/{$module}/Http/Resources/{$class}.php");

        if (File::exists($path)) return;

        File::ensureDirectoryExists(dirname($path));

        $stub = File::get(__DIR__ . '/../Stubs/resource.stub');

        File::put(
            $path,
            str_replace(
                ['{{ module }}', '{{ class }}'],
                [$module, $class],
                $stub
            )
        );
    }
}
