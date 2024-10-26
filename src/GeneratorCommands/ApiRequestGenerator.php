<?php

namespace Arbour\GeneratorCommands;

class ApiRequestGenerator extends AbstractGeneratorCommand
{
    protected $name = 'make:arb:api-request';

    protected $description = 'Create a new Request class';

    protected $type = 'DTO';

    protected string $stubName = 'api.request.stub';

    protected string $folderInsideBranch = 'UI/API/DTO/Requests';

    protected function getNameInput(): string
    {
        return parent::getNameInput().'DTO';
    }
}
