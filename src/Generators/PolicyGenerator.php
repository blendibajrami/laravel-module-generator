<?php

namespace Modular\ModuleGenerator\Generators;

use Illuminate\Support\Facades\File;
use Modular\ModuleGenerator\Support\Naming;

class PolicyGenerator
{
    public static function make(string $module, string $model): void
    {
        $moduleClass = Naming::class($module);
        $modelClass = Naming::class($model);

        $class = "{$modelClass}Policy";
        $path = app_path("Modules/{$moduleClass}/Policies/{$class}.php");

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
                    $moduleClass,
                    $modelClass,
                    Naming::camel($model),
                    Naming::camel(Naming::plural($model)),
                ],
                $stub
            )
        );
    }
}
