<?php

namespace Modular\ModuleGenerator\Generators;

use Illuminate\Support\Facades\File;
use Modular\ModuleGenerator\Support\Naming;

class ResourceGenerator
{
    public static function make(string $module, string $model): void
    {
        $moduleClass = Naming::class($module);
        $modelClass = Naming::class($model);
        $class = "{$modelClass}Resource";

        $path = app_path("Modules/{$moduleClass}/Http/Resources/{$class}.php");

        if (File::exists($path)) return;

        File::ensureDirectoryExists(dirname($path));

        $stub = File::get(__DIR__ . '/../Stubs/resource.stub');

        File::put(
            $path,
            str_replace(
                [
                    '{{ module }}',
                    '{{ model }}',
                    '{{ modelCamel }}',
                    '{{ modelPlural }}',
                    '{{ modelPluralCamel }}',
                ],
                [
                    $moduleClass,
                    $modelClass,
                    Naming::camel($model),
                    Naming::plural($model),
                    Naming::camel(Naming::plural($model)),
                ],
                $stub
            )
        );
    }
}