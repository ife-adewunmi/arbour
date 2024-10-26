<?php

namespace Arbour\GeneratorCommands;

use Symfony\Component\Console\Input\InputOption;

class ApiControllerGenerator extends AbstractGeneratorCommand
{
    protected $name = 'make:arb:api-controller';

    protected $description = 'Create a new API Controller class';

    protected $type = 'Controller';

    protected string $stubName = 'api.controller.stub';

    protected string $folderInsideBranch = 'UI/API/Controllers';

    public function handle()
    {
        parent::handle();

        $arguments = [
            'name' => $name = $this->argument('name'),
            'branch' => $this->argument('branch'),
            'folder' => $this->argument('folder'),
        ];

        if ($this->option('actions')) {
            $this->call('make:arb:api-dto', $arguments);

            $this->call('make:arb:api-request', array_merge($arguments, ['name' => "Create$name"]));
            $this->call('make:arb:api-request', array_merge($arguments, ['name' => "Update$name"]));

            $this->call('make:arb:api-action', $this->getListAction());
            $this->call('make:arb:api-action', $this->createAction());
            $this->call('make:arb:api-action', $this->getByIdAction());
            $this->call('make:arb:api-action', $this->updateByIdAction());
            $this->call('make:arb:api-action', $this->deleteByIdAction());

        }
    }

    protected function getVariables(): array
    {
        $name = $this->argument('name');
        $useNamespaces = '';
        $bodyOfIndexFunction = '//';
        $bodyOfStoreFunction = '//';
        $bodyOfShowFunction = '//';
        $bodyOfUpdateFunction = '//';
        $bodyOfDestroyFunction = '//';
        $phpDocOfIndexFunction = "/**\n     * Get $name list\n     */";
        $phpDocOfStoreFunction = "/**\n     * Create $name\n     */";
        $phpDocOfShowFunction = "/**\n     * Get $name by ID\n     */";
        $phpDocOfUpdateFunction = "/**\n     * Update $name by ID\n     */";
        $phpDocOfDestroyFunction = "/**\n     * Delete $name by ID\n     */";

        if ($this->option('actions')) {
            $useNamespaces = 'use '.$this->getBranchNamespace()."\\UI\\API\\Actions\\Create{$name}Action;\n";
            $useNamespaces .= 'use '.$this->getBranchNamespace()."\\UI\\API\\Actions\\Delete{$name}ByIdAction;\n";
            $useNamespaces .= 'use '.$this->getBranchNamespace()."\\UI\\API\\Actions\\Get{$name}ByIdAction;\n";
            $useNamespaces .= 'use '.$this->getBranchNamespace()."\\UI\\API\\Actions\\Get{$name}ListAction;\n";
            $useNamespaces .= 'use '.$this->getBranchNamespace()."\\UI\\API\\Actions\\Update{$name}ByIdAction;\n";
            $useNamespaces .= 'use '.$this->getBranchNamespace()."\\UI\\API\\DTO\\{$name}DTO;";

            $bodyOfIndexFunction = "return app(Get{$name}ListAction::class)->run();";
            $bodyOfStoreFunction = "return app(Create{$name}Action::class)->run(\$requestDTO)\n            ->only('id');";
            $bodyOfShowFunction = "return app(Get{$name}ByIdAction::class)->run(\$id);";
            $bodyOfUpdateFunction = "return app(Update{$name}ByIdAction::class)->run(\$requestDTO, \$id)\n            ->only('id');";
            $bodyOfDestroyFunction = "app(Delete{$name}ByIdAction::class)->run(\$id);\n\n        return response()->noContent();";

            $phpDocOfIndexFunction = "/**\n     * Get $name list\n     *\n     * @return {$name}DTO[]\n     */";
            $phpDocOfStoreFunction = "/**\n     * Create $name\n     *\n     * @return array{id: string}\n     */";
            $phpDocOfShowFunction = "/**\n     * Get $name by ID\n     *\n     * @return {$name}DTO\n     */";
            $phpDocOfUpdateFunction = "/**\n     * Update $name by ID\n     *\n     * @return array{id: string}\n     */";
            $phpDocOfDestroyFunction = "/**\n     * Delete $name by ID\n     */";
        }

        return [
            '{{ name }}' => $name,
            '{{ useNamespaces }}' => $useNamespaces,
            '{{ branchNamespace }}' => $this->getBranchNamespace(),

            '{{ bodyOfIndexFunction }}' => $bodyOfIndexFunction,
            '{{ bodyOfStoreFunction }}' => $bodyOfStoreFunction,
            '{{ bodyOfShowFunction }}' => $bodyOfShowFunction,
            '{{ bodyOfUpdateFunction }}' => $bodyOfUpdateFunction,
            '{{ bodyOfDestroyFunction }}' => $bodyOfDestroyFunction,

            '{{ phpDocOfIndexFunction }}' => $phpDocOfIndexFunction,
            '{{ phpDocOfStoreFunction }}' => $phpDocOfStoreFunction,
            '{{ phpDocOfShowFunction }}' => $phpDocOfShowFunction,
            '{{ phpDocOfUpdateFunction }}' => $phpDocOfUpdateFunction,
            '{{ phpDocOfDestroyFunction }}' => $phpDocOfDestroyFunction,
        ];
    }

    protected function getNameInput(): string
    {
        return parent::getNameInput().'Controller';
    }

    protected function getOptions(): array
    {
        return [
            ['actions', 'a', InputOption::VALUE_NONE, 'Create new action classes'],
        ];
    }

    private function getListAction(): array
    {
        $name = $this->argument('name');

        $useNamespaces = "use {$this->getBranchNamespace()}\\Models\\$name;\n";
        $useNamespaces .= "use {$this->getBranchNamespace()}\\UI\\API\\DTO\\{$name}DTO;\n";
        $useNamespaces .= 'use Spatie\\LaravelData\\DataCollection;';

        $arguments = '';
        $return = ': DataCollection';
        $body = "return {$name}DTO::collect($name::all(), DataCollection::class);";

        return [
            'name' => "Get{$name}List",
            'branch' => $this->argument('branch'),
            'folder' => $this->argument('folder'),
            'use-namespaces' => $useNamespaces,
            'run-function' => "public function run($arguments)$return\n    {\n        $body\n    }\n",
        ];
    }

    private function createAction(): array
    {
        $name = $this->argument('name');

        $useNamespaces = "use {$this->getBranchNamespace()}\\Models\\$name;\n";
        $useNamespaces .= "use {$this->getBranchNamespace()}\\UI\\API\\DTO\\{$name}DTO;\n";
        $useNamespaces .= "use {$this->getBranchNamespace()}\\UI\\API\\DTO\\Requests\\Create{$name}RequestDTO;";

        $arguments = "Create{$name}RequestDTO \$requestDTO";
        $return = ": {$name}DTO";
        $body = "return {$name}DTO::from($name::create(\$requestDTO->toArray()));";

        return [
            'name' => "Create{$name}",
            'branch' => $this->argument('branch'),
            'folder' => $this->argument('folder'),
            'use-namespaces' => $useNamespaces,
            'run-function' => "public function run($arguments)$return\n    {\n        $body\n    }\n",
        ];
    }

    private function getByIdAction(): array
    {
        $name = $this->argument('name');

        $useNamespaces = "use {$this->getBranchNamespace()}\\Models\\$name;\n";
        $useNamespaces .= "use {$this->getBranchNamespace()}\\UI\\API\\DTO\\{$name}DTO;\n";

        $arguments = 'string $id';
        $return = ": {$name}DTO";
        $body = "return {$name}DTO::from($name::findOrFail(\$id));";

        return [
            'name' => "Get{$name}ById",
            'branch' => $this->argument('branch'),
            'folder' => $this->argument('folder'),
            'use-namespaces' => $useNamespaces,
            'run-function' => "public function run($arguments)$return\n    {\n        $body\n    }\n",
        ];
    }

    private function updateByIdAction(): array
    {
        $name = $this->argument('name');

        $useNamespaces = "use {$this->getBranchNamespace()}\\Models\\$name;\n";
        $useNamespaces .= "use {$this->getBranchNamespace()}\\UI\\API\\DTO\\{$name}DTO;\n";
        $useNamespaces .= "use {$this->getBranchNamespace()}\\UI\\API\\DTO\\Requests\\Update{$name}RequestDTO;";

        $arguments = "Update{$name}RequestDTO \$requestDTO, string \$id";
        $return = ": {$name}DTO";
        $body = "\$item = $name::findOrFail(\$id);
        \$item->update(\$requestDTO->toArray());

        return {$name}DTO::from(\$item);";

        return [
            'name' => "Update{$name}ById",
            'branch' => $this->argument('branch'),
            'folder' => $this->argument('folder'),
            'use-namespaces' => $useNamespaces,
            'run-function' => "public function run($arguments)$return\n    {\n        $body\n    }\n",
        ];
    }

    private function deleteByIdAction(): array
    {
        $name = $this->argument('name');

        $useNamespaces = "use {$this->getBranchNamespace()}\\Models\\$name;\n";
        $useNamespaces .= "use {$this->getBranchNamespace()}\\UI\\API\\DTO\\{$name}DTO;\n";
        $useNamespaces .= "use {$this->getBranchNamespace()}\\UI\\API\\DTO\\Requests\\Update{$name}RequestDTO;";

        $arguments = 'string $id';
        $return = ': ?bool';
        $body = "return $name::findOrFail(\$id)->delete();";

        return [
            'name' => "Delete{$name}ById",
            'branch' => $this->argument('branch'),
            'folder' => $this->argument('folder'),
            'use-namespaces' => $useNamespaces,
            'run-function' => "public function run($arguments)$return\n    {\n        $body\n    }\n",
        ];
    }
}
