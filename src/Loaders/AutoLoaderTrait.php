<?php

namespace Arbour\Loaders;

trait AutoLoaderTrait
{
    use AliasesLoaderTrait;
    use CommandsLoaderTrait;
    use ConfigsLoaderTrait;
    use HelpersLoaderTrait;
    use LocalizationLoaderTrait;
    use MigrationsLoaderTrait;
    use ProvidersLoaderTrait;
    use RoutesLoaderTrait;
    use ViewsLoaderTrait;

    protected ?string $branchPath = null;

    public function getBranchPath(): string
    {
        if (is_null($this->branchPath)) {
            return $this->branchPath = realpath(dirname((new \ReflectionClass($this))->getFileName()).'/..');
        }

        return $this->branchPath;
    }

    public function registerBranch(): void
    {
        $this->loadServiceProviders();
        $this->loadConfigsFromBranches($this->getBranchPath());
        $this->loadLocalsFromBranches($this->getBranchPath());
    }

    public function bootBranch(): void
    {
        $this->runRoutesAutoLoader($this->getBranchPath());
        $this->loadMigrationsFromBranches($this->getBranchPath());
        $this->loadViewsFromBranches($this->getBranchPath());
        $this->loadHelpersFromBranches($this->getBranchPath());
        $this->loadCommandsFromBranches($this->getBranchPath());
    }
}
