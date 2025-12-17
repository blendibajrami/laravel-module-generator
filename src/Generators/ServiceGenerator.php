<?php
namespace Modular\ModuleGenerator\Generators;

use Illuminate\Support\Facades\File;
use Modular\ModuleGenerator\Support\Naming;

class ServiceGenerator
{
    public static function make(string $module, string $model): void
    {
        $moduleClass = Naming::class($module);
        $modelClass = Naming::class($model);
        $class = "{$modelClass}Service";

        $path = app_path("Modules/{$moduleClass}/Services/{$class}.php");

        if (File::exists($path)) return;

        File::ensureDirectoryExists(dirname($path));

        $stub = File::get(__DIR__ . '/../Stubs/service.stub');

        File::put(
            $path,
            str_replace(
                [
                    '{{ module }}',
                    '{{ model }}',
                    '{{ repositoryCamel }}'
                ],
                [
                    $moduleClass,
                    $modelClass,
                    Naming::camel("{$model}Repository")
                ],
                $stub
            )
        );
    }
}
