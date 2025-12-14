<?php

namespace Modular\ModuleGenerator\Providers;

use Illuminate\Support\ServiceProvider;
use Modular\ModuleGenerator\Commands\MakeModuleModelCommand;

class ModuleGeneratorServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->commands([
            MakeModuleModelCommand::class,
        ]);
    }
}
