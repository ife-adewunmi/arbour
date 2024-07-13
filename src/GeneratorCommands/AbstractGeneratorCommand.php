<?php

namespace Arbour\GeneratorCommands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use function Laravel\Prompts\text;

abstract class AbstractGeneratorCommand extends GeneratorCommand
{
    protected string $stubName;

    protected string $folderInsideBranch;

    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the '.strtolower($this->type)],
            ['branch', InputArgument::REQUIRED, 'The branch name'],
            ['folder', InputArgument::OPTIONAL, 'The folder name', 'Branches'],
        ];
    }

    protected function getStub(): string
    {
        return file_exists($path = base_path('stubs/arbour/'.$this->stubName))
            ? $path
            : __DIR__.'/stubs/'.$this->stubName;
    }

    protected function getBranchNamespace(): array|string
    {
        return str_replace(
            '/',
            '\\',
            $this->rootNamespace().$this->argument('folder').'/'.$this->argument('branch')
        );
    }

    protected function getDefaultNamespace($rootNamespace): string
    {
        return $this->getBranchNamespace().'\\'.str_replace('/', '\\', $this->folderInsideBranch);
    }

    protected function getVariables(): array
    {
        return [
            // '{{ search }}' => 'replace',
        ];
    }

    protected function replaceVariables(&$stub): static
    {
        foreach ($this->getVariables() as $key => $value) {
            $stub = str_replace($key, $value, $stub);
        }

        return $this;
    }

    protected function buildClass($name): string
    {
        $stub = $this->files->get($this->getStub());

        return $this->replaceVariables($stub)
            ->replaceNamespace($stub, $name)
            ->replaceClass($stub, $name);
    }

    protected function makeFileInBranch($filePath, $stubName): void
    {
        $stubPath = file_exists($path = base_path('stubs/arbour/'.$stubName))
            ? $path
            : __DIR__.'/stubs/'.$stubName;

        $name = $this->qualifyClass($this->getNameInput());
        $stub = $this->files->get($stubPath);
        $stub = $this->replaceVariables($stub)->replaceNamespace($stub, $name)->replaceClass($stub, $name);

        $fullPath = $this->getBranchPath().DIRECTORY_SEPARATOR.$filePath;
        $this->makeDirectory($fullPath);

        if (! $this->files->exists($fullPath)) {
            $this->files->put($fullPath, $this->sortImports($stub));
            $this->components->info(sprintf('File [%s] created successfully.', $filePath));
        } else {
            $this->components->error("[$filePath] already exists.");
        }
    }

    protected function getBranchPath(string $path = ''): string
    {
        $branchName = Str::ucfirst(Str::camel($this->argument('branch')));
        $branchPath = app_path($this->argument('folder').DIRECTORY_SEPARATOR.$branchName);

        if ($path) {
            $branchPath .= DIRECTORY_SEPARATOR.$path;
        }

        return $branchPath;
    }

    protected function importMainProviderToStemProvider(): void
    {
        $branch = $this->argument('branch');
        $stemProvider = file_get_contents(app_path('Stem/Providers/StemProvider.php'));

        $imports = trim(
            Str::before(Str::after($stemProvider, 'namespace App\Stem\Providers;'), 'class')
        );
        $import = "use {$this->getBranchNamespace()}\Providers\MainServiceProvider as {$branch}ServiceProvider;";

        if (! Str::contains($imports, $import)) {
            $stemProvider = str_replace(
                $imports,
                $imports.PHP_EOL.$import,
                $stemProvider,
            );
            file_put_contents(app_path('Stem/Providers/StemProvider.php'), $stemProvider);
        }

        $serviceProviders = trim(
            Str::before(Str::after($stemProvider, '$serviceProviders = ['), '];')
        );
        $serviceProvider = "{$branch}ServiceProvider::class";

        if (! Str::contains($serviceProviders, $serviceProvider)) {
            $trailingComma = ! str_ends_with($serviceProviders, ',') ? ',' : '';

            $stemProvider = str_replace(
                $serviceProviders,
                $serviceProviders.$trailingComma.PHP_EOL.'        '.$serviceProvider,
                $stemProvider,
            );
            file_put_contents(app_path('Stem/Providers/StemProvider.php'), $stemProvider);
        }
    }

    protected function importCustomProviderToStemProvider(): void
    {
        $name = $this->getNameInput();
        $path = $this->getBranchPath().'/Providers/MainServiceProvider.php';
        $mainProvider = file_get_contents($path);

        $serviceProviders = trim(
            Str::before(Str::after($mainProvider, '$serviceProviders = ['), '];')
        );
        $serviceProvider = "{$name}::class";

        if (! Str::contains($serviceProviders, $serviceProvider)) {
            $trailingComma = ! str_ends_with($serviceProviders, ',') ? ',' : '';

            $mainProvider = str_replace(
                $serviceProviders,
                $serviceProviders.$trailingComma.PHP_EOL.' '.$serviceProvider,
                $mainProvider,
            );
            file_put_contents($path, $mainProvider);
        }
    }

    protected function afterPromptingForMissingArguments(InputInterface $input, OutputInterface $output): void
    {
        $input->setArgument('folder', text(
            label: 'Would you like to specify a custom folder? (Optional)',
            default: $this->argument('folder'),
        ));
    }
}
