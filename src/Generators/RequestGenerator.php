<?php

namespace Modular\ModuleGenerator\Generators;

use Illuminate\Support\Facades\File;

class RequestGenerator
{
    public static function make(string $module, string $model): void
    {
        $requests = [
            "Store{$model}Request" => 'store-request.stub',
            "Update{$model}Request" => 'update-request.stub',
        ];

        foreach ($requests as $class => $stubFile) {
            $path = app_path("Modules/{$module}/Http/Requests/{$class}.php");

            if (File::exists($path)) continue;

            File::ensureDirectoryExists(dirname($path));

            $stub = File::get(__DIR__ . "/../Stubs/{$stubFile}");

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
}
