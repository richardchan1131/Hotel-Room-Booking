<?php


namespace Modules\Core\Facades;


use Illuminate\Support\Facades\Facade;
use Modules\Core\Helpers\HookManager;

/**
 * Class Hook
 * @method static HookManager action(...$args)
 * @method static HookManager filter(...$args)
 * @method static HookManager do(...$args)
 * @method static HookManager addAction($hook, $callback, $priority = 20, $arguments = 1)
 * @method static HookManager addFilter($hook, $callback, $priority = 20, $arguments = 1)
 * ($hook, $callback, $priority = 20, $arguments = 1)
 * @package Modules\Core\Facades
 */
class Hook extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() { return 'hook_manager'; }
}
