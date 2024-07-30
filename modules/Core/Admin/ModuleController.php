<?php

namespace Modules\Core\Admin;

use Modules\AdminController;
use Modules\ServiceProvider;

class ModuleController extends AdminController
{
    public function __construct()
    {
        $this->setActiveMenu(route('core.admin.tool.index'));
    }

    public function index(){
        $data = [
            'page_title'=>__("Module Management"),
            'rows'=>ServiceProvider::getManageableModules()
        ];

        return view('Core::admin.module.index',$data);
    }
}
