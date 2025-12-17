<?php

namespace Modular\ModuleGenerator\Generators;

use Illuminate\Support\Facades\File;
use Modular\ModuleGenerator\Support\Naming;

class RequestGenerator
{
    public static function make(string $module, string $model): void
    {
        $moduleClass = Naming::class($module);
        $modelClass = Naming::class($model);

        $requests = [
            "Store{$modelClass}Request" => 'store-request.stub',
            "Update{$modelClass}Request" => 'update-request.stub',
        ];

        foreach ($requests as $class => $stubFile) {
            $path = app_path("Modules/{$moduleClass}/Http/Requests/{$class}.php");

            if (File::exists($path)) continue;

            File::ensureDirectoryExists(dirname($path));

            $stub = File::get(__DIR__ . "/../Stubs/{$stubFile}");

            File::put(
                $path,
                str_replace(
                    ['{{ module }}', '{{ class }}'],
                    [$moduleClass, $class],
                    $stub
                )
            );
        }
    }
}