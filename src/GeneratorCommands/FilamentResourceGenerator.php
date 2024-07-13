<?php

namespace Arbour\GeneratorCommands;

use Illuminate\Support\Str;

class FilamentResourceGenerator extends AbstractGeneratorCommand
{
    protected $name = 'make:arbour-filament-resource';

    protected $description = 'Create a new Filament Resource files';

    protected $type = 'Filament Resource';

    protected string $stubName = 'filament.resource.stub';

    protected string $folderInsideBranch = 'UI/Filament/Resources';

    public function handle()
    {
        parent::handle();

        $this->makeFilamentPlugin();
        $this->makeFilamentResourcePage('Create');
        $this->makeFilamentResourcePage('Edit');
        $this->makeFilamentResourcePage('List');
    }

    protected function getVariables(): array
    {
        return [
            '{{ modelName }}' => $name = $this->argument('name'),
            '{{ modelNamespace }}' => $this->getBranchNamespace().'\\Models\\'.$name,
            '{{ label }}' => $name,
            '{{ pluralLabel }}' => Str::plural($name),
            '{{ resourceNamespace }}' => $this->qualifyClass($this->getNameInput()),
            '{{ filamentId }}' => Str::lower($name),
        ];
    }

    protected function getNameInput(): string
    {
        return parent::getNameInput().'Resource';
    }

    protected function makeFilamentResourcePage($page): void
    {
        $stubName = 'filament.resource.'.strtolower($page).'.stub';
        $stubPath = file_exists($path = base_path("stubs/arbour/$stubName")) ? $path : __DIR__."/stubs/$stubName";

        $name = $this->qualifyClass($this->getNameInput());
        $stub = $this->files->get($stubPath);
        $stubReplaced = $this->replaceVariables($stub)
            ->replaceNamespace($stub, $name)
            ->replaceClass($stub, $name);

        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        $pageFilepath = $this->laravel['path'].'/'.
            str_replace('\\', '/', $name).'/Pages/'.
            ucfirst($page).$this->argument('name').'.php';
        $this->makeDirectory($pageFilepath);

        $this->files->put($pageFilepath, $this->sortImports($stubReplaced));
    }

    protected function makeFilamentPlugin(): void
    {
        $stubName = 'filament.plugin.stub';
        $stubPath = file_exists($path = base_path("stubs/arbour/$stubName")) ? $path : __DIR__."/stubs/$stubName";

        $name = Str::replaceFirst('\\Resources', '', $this->qualifyClass($this->argument('name').'FilamentPlugin'));
        $stub = $this->files->get($stubPath);
        $stubReplaced = $this->replaceVariables($stub)
            ->replaceNamespace($stub, $name)
            ->replaceClass($stub, $name);

        $name = Str::replaceFirst($this->rootNamespace(), '', $name);
        $pageFilepath = $this->laravel['path'].'/'.str_replace('\\', '/', $name).'.php';
        $this->makeDirectory($pageFilepath);

        $this->files->put($pageFilepath, $this->sortImports($stubReplaced));

        $this->importFilamentPluginToConfigFile();
    }

    protected function importFilamentPluginToConfigFile(): void
    {
        $name = $this->argument('name');
        $path = config_path('arbour');

        $configPath = file_get_contents($path);
        if (! $configPath) {
            return;
        }

        $arbourPlugins = trim(
            Str::before(Str::after($configPath, "'plugins' => ["), '],')
        );

        $plugin = "\\{$this->getBranchNamespace()}\\UI\\Filament\\{$name}FilamentPlugin::class";

        if (! Str::contains($arbourPlugins, $plugin)) {
            $trailingComma = ! str_ends_with($arbourPlugins, ',') ? ',' : '';

            $configPath = str_replace(
                $arbourPlugins,
                $arbourPlugins.$trailingComma.PHP_EOL.' '.$plugin.',',
                $configPath,
            );

            file_put_contents($path, $configPath);
        }
    }
}
