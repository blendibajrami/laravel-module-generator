<?php

namespace Modular\ModuleGenerator\Commands;

use Illuminate\Console\Command;
use Modular\ModuleGenerator\Generators\{
    ModelGenerator,
    ControllerGenerator,
    RequestGenerator,
    ResourceGenerator,
    PolicyGenerator,
    RepositoryGenerator,
    ServiceGenerator,
    ProviderGenerator
};

class MakeModuleModelCommand extends Command
{
    protected $signature = 'make:module-model {module} {model}';
    protected $description = 'Generate full module structure';

    public function handle(): void
    {
        $module = $this->argument('module');
        $model  = $this->argument('model');

        // Gjenero gjithçka
        ModelGenerator::make($module, $model);
        ControllerGenerator::make($module, $model);
        RequestGenerator::make($module, $model);
        ResourceGenerator::make($module, $model);
        PolicyGenerator::make($module, $model);
        RepositoryGenerator::make($module, $model);
        ServiceGenerator::make($module, $model);
        ProviderGenerator::make($module, $model);

      
        $this->info("Module '{$module}' with model '{$model}' has been successfully generated!");
       
    }
}
