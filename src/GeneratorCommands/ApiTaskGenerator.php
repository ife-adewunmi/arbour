<?php

namespace Arbour\GeneratorCommands;

use Symfony\Component\Console\Input\InputArgument;

class ApiTaskGenerator extends AbstractGeneratorCommand
{
    protected $name = 'make:arb:api-task';

    protected $description = 'Create a new Task class';

    protected $type = 'Task';

    protected string $stubName = 'api.action.stub';

    protected string $folderInsideBranch = 'Actions/API';

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
