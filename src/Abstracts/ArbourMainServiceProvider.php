<?php

namespace Arbour\Abstracts;

use Arbour\Loaders\AutoLoaderTrait;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

abstract class ArbourMainServiceProvider extends LaravelServiceProvider
{
    use AutoLoaderTrait;

    protected array $serviceProviders = [];
    protected array $aliases = [];

    public function register(): void
    {
        $this->registerBranch();
    }

    public function boot(): void
    {
        $this->bootBranch();
    }
}
