<?php

namespace Anosmx\TapPayment\Facades;

use Illuminate\Support\Facades\Facade;

class TapCharge extends Facade
{
    /**
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'tap_charge';
    }
}