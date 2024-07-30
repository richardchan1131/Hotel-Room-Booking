<?php


namespace Modules\Admin\Admin;


use Modules\Admin\Crud;
use Modules\AdminController;

class CrudController extends AdminController
{

    public function index($module = ''){
        if(empty($module)) abort(404);

        $crudModule = Crud::module($module);

        $configs = $crudModule->index();

        if(!empty($configs['permission'])){
            $this->checkPermission($configs['permission']);
        }

        return view("Admin::admin.crud.index");
    }
    public function create($module = ''){
        if(empty($module)) abort(404);

        $crudModule = Crud::module($module);

        $configs = $crudModule->create();

        if(!empty($configs['permission'])){
            $this->checkPermission($configs['permission']);
        }
        $data = [
            'row'=>new $crudModule->model,
            'crudModule'=>$crudModule,
            'module'=>$module,
            'layouts'=>$configs['layouts'] ?? []
        ];

        return view("Admin::admin.crud.detail",$data);
    }
}
