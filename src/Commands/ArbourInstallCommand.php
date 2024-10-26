<?php

declare(strict_types=1);

namespace Arbour\Commands;

use Arbour\Actions\AppendRowToFileArrayAction;
use Arbour\DTO\AppendRowToFileDTO;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class ArbourInstallCommand extends Command
{
    protected $signature = 'arb:init';

    protected $description = 'Install Arbour Package';

    public function __construct(
        private readonly Filesystem $file,
    ) {
        parent::__construct();
    }

    public function handle()
    {
        $this->copyStemFolder();

        $this->importStemProvider();
    }

    private function copyStemFolder(): void
    {
        $this->info("Copying Stem folder...\n");

        $stubPath = __DIR__ . '/../../stubs/Stem';
        $stemPath = app_path('Stem');

        if (! $this->file->isDirectory($stubPath)) {
            $this->error("The source directory {$stubPath} does not exist.");

            return;
        }

        $files = $this->file->allFiles(directory: $stubPath, hidden: true);
        foreach ($files as $file) {
            isset($n) ? $n++ : $n = 1;

            $destinationFilePath = $stemPath.'/'.$file->getRelativePathname();
            if ($this->file->exists($destinationFilePath)) {
                $this->warn("$n. File: Stem/{$file->getRelativePathname()} - exists.");

                continue;
            }

            $destinationFolderPath = dirname($destinationFilePath);
            if (! $this->file->exists($destinationFolderPath)) {
                $this->file->makeDirectory(path: dirname($destinationFilePath), recursive: true);
            }

            if (! $this->file->copy($file->getPathname(), $destinationFilePath)) {
                $this->warn("$n. File: Stem/{$file->getFilename()} - failed to copy.");
            }

            $this->info("$n. File: Stem/{$file->getRelativePathname()} - has been copied successfully.");
        }

        $this->info("\nThe Stem folder has been copied successfully.\n");
    }

    private function importStemProvider(): void
    {
        $this->info("Importing StemProvider...\n");

        // laravel 11
        $importFilePath = base_path('bootstrap/providers.php');
        $appendRowDTO = new AppendRowToFileDTO(
            appendRow: 'App\\Stem\\Providers\\StemProvider::class,',
            destinationFilePath: $importFilePath,
        );

        // support laravel 10
        if (! $this->file->exists(base_path('bootstrap/providers.php'))) {
            $importFilePath = config_path('app.php');
            $appendRowDTO = new AppendRowToFileDTO(
                appendRow: 'App\Stem\Providers\StemProvider::class',
                destinationFilePath: $importFilePath,
                beforeAppendRow: "'providers' => ServiceProvider::defaultProviders()->merge([",
                AfterAppendRow: '])->toArray(),'
            );
        }

        $result = app(AppendRowToFileArrayAction::class)->run($appendRowDTO);

        if ($result === true) {
            $this->info("The StemProvider has already imported.\n");

            return;
        }

        if ($result === false) {
            $this->error("Failed to import the StemProvider.\n");

            return;
        }

        $this->info("The StemProvider has been imported successfully.\n");
    }
}
