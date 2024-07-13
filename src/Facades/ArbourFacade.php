<?php

namespace Arbour\Facades;

use Arbour\Arbour;
use Illuminate\Support\Facades\Facade;

/**
 * @see \Arbour
 */
class ArbourFacade extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return Arbour::class;
    }
}
