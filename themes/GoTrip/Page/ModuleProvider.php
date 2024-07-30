<?php namespace Themes\GoTrip\Page;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;
use Modules\Page\Hook;
use Modules\Page\Models\Page;

class ModuleProvider extends ServiceProvider
{

    public function boot(){
        add_action(Hook::PAGE_BEFORE_SAVING,[$this,'save_footer_style']);
    }

    public function save_footer_style(Page $page,Request $request){
        if (!empty($request->input('save_footer_style')))
        $page->footer_style = $request->input('footer_style');
        $page->disable_subscribe_default = $request->input('disable_subscribe_default');
    }
}
