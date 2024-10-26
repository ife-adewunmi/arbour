<?php

namespace App\Stem\Abstracts\Providers;

use Iadewunmi\ModuleGenerator\Abstracts\Providers\MiddlewareServiceProvider;

abstract class AbstractMiddlewareServiceProvider extends MiddlewareServiceProvider
{
    protected array $middlewares = [];

    protected array $middlewareGroups = [];

    protected array $middlewarePriority = [];

    protected array $routeMiddleware = [];
}
