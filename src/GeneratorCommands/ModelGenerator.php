<?php

namespace Arbour\GeneratorCommands;

class ModelGenerator extends AbstractGeneratorCommand
{
    protected $name = 'make:arbour-model';

    protected $description = 'Create a new Model class';

    protected $type = 'Model';

    protected string $stubName = 'model.stub';

    protected string $folderInsideBranch = 'Models';

    protected function getVariables(): array
    {
        $factoryNamespace = $this->getBranchNamespace().'\\Database\\Factories\\'.
            $this->argument('name').'Factory';

        return [
            '{{ factoryNamespace }}' => $factoryNamespace,
        ];
    }
}
