<?php

namespace Modular\ModuleGenerator\Generators;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Artisan;
use Modular\ModuleGenerator\Support\Naming;

class ModelGenerator
{
    public static function make(string $module, string $model): void
    {
        $moduleClass = Naming::class($module);
        $modelClass  = Naming::class($model);

        $modelPath = app_path("Modules/{$moduleClass}/Models/{$modelClass}.php");

        if (File::exists($modelPath)) {
            return;
        }

        File::ensureDirectoryExists(dirname($modelPath));

        $stub = File::get(__DIR__ . '/../Stubs/model.stub');

        File::put(
            $modelPath,
            str_replace(
                ['{{ module }}', '{{ model }}'],
                [$moduleClass, $modelClass],
                $stub
            )
        );

        self::createMigration($moduleClass, $modelClass);
    }

    private static function createMigration(string $module, string $model): void
    {
        $table = Naming::snakePlural(Naming::plural($model));
        $migrationName = "create_{$table}_table";

        $existing = glob(database_path("migrations/*{$migrationName}*.php"));
        if (!empty($existing)) {
            return;
        }

        Artisan::call('make:migration', [
            'name' => $migrationName,
        ]);
    }
}
