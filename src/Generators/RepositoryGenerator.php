<?php

namespace Modular\ModuleGenerator\Generators;

use Illuminate\Support\Facades\File;
use Modular\ModuleGenerator\Support\Naming;

class RepositoryGenerator
{
    public static function make(string $module, string $model): void
    {
        $moduleClass = Naming::class($module);
        $modelClass = Naming::class($model);

        self::ensureBaseRepository();

        $repo = "{$modelClass}Repository";
        $interface = "{$modelClass}RepositoryInterface";

        $paths = [
            app_path("Modules/{$moduleClass}/Repositories/{$repo}.php") => 'repository.stub',
            app_path("Modules/{$moduleClass}/Repositories/Contracts/{$interface}.php") => 'repository-interface.stub',
        ];

        foreach ($paths as $path => $stubFile) {
            if (File::exists($path)) continue;

            File::ensureDirectoryExists(dirname($path));

            $stub = File::get(__DIR__ . "/../Stubs/{$stubFile}");

            File::put(
                $path,
                str_replace(
                    ['{{ module }}', '{{ model }}'],
                    [$moduleClass, $modelClass],
                    $stub
                )
            );
        }
    }

    private static function ensureBaseRepository(): void
    {
        $module = 'Shared';
        $class = 'BaseRepository';
        $path = app_path("Modules/{$module}/Repositories/{$class}.php");

        if (File::exists($path)) return;

        File::ensureDirectoryExists(dirname($path));
        $stub = File::get(__DIR__ . '/../Stubs/base-repository.stub');

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
