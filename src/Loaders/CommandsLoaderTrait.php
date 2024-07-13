<?php

namespace Arbour\Loaders;

use Illuminate\Support\Facades\File;

trait CommandsLoaderTrait
{
    use PathsLoaderTrait;

    public function loadCommandsFromBranches($branchPath): void
    {
        $stemCommandsDirectory = $branchPath.'/Commands';
        $branchCommandsDirectory = $branchPath.'/UI/CLI/Commands';
        $this->loadTheConsoles($stemCommandsDirectory);
        $this->loadTheConsoles($branchCommandsDirectory);
    }

    private function loadTheConsoles($directory): void
    {
        if (File::isDirectory($directory)) {
            $files = File::allFiles($directory);

            foreach ($files as $consoleFile) {
                // Do not load route files
                if (! $this->isRouteFile($consoleFile)) {
                    $consoleClass = $this->getClassFullNameFromFile($consoleFile->getPathname());
                    // When user from the Main Service Provider, which extends Laravel
                    // service provider you get access to `$this->commands`
                    $this->commands([$consoleClass]);
                }
            }
        }
    }

    private function isRouteFile($consoleFile): bool
    {
        return $consoleFile->getFilename() === 'closures.php';
    }
}
