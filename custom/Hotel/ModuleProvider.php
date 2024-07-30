<?php

namespace Custom\Hotel;

class ModuleProvider extends \Modules\ModuleServiceProvider
{
    public function register()
    {
        $this->app->bind(
            'Modules\Hotel\Controllers\VendorRoomController', 
            'Custom\Hotel\Controllers\VendorRoomController'
         );
    }

    public function boot()
    {
        
    }
}
