<?php
namespace Themes\GoTrip\News;

use Illuminate\Support\ServiceProvider;

use Modules\Template\Models\Template;
use Themes\GoTrip\News\Blocks\ListNews;

class ModuleProvider extends ServiceProvider
{

    public function boot(){
        Template::register(static::getTemplateBlocks());
    }

    public static function getTemplateBlocks(){
        return [
            'list_news'=>ListNews::class,
        ];
    }
}
