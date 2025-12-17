<?php

namespace Modular\ModuleGenerator\Generators;

use Illuminate\Support\Facades\File;
use Modular\ModuleGenerator\Support\Naming;

class ControllerGenerator
{
    public static function make(string $module, string $model): void
    {
        $moduleClass = Naming::class($module);
        $modelClass  = Naming::class($model);

        $controller = "{$modelClass}Controller";
        $path = app_path("Modules/{$moduleClass}/Http/Controllers/{$controller}.php");

        if (File::exists($path)) {
            return;
        }

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
                    $moduleClass,
                    $modelClass,
                    Naming::camel($model),
                    Naming::plural($model),
                    Naming::pluralCamel($model)
                ],
                $stub
            )
        );

        self::ensureRoutes($moduleClass);
    }

    private static function ensureRoutes(string $module): void
    {
        $routesDir = app_path("Modules/{$module}/routes");
        $webRoute  = "{$routesDir}/web.php";

      
        File::ensureDirectoryExists($routesDir);

        if (!File::exists($webRoute)) {
            File::put($webRoute, "<?php\n");
        }
    }
}
