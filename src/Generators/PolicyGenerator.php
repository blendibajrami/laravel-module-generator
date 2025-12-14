<?php

namespace Modular\ModuleGenerator\Generators;

use Illuminate\Support\Facades\File;
use Modular\ModuleGenerator\Support\Naming;

class PolicyGenerator
{
    public static function make(string $module, string $model): void
    {
        $class = "{$model}Policy";
        $path = app_path("Modules/{$module}/Policies/{$class}.php");

        if (File::exists($path)) return;

        File::ensureDirectoryExists(dirname($path));

        $stub = File::get(__DIR__ . '/../Stubs/policy.stub');

        File::put(
            $path,
            str_replace(
                [
                    '{{ module }}',
                    '{{ model }}',
                    '{{ modelCamel }}',
                    '{{ modelPluralCamel }}'
                ],
                [
                    $module,
                    $model,
                    Naming::camel($model),
                    Naming::camel(Naming::plural($model))
                ],
                $stub
            )
        );
    }
}
