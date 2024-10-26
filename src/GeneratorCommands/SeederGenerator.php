<?php

namespace Arbour\GeneratorCommands;

class SeederGenerator extends AbstractGeneratorCommand
{
    protected $name = 'make:arb:seeder';

    protected $description = 'Create a new Seeder class';

    protected $type = 'Factory';

    protected string $stubName = 'seeder.stub';

    protected string $folderInsideBranch = 'Database/Seeders';

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
        return parent::getNameInput().'Seeder';
    }
}
