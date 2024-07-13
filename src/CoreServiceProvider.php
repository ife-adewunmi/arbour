<?php

namespace Arbour;

use Arbour\Commands\ArbourInstallCommand;
use Arbour\GeneratorCommands\ApiActionGenerator;
use Arbour\GeneratorCommands\ApiControllerGenerator;
use Arbour\GeneratorCommands\ApiDTOGenerator;
use Arbour\GeneratorCommands\ApiRequestGenerator;
use Arbour\GeneratorCommands\ApiResourceGenerator;
use Arbour\GeneratorCommands\ApiRoutesGenerator;
use Arbour\GeneratorCommands\BranchGenerator;
use Arbour\GeneratorCommands\FactoryGenerator;
use Arbour\GeneratorCommands\Filament2ResourceGenerator;
use Arbour\GeneratorCommands\FilamentResourceGenerator;
use Arbour\GeneratorCommands\MigrationGenerator;
use Arbour\GeneratorCommands\ModelGenerator;
use Arbour\GeneratorCommands\ProviderGenerator;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class CoreServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('arbour')
            ->hasCommands([
                ArbourInstallCommand::class,
                ProviderGenerator::class,
                MigrationGenerator::class,
                ModelGenerator::class,
                FactoryGenerator::class,
                ApiControllerGenerator::class,
                ApiRoutesGenerator::class,
                ApiResourceGenerator::class,
                ApiRequestGenerator::class,
                FilamentResourceGenerator::class,
                Filament2ResourceGenerator::class,
                BranchGenerator::class,
                ApiActionGenerator::class,
                ApiDTOGenerator::class,
            ])
            ->hasConfigFile();
    }

    public function bootingPackage(): void
    {
        //
    }

    public function registeringPackage(): void
    {
        //
    }
}
