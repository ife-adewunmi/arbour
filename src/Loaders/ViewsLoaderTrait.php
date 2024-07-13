<?php

namespace Arbour\Loaders;

use Illuminate\Support\Facades\File;

trait ViewsLoaderTrait
{
    public function loadViewsFromBranches($branchPath): void
    {
        $branchViewDirectory = $branchPath.'/UI/WEB/Views/';
        $branchMailTemplatesDirectory = $branchPath.'/Mails/Templates/';

        $branchName = basename($branchPath);

        $this->loadViews($branchViewDirectory, $branchName);
        $this->loadViews($branchMailTemplatesDirectory, $branchName);
    }

    private function loadViews($directory, $branchName): void
    {
        if (File::isDirectory($directory)) {
            $this->loadViewsFrom($directory, "branch@$branchName");
        }
    }
}
