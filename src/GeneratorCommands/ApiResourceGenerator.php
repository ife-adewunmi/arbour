<?php

namespace Arbour\GeneratorCommands;

class ApiResourceGenerator extends AbstractGeneratorCommand
{
    protected $name = 'make:arb:api-resource';

    protected $description = 'Create a new API Resource class';

    protected $type = 'Resource';

    protected string $stubName = 'api.resource.stub';

    protected string $folderInsideBranch = 'UI/API/Resources';

    protected function getNameInput(): string
    {
        return parent::getNameInput().'Resource';
    }
}
