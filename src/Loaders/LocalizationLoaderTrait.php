<?php

namespace Arbour\Loaders;

use Illuminate\Support\Facades\File;

trait LocalizationLoaderTrait
{
    public function loadLocalsFromBranches($branchPath): void
    {
        $branchLocaleDirectory = $branchPath.'/Languages';
        $branchName = basename($branchPath);

        $this->loadLocals($branchLocaleDirectory, $branchName);
    }

    private function loadLocals($directory, $containerName): void
    {
        if (File::isDirectory($directory)) {
            $this->loadTranslationsFrom($directory, "branch@$containerName");
            $this->loadJsonTranslationsFrom($directory);
        }
    }
}
