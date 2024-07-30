<?php

namespace Modules\Core\Helpers;

use Modules\ServiceProvider;
use Modules\Theme\ThemeManager;

class ConfigBuilder
{

    static function build(){
        $modules = [];
        $data = [
            'BC_ACTIVE_THEME'=>ThemeManager::current(),
            'BC_ACTIVE_MODULES'=>$modules
        ];

    }
}
