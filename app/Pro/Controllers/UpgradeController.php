<?php

namespace App\Pro\Controllers;

use Modules\AdminController;

class UpgradeController extends AdminController
{

    public function index()
    {
        return view("Pro::admin.upgrade");
    }
}
