<?php

namespace Modules\Template;

use Modules\ModuleServiceProvider;
use Modules\Template\Blocks\RootBlock;

class ModuleProvider extends ModuleServiceProvider
{
    public function boot()
    {

    }

    public function register()
    {
        $this->app->register(RouterServiceProvider::class);
    }

    public static function getTemplateBlocks()
    {
        return [
            'root' => RootBlock::class,
            // 'row'=>"\\Modules\\Template\\Blocks\\Row",
            // 'column'=>"\\Modules\\Template\\Blocks\\Column",
            'text' => "\\Modules\\Template\\Blocks\\Text",
            'call_to_action' => "\\Modules\\Template\\Blocks\\CallToAction",
            'video_player' => "\\Modules\\Template\\Blocks\\VideoPlayer",
            'faqs' => "\\Modules\\Template\\Blocks\\FaqList",
            'list_featured_item' => "\\Modules\\Template\\Blocks\\ListFeaturedItem",
            'testimonial' => "\\Modules\\Template\\Blocks\\Testimonial",
            'form_search_all_service' => "\\Modules\\Template\\Blocks\\FormSearchAllService",
            'offer_block' => "\\Modules\\Template\\Blocks\\OfferBlock",
            'how_it_works' => "\\Modules\\Template\\Blocks\\HowItWork",
            'client_feedback' => "\\Modules\\Template\\Blocks\\ClientFeedBack",
        ];
    }
}
