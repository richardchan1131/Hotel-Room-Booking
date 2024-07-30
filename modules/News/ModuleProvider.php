<?php
namespace Modules\News;

use Modules\Core\Helpers\SitemapHelper;
use Modules\ModuleServiceProvider;
use Modules\News\Models\News;

class ModuleProvider extends ModuleServiceProvider
{

    public function boot(SitemapHelper $sitemapHelper){
        $sitemapHelper->add("news",[app()->make(News::class),'getForSitemap']);

    }
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/Config/news.php', 'news'
        );

        $this->app->register(RouteServiceProvider::class);
    }

    public static function getAdminMenu()
    {
        $count = News::whereStatus('pending')->count('id');
        return [
            'news'=>[
                "position"=>10,
                'url'        => route('news.admin.index'),
                'title'      => __("News").($count ? ' <span class="badge badge-warning">'.$count.'</span>':''),
                'icon'       => 'ion-md-bookmarks',
                'permission' => 'news_view',
                'group' => 'content',
                'children'   => [
                    'news_view'=>[
                        'url'        => route('news.admin.index'),
                        'title'      => __("All News"),
                        'permission' => 'news_view',
                    ],
                    'news_create'=>[
                        'url'        => route('news.admin.create'),
                        'title'      => __("Add News"),
                        'permission' => 'news_create',
                    ],
                    'news_categoty'=>[
                        'url'        => route('news.admin.category.index'),
                        'title'      => __("Categories"),
                        'permission' => 'news_create',
                    ],
                    'news_tag'=>[
                        'url'        => route('news.admin.tag.index'),
                        'title'      => __("Tags"),
                        'permission' => 'news_create',
                    ],
                ]
            ],
        ];
    }

    public static function getTemplateBlocks(){
        return [
            'list_news'=>"\\Modules\\News\\Blocks\\ListNews",
        ];
    }

    public static function getUserMenu()
    {
        $res = [];

        $res['news'] = [
            "position"=>80.1,
            'url'        => route('news.vendor.index'),
            'title'      => __("Manage News"),
            'icon'       => 'ion-md-bookmarks',
            'permission' => 'news_view',
        ];

        return $res;
    }
}
