<?php

namespace Arbour\GeneratorCommands;

use Symfony\Component\Console\Input\InputArgument;

class ApiActionGenerator extends AbstractGeneratorCommand
{
    protected $name = 'make:arbour-api-action';

    protected $description = 'Create a new Action class';

    protected $type = 'Action';

    protected string $stubName = 'api.action.stub';

    protected string $folderInsideBranch = 'UI/API/Actions';

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
            ['run-function', InputArgument::OPTIONAL, 'The run() function', "public function run()\n    {\n        //\n    }"],
            ['construct-function', InputArgument::OPTIONAL, 'The __construct() function', "public function __construct()\n    {\n        //\n    }"],
            ['use-namespaces', InputArgument::OPTIONAL, 'The use namespaces', ''],
        ];
    }

    protected function getVariables(): array
    {
        return [
            '{{ runFunction }}' => $this->argument('run-function'),
            '{{ constructFunction }}' => $this->argument('construct-function'),
            '{{ useNamespaces }}' => $this->argument('use-namespaces'),
        ];
    }
}
