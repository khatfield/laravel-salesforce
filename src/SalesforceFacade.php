<?php

namespace Khatfield\LaravelSalesforce;

use Illuminate\Support\Facades\Facade;

class SalesforceFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'salesforce';
    }
}