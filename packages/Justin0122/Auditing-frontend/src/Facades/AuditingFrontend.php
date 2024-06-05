<?php

namespace Justin0122\AuditingFrontend\Facades;

use Illuminate\Support\Facades\Facade;

class AuditingFrontend extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'auditing-frontend';
    }
}
