<?php

namespace Arbour\Loaders;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

/**
 * This class is different from other loaders as it is not called by AutoLoaderTrait
 * It is called "database/seeders/DatabaseSeeder.php", Laravel main seeder and only load seeder from
 * Branches (not from "app/Ship/seeders").
 */
trait SeederLoaderTrait
{
    use PathsLoaderTrait;

    public function runLoadingSeeders(): void
    {
        $this->loadSeedersFromBranches();
    }

    private function loadSeedersFromBranches(): void
    {
        $seedersClasses = new Collection();

        $BranchesDirectories = [];

        foreach ($this->getSectionNames() as $sectionName) {
            foreach ($this->getSectionBranchNames($sectionName) as $containerName) {
                $BranchesDirectories[] = $this->arbourPath.'/Branches/'.$sectionName.'/'.$containerName.'/Data/Seeders'; // TODO remove this line in v2
                $BranchesDirectories[] = $this->arbourPath.'/Branches/'.$sectionName.'/'.$containerName.'/Database/Seeders';
            }
        }

        $seedersClasses = $this->findSeedersClasses($BranchesDirectories, $seedersClasses);
        $orderedSeederClasses = $this->sortSeeders($seedersClasses);

        $this->loadSeeders($orderedSeederClasses);
    }

    private function findSeedersClasses(array $directories, $seedersClasses)
    {
        foreach ($directories as $directory) {
            if (File::isDirectory($directory)) {
                $files = File::allFiles($directory);

                foreach ($files as $seederClass) {
                    if (File::isFile($seederClass)) {
                        // do not seed the classes now, just store them in a collection and w
                        $seedersClasses->push(
                            $this->getClassFullNameFromFile(
                                $seederClass->getPathname()
                            )
                        );
                    }
                }
            }
        }

        return $seedersClasses;
    }

    private function sortSeeders($seedersClasses): Collection
    {
        $orderedSeederClasses = new Collection();

        if ($seedersClasses->isEmpty()) {
            return $orderedSeederClasses;
        }

        foreach ($seedersClasses as $key => $seederFullClassName) {
            // if the class full namespace contain "_" it means it needs to be seeded in order
            if (str_contains($seederFullClassName, '_')) {
                // move all the seeder classes that needs to be seeded in order to their own Collection
                $orderedSeederClasses->push($seederFullClassName);
                // delete the moved classes from the original collection
                $seedersClasses->forget($key);
            }
        }

        // sort the classes that needed to be ordered
        $orderedSeederClasses = $orderedSeederClasses->sortBy(function ($seederFullClassName) {
            // get the order number form the end of each class name
            return substr($seederFullClassName, strpos($seederFullClassName, '_') + 1);
        });

        // append the randomly ordered seeder classes to the end of the ordered seeder classes
        foreach ($seedersClasses as $seederClass) {
            $orderedSeederClasses->push($seederClass);
        }

        return $orderedSeederClasses;
    }

    private function loadSeeders($seedersClasses): void
    {
        foreach ($seedersClasses as $seeder) {
            // seed it with call
            $this->call($seeder);
        }
    }
}
