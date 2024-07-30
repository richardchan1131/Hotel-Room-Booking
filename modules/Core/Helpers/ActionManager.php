<?php
namespace Modules\Core\Helpers;
class ActionManager extends BaseAction
{
    /**
     * Filters a value.
     *
     * @param string $action Name of action
     * @param array  $args   Arguments passed to the filter
     *
     * @return string Always returns the value
     */
    public function fire($action, $args)
    {
        if ($this->getListeners()) {
            $this->getListeners()->where('hook', $action)->each(function ($listener) use ($action, $args) {
                call_user_func_array($this->getFunction($listener['callback']), $args);
            });
        }
    }
}
