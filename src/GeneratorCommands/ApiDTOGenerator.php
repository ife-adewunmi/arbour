<?php

namespace Arbour\GeneratorCommands;

class ApiDTOGenerator extends AbstractGeneratorCommand
{
    protected $name = 'make:arbour-api-dto';

    protected $description = 'Create a new DTO class';

    protected $type = 'DTO';

    protected string $stubName = 'api.dto.stub';

    protected string $folderInsideBranch = 'UI/API/DTO';

    protected function getNameInput(): string
    {
        return parent::getNameInput().'DTO';
    }
}
