<?php

namespace Modules\Theme\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Modules\AdminController;
use Modules\Theme\ThemeManager;

class ThemeController extends AdminController
{
    public function __construct()
    {
        $this->setActiveMenu(route('theme.admin.index'));
    }

    public function index(Request $request){
        $this->checkPermission("theme_manage");
        if(Session::get('success')){
            Artisan::call('migrate', [
                '--force' => true,
            ]);
        }

        $data = [
            "rows"=>ThemeManager::all(),
            "page_title"=>__("Theme management")
        ];

        return view('Theme::admin.index',$data);
    }

    public function upload(Request $request){
        $this->checkPermission("theme_manage");

        $data = [
            "page_title"=>__("Theme Upload")
        ];

        return view('Theme::admin.upload',$data);
    }


    public function activate($theme){
        if(is_demo_mode()){
            return back()->with('error',__("Disable for demo mode"));
        }
        $this->checkPermission("theme_manage");

        $content = "<?php
        define('BC_INIT_THEME','{$theme}');";

        Storage::disk('root')->put('bc.php', $content);

        return back()->with('success',__("Theme activated"));
    }
    public function seeding($theme){

        if(is_demo_mode()){
            return back()->with('danger',__("DEMO MODE: You are not allowed to do that"));
        }

        $this->checkPermission("theme_manage");

        $provider = ThemeManager::theme($theme);

        if(class_exists($provider))
        {
            $seeder = $provider::$seeder;
            if(!class_exists($seeder)) return back()->with('error',__("This theme does not have seeder class"));

            $provider::runSeeder();

            return back()->with('success',__("Demo data has been imported"));

        }

        return back()->with('error',__("Can not run data import"));
    }
}
