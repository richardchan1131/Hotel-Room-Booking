<?php
namespace Modules\Event;
use Modules\Core\Helpers\SitemapHelper;
use Modules\Event\Models\Event;
use Modules\ModuleServiceProvider;
use Modules\News\Models\News;
use Modules\User\Helpers\PermissionHelper;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(SitemapHelper $sitemapHelper){

        $this->loadMigrationsFrom(__DIR__ . '/Migrations');

        if(is_installed() and Event::isEnable()){

            $sitemapHelper->add("event",[app()->make(Event::class),'getForSitemap']);
        }
        PermissionHelper::add([
            // Event
            'event_view',
            'event_create',
            'event_update',
            'event_delete',
            'event_manage_others',
            'event_manage_attributes',
        ]);
    }
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
    }

    public static function getAdminMenu()
    {
        if(!Event::isEnable()) return [];
        return [
            'event'=>[
                "position"=>50,
                'url'        => route('event.admin.index'),
                'title'      => __('Event'),
                'icon'       => 'ion-ios-calendar',
                'permission' => 'event_view',
                'children'   => [
                    'add'=>[
                        'url'        => route('event.admin.index'),
                        'title'      => __('All Events'),
                        'permission' => 'event_view',
                    ],
                    'create'=>[
                        'url'        => route('event.admin.create'),
                        'title'      => __('Add new Event'),
                        'permission' => 'event_create',
                    ],
                    'attribute'=>[
                        'url'        => route('event.admin.attribute.index'),
                        'title'      => __('Attributes'),
                        'permission' => 'event_manage_attributes',
                    ],
                    'availability'=>[
                        'url'        => route('event.admin.availability.index'),
                        'title'      => __('Availability'),
                        'permission' => 'event_create',
                    ],
                    'recovery'=>[
                        'url'        => route('event.admin.recovery'),
                        'title'      => __('Recovery'),
                        'permission' => 'event_view',
                    ],
                ]
            ]
        ];
    }

    public static function getBookableServices()
    {
        if(!Event::isEnable()) return [];
        return [
            'event'=>Event::class
        ];
    }

    public static function getMenuBuilderTypes()
    {
        if(!Event::isEnable()) return [];
        return [
            'event'=>[
                'class' => Event::class,
                'name'  => __("Event"),
                'items' => Event::searchForMenu(),
                'position'=>51
            ]
        ];
    }

    public static function getUserMenu()
    {
        if(!Event::isEnable()) return [];
        return [
            'event' => [
                'url'   => route('event.vendor.index'),
                'title'      => __("Manage Event"),
                'icon'       => Event::getServiceIconFeatured(),
                'position'   => 80,
                'permission' => 'event_view',
                'children' => [
                    [
                        'url'   => route('event.vendor.index'),
                        'title'  => __("All Events"),
                    ],
                    [
                        'url'   => route('event.vendor.create'),
                        'title'      => __("Add Event"),
                        'permission' => 'event_create',
                    ],
                    'availability'=>[
                        'url'        => route('event.vendor.availability.index'),
                        'title'      => __('Availability'),
                        'permission' => 'event_create',
                    ],
                    [
                        'url'   => route('event.vendor.recovery'),
                        'title'      => __("Recovery"),
                        'permission' => 'event_create',
                    ],
                ]
            ],
        ];
    }

    public static function getTemplateBlocks(){
        if(!Event::isEnable()) return [];
        return [
            'form_search_event'=>"\\Modules\\Event\\Blocks\\FormSearchEvent",
            'list_event'=>"\\Modules\\Event\\Blocks\\ListEvent",
            'event_term_featured_box'=>"\\Modules\\Event\\Blocks\\EventTermFeaturedBox",
        ];
    }
}
