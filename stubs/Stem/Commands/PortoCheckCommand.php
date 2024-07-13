<?php

namespace App\Stem\Commands;

use App\Stem\Abstracts\Commands\AbstractConsoleCommand;

class PortoCheckCommand extends AbstractConsoleCommand
{
    protected $signature = 'porto:check';

    protected $description = 'Porto check example command';

    public function handle()
    {
        $this->info("Porto package correctly installed.\n");
    }
}
