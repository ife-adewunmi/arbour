<?php

namespace Arbour\GeneratorCommands;

use Illuminate\Support\Str;

class MigrationGenerator extends AbstractGeneratorCommand
{
    protected $name = 'make:arbour-migration';

    protected $description = 'Create a new Migration file';

    protected $type = 'Migration';

    protected string $stubName = 'migration.create.stub';

    protected string $folderInsideBranch = 'Database/Migrations';

    public function handle()
    {
        if ($this->checkMigrationFileExists()) {
            return null;
        }

        parent::handle();
    }

    protected function checkMigrationFileExists(): bool
    {
        $migrationFolder = $this->getBranchPath().'/Database/Migrations';
        if (! $this->files->exists($migrationFolder)) {
            return false;
        }

        foreach ($this->files->allFiles($migrationFolder) as $filename) {
            $migrationName = 'create_'.$this->getTableName().'_table';
            if (Str::contains($filename, $migrationName)) {
                $this->components->error("$this->type already exists.");

                return true;
            }
        }

        return false;
    }

    protected function getVariables(): array
    {
        return [
            '{{ table_name }}' => $this->getTableName(),
        ];
    }

    protected function getNameInput(): string
    {
        return now()->format('Y_m_d_His').'_create_'.$this->getTableName().'_table';
    }

    protected function getTableName(): string
    {
        return Str::snake(Str::plural($this->argument('name')));
    }
}
