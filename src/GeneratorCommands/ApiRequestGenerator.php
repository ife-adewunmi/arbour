<?php

namespace Arbour\GeneratorCommands;

class ApiRequestGenerator extends AbstractGeneratorCommand
{
    protected $name = 'make:arbour-api-request';

    protected $description = 'Create a new Request class';

    protected $type = 'RequestDTO';

    protected string $stubName = 'api.request.stub';

    protected string $folderInsidebranch = 'UI/API/RequestDTO';

    protected function getNameInput()
    {
        return parent::getNameInput().'RequestDTO';
    }
}
