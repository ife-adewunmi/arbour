<?php

namespace Arbour\GeneratorCommands;

class FactoryGenerator extends AbstractGeneratorCommand
{
    protected $name = 'make:arbour-factory';

    protected $description = 'Create a new Factory class';

    protected $type = 'Factory';

    protected string $stubName = 'factory.stub';

    protected string $folderInsideBranch = 'Database/Factories';

    protected function getVariables(): array
    {
        $modelName = $this->argument('name');
        $modelNamespace = $this->getBranchNamespace().'\\Models\\'.$this->argument('name');

        return [
            '{{ modelName }}' => $modelName,
            '{{ modelNamespace }}' => $modelNamespace,
        ];
    }

    protected function getNameInput(): string
    {
        return parent::getNameInput().'Factory';
    }
}
