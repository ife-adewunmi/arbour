<?php

namespace Arbour\Loaders;

use Illuminate\Support\Facades\File;

trait MigrationsLoaderTrait
{
    public function loadMigrationsFromBranches($branchPath): void
    {
        $this->loadMigrations($branchPath.'/Database/Migrations');
    }

    private function loadMigrations($directory): void
    {
        if (File::isDirectory($directory)) {
            $this->loadMigrationsFrom($directory);
        }
    }
}
