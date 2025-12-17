<?php

namespace Modular\ModuleGenerator\Generators;

use Illuminate\Support\Facades\File;
use Modular\ModuleGenerator\Support\Naming;

class ProviderGenerator
{
    public static function make(string $module, string $model): void
    {
        $moduleClass = Naming::class($module);
        $modelClass = Naming::class($model);

        self::appProvider($moduleClass, $modelClass);
        self::policyProvider($moduleClass, $modelClass);
    }

   private static function appProvider(string $module, string $model): void
{
    $path = app_path("Modules/{$module}/Providers/AppServiceProvider.php");

    if (!File::exists($path)) {
        File::ensureDirectoryExists(dirname($path));

        $stub = File::get(__DIR__ . '/../Stubs/app-service-provider.stub');

        File::put(
            $path,
            str_replace(['{{ module }}'], [$module], $stub)
        );
    }

    $useRepository = "use App\\Modules\\{$module}\\Repositories\\{$model}Repository;";
    $useInterface  = "use App\\Modules\\{$module}\\Repositories\\Contracts\\{$model}RepositoryInterface;";

    $binding = "\$this->app->bind({$model}RepositoryInterface::class, {$model}Repository::class);";

    $content = File::get($path);

   
    foreach ([$useRepository, $useInterface] as $use) {
        if (!str_contains($content, $use)) {
            $content = preg_replace(
                '/namespace .*?;\n/s',
                "$0\n{$use}\n",
                $content,
                1
            );
        }
    }

   
    if (!str_contains($content, $binding)) {
        $content = preg_replace(
            '/register\(\): void\s*\{/s',
            "register(): void\n    {\n        {$binding}",
            $content
        );
    }

    File::put($path, $content);
}



private static function policyProvider(string $module, string $model): void
{
    $path = app_path("Modules/{$module}/Providers/PolicyServiceProvider.php");

    if (!File::exists($path)) {
        File::ensureDirectoryExists(dirname($path));

        $stub = File::get(__DIR__ . '/../Stubs/policy-service-provider.stub');

        File::put(
            $path,
            str_replace('{{ module }}', $module, $stub)
        );
    }

    $useModel  = "use App\\Modules\\{$module}\\Models\\{$model};";
    $usePolicy = "use App\\Modules\\{$module}\\Policies\\{$model}Policy;";

    $binding = "{$model}::class => {$model}Policy::class,";

    $content = File::get($path);

    
    $usesToAdd = [$useModel, $usePolicy];

    foreach ($usesToAdd as $use) {
        if (!str_contains($content, $use)) {

           
            if (preg_match_all('/^use .*;$/m', $content, $matches) && count($matches[0]) > 0) {
                $lastUse = end($matches[0]);

                $content = str_replace(
                    $lastUse,
                    $lastUse . "\n" . $use,
                    $content
                );
            }
            
            else {
                $content = preg_replace(
                    '/namespace .*?;\s*/',
                    "$0\n{$use}\n",
                    $content,
                    1
                );
            }
        }
    }

   
    if (!str_contains($content, $binding)) {
        $content = preg_replace(
            '/protected \$policies\s*=\s*\[\s*/',
            "protected \$policies = [\n        {$binding}\n",
            $content
        );
    }

    File::put($path, $content);
}

}