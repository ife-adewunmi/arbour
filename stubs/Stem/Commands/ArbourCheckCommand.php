<?php

namespace App\Stem\Commands;

use App\Stem\Abstracts\Commands\AbstractConsoleCommand;

class ArbourCheckCommand extends AbstractConsoleCommand
{
    protected $signature = 'arbour:check';

    protected $description = 'Arbour check example command';

    public function handle()
    {
        $this->info("Arbour package correctly installed.\n");
    }
}
