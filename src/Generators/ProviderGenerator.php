<?php

namespace Modular\ModuleGenerator\Generators;

use Illuminate\Support\Facades\File;

class ProviderGenerator
{
    public static function make(string $module, string $model): void
    {
        self::appProvider($module, $model);
        self::policyProvider($module, $model);
    }

    private static function appProvider(string $module, string $model): void
    {
        $path = app_path("Modules/{$module}/Providers/AppServiceProvider.php");

        if (!File::exists($path)) {
            File::ensureDirectoryExists(dirname($path));
            File::put($path, File::get(__DIR__ . '/../Stubs/app-service-provider.stub'));
        }

        $binding = "\$this->app->bind({$model}RepositoryInterface::class, {$model}Repository::class);";

        $content = File::get($path);

        if (!str_contains($content, $binding)) {
            $content = preg_replace(
                '/register\(\): void\s*\{/',
                "register(): void\n    {\n        {$binding}",
                $content
            );

            File::put($path, $content);
        }
    }

    private static function policyProvider(string $module, string $model): void
    {
        $path = app_path("Modules/{$module}/Providers/PolicyServiceProvider.php");

        if (!File::exists($path)) {
            File::ensureDirectoryExists(dirname($path));
            File::put($path, File::get(__DIR__ . '/../Stubs/policy-service-provider.stub'));
        }

        $binding = "{$model}::class => {$model}Policy::class,";

        $content = File::get($path);

        if (!str_contains($content, $binding)) {
            $content = preg_replace(
                '/protected \$policies = \[\s*/',
                "protected \$policies = [\n        {$binding}",
                $content
            );

            File::put($path, $content);
        }
    }
}
