<?php

namespace Arbour\GeneratorCommands;

use Symfony\Component\Console\Input\InputArgument;

class EnumGenerator extends AbstractGeneratorCommand
{
    protected $name = 'make:arb:enum';

    protected $description = 'Create a new Enum class';

    protected $type = 'Enum';

    protected string $stubName = 'enum.stub';

    protected string $folderInsideBranch = 'Enums';

    protected function getNameInput(): string
    {
        return parent::getNameInput().$this->type;
    }

    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the '.strtolower($this->type)],
            ['branch', InputArgument::REQUIRED, 'The branch name'],
            ['folder', InputArgument::OPTIONAL, 'The folder name', 'Branches'],
        ];
    }
}
