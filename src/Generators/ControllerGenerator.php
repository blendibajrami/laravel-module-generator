<?php

namespace Modular\ModuleGenerator\Generators;

use Illuminate\Support\Facades\File;
use Modular\ModuleGenerator\Support\Naming;

class ControllerGenerator
{
    public static function make(string $module, string $model): void
    {
        $controller = "{$model}Controller";
        $path = app_path("Modules/{$module}/Http/Controllers/{$controller}.php");

        if (File::exists($path)) return;

        File::ensureDirectoryExists(dirname($path));

        $stub = File::get(__DIR__ . '/../Stubs/controller.stub');

        File::put(
            $path,
            str_replace(
                [
                    '{{ module }}',
                    '{{ model }}',
                    '{{ modelCamel }}',
                    '{{ modelPlural }}',
                    '{{ modelPluralCamel }}'
                ],
                [
                    $module,
                    $model,
                    Naming::camel($model),
                    Naming::plural($model),
                    Naming::camel(Naming::plural($model))
                ],
                $stub
            )
        );
    }
}
