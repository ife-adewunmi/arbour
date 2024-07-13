<?php

namespace Arbour\Loaders;

use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Support\Facades\File;

trait HelpersLoaderTrait
{
    public function loadHelpersFromBranches($branchPath): void
    {
        $branchHelpersDirectory = $branchPath.'/Helpers';
        $this->loadHelpers($branchHelpersDirectory);
    }

    private function loadHelpers($helpersFolder): void
    {
        if (File::isDirectory($helpersFolder)) {
            $files = File::files($helpersFolder);

            foreach ($files as $file) {
                try {
                    require $file;
                } catch (FileNotFoundException $e) {
                }
            }
        }
    }
}
