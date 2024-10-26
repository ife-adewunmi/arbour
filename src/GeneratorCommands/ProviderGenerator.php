<?php

namespace Arbour\GeneratorCommands;

class ProviderGenerator extends AbstractGeneratorCommand
{
    protected $name = 'make:arb:provider';

    protected $description = 'Create a new ServiceProvider class';

    protected $type = 'ServiceProvider';

    protected string $stubName = 'provider.stub';

    protected string $folderInsideBranch = 'Providers';

    protected function getNameInput(): string
    {
        return parent::getNameInput().'ServiceProvider';
    }

    public function handle()
    {
        parent::handle();

        $this->makeFileInBranch('Providers/MainServiceProvider.php', 'main.service.provider.stub');

        $this->importCustomProviderToStemProvider();
    }
}
