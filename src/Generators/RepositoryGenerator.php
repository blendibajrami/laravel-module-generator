<?php

namespace Modular\ModuleGenerator\Generators;

use Illuminate\Support\Facades\File;

class RepositoryGenerator
{
    public static function make(string $module, string $model): void
    {
        $repo = "{$model}Repository";
        $interface = "{$model}RepositoryInterface";

        $paths = [
            app_path("Modules/{$module}/Repositories/{$repo}.php") =>
                'repository.stub',
            app_path("Modules/{$module}/Repositories/Contracts/{$interface}.php") =>
                'repository-interface.stub',
        ];

        foreach ($paths as $path => $stubFile) {
            if (File::exists($path)) continue;

            File::ensureDirectoryExists(dirname($path));

            $stub = File::get(__DIR__ . "/../Stubs/{$stubFile}");

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
}
