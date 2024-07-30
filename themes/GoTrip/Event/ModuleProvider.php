<?php
namespace Themes\GoTrip\Event;

use Illuminate\Support\ServiceProvider;
use Modules\Core\Models\Terms;
use Modules\Event\Hook;
use Modules\Template\Models\Template;
use Themes\GoTrip\Event\Blocks\EventTermFeatureBox;
use Themes\GoTrip\Event\Blocks\FormSearchEvent;
use Themes\GoTrip\Event\Blocks\ListEvent;

class ModuleProvider extends ServiceProvider
{
    public function boot(){
        $this->mergeConfigFrom(__DIR__ . '/Configs/event.php','event');
        Template::register(static::getTemplateBlocks());
        add_action(Hook::FORM_AFTER_TERM_EDIT_UPLOAD_IMAGE,[$this,'term_icon']);
    }

    public static function getTemplateBlocks(){
        return [
            'form_search_event' => FormSearchEvent::class,
            'list_event' => ListEvent::class,
            'event_term_feature_box' => EventTermFeatureBox::class
        ];
    }

    public function term_icon(Terms $terms){
        echo view('Event::admin.terms.form-icon',['row' => $terms]);
    }
}
