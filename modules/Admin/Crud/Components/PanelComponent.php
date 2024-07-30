<?php


namespace Modules\Admin\Crud\Components;


class PanelComponent extends BaseComponent
{
    public function render()
    {
        view('Admin::admin.crud.components.panel')->render();
    }
}
