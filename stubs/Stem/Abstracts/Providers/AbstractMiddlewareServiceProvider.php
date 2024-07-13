<?php

namespace App\Stem\Abstracts\Providers;

use Arbour\Abstracts\MiddlewareServiceProvider;

abstract class AbstractMiddlewareServiceProvider extends MiddlewareServiceProvider
{
    protected array $middlewares = [];

    protected array $middlewareGroups = [];

    protected array $middlewarePriority = [];

    protected array $routeMiddleware = [];
}
