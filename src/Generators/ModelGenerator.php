<?php

namespace Modular\ModuleGenerator\Generators;

use Illuminate\Support\Facades\File;

class ModelGenerator
{
    public static function make(string $module, string $model): void
    {
        $path = app_path("Modules/{$module}/Models/{$model}.php");

        if (File::exists($path)) return;

        File::ensureDirectoryExists(dirname($path));

        $stub = File::get(__DIR__ . '/../Stubs/model.stub');

        File::put(
            $path,
            str_replace(
                ['{{ module }}', '{{ model }}'],
                [$module, $model],
                $stub
            )
        );
    }
}
