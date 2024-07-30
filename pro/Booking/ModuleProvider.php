<?php

namespace Pro\Booking;

use Pro\ModuleServiceProvider;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/Views', 'Booking');
        $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');
    }
}
