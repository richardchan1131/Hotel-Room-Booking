<?php

namespace Modules\Ai;

use App\Helpers\Assets;
use Modules\Ai\Drivers\AiDriver;
use Modules\Ai\Drivers\OpenAi;
use Modules\ModuleServiceProvider;
use Modules\User\Helpers\PermissionHelper;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/Views', 'Ai');

        $this->mergeConfigFrom(__DIR__ . '/Configs/config.php', 'ai');
        if (isPro()) {

            $this->loadRoutesFrom(__DIR__ . '/Routes/web.php');

            PermissionHelper::add([
                "ai_text_generate"
            ]);

            add_action('ADMIN_JS_STACK', [$this, '__addJs']);
        }

        $this->app->singleton(AiDriver::class, function () {
            $settings = config('ai.providers');
            $default = config('ai.default');
            if (empty($settings[$default])) {
                throw new \Exception("AI Driver not found");
            }
            return new OpenAi($settings[$default]);
        });
    }

    public function register()
    {
        parent::register(); // TODO: Change the autogenerated stub
    }

    public function __addJs()
    {
        echo view("Ai::frontend.text-generate");
    }

}