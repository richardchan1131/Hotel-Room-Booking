<?php

namespace Modules\Tracking\Facades;

use Illuminate\Support\Facades\Facade;
/**
 * @method static void track(string $eventName, array $data, int $timeout_seconds = 300)
 *
 * @see \Modules\Tracking\Tracker
 */

class Tracker extends Facade
{

    const PAGE_VIEW = 'PAGE_VIEW';

    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'tracker';
    }
}
