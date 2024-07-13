<?php

namespace Arbour\GeneratorCommands;

use Illuminate\Support\Str;

class ApiRoutesGenerator extends AbstractGeneratorCommand
{
    protected $name = 'make:arbour-api-routes';

    protected $description = 'Create a new Route file';

    protected $type = 'Route';

    protected string $stubName = 'api.routes.stub';

    protected string $folderInsideBranch = 'UI/API/Routes';

    protected function getVariables(): array
    {
        $name = $this->argument('name');
        $controllerNamespace = $this->getBranchNamespace()."\\UI\\API\\Controllers\\{$name}Controller";

        return [
            '{{ controllerNamespace }}' => $controllerNamespace,
            '{{ controllerName }}' => "{$name}Controller",
            '{{ route }}' => Str::snake(Str::plural($name), '-'),
        ];
    }

    public function getNameInput(): string
    {
        return 'api';
    }
}
