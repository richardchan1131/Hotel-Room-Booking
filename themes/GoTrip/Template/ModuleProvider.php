<?php
namespace Themes\GoTrip\Template;

use Illuminate\Support\ServiceProvider;
use Modules\Template\Models\Template;
use Themes\GoTrip\Template\Blocks\AboutText;
use Themes\GoTrip\Template\Blocks\DownloadApp;
use Themes\GoTrip\Template\Blocks\FaqList;
use Themes\GoTrip\Template\Blocks\FormSearchAllService;
use Themes\GoTrip\Template\Blocks\ListAllService;
use Themes\GoTrip\Template\Blocks\ListFeaturedItem;
use Themes\GoTrip\Template\Blocks\LoginRegister;
use Themes\GoTrip\Template\Blocks\OfferBlock;
use Themes\GoTrip\Template\Blocks\Subscribe;
use Themes\GoTrip\Template\Blocks\Terms;
use Themes\GoTrip\Template\Blocks\TextFeaturedBox;
use Themes\GoTrip\Template\Blocks\TextImage;


class ModuleProvider extends ServiceProvider
{
    public function boot(){
        Template::register(static::getTemplateBlocks());
    }
    public static function getTemplateBlocks(){
        return [
            "list_all_service"=>ListAllService::class,
            'subscribe'=>Subscribe::class,
            'download_app' => DownloadApp::class,
            'login_register' => LoginRegister::class,
            'list_terms'=>Terms::class,
            'faqs'=>FaqList::class,
            'about_text'=>AboutText::class,
            'form_search_all_service' => FormSearchAllService::class,
            'text_featured_box' => TextFeaturedBox::class,
            'text_image' => TextImage::class,
            //hide block for GoTrip
            'form_search_tour' => null,
            'form_search_space' => null,
            'form_search_event' => null,
            'form_search_flight' => null,
            'list_space' => null,
            'space_term_featured_box' => null,
            'list_tours' => null,
            'box_category_tour' => null,
            'car_term_featured_box' => null,
            'list_event' => null,
            'event_term_featured_box' => null,
            'offer_block' => OfferBlock::class
        ];
    }
}
