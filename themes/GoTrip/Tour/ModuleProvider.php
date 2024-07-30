<?php
namespace Themes\GoTrip\Tour;

use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

use Modules\Template\Models\Template;
use Modules\Tour\Hook;
use Modules\Tour\Models\TourCategory;
use Themes\GoTrip\Tour\Blocks\CallToAction;
use Themes\GoTrip\Tour\Blocks\FormSearchTour;
use Themes\GoTrip\Tour\Blocks\ListFeaturedItem;
use Themes\GoTrip\Tour\Blocks\ListTours;
use Themes\GoTrip\Tour\Blocks\OurTeam;
use Themes\GoTrip\Tour\Blocks\Testimonial;
use Themes\GoTrip\Tour\Blocks\TourDeals;
use Themes\GoTrip\Tour\Blocks\TourTypes;

class ModuleProvider extends ServiceProvider
{
    public function boot(){
        $this->mergeConfigFrom(__DIR__ . '/Configs/tour.php','tour');
        Template::register(static::getTemplateBlocks());
        add_action(Hook::FORM_AFTER_CATEGORY,[$this,'category_icon']);
        add_action(Hook::AFTER_SAVING_CATEGORY,[$this,'save_category_icon']);
    }
    public static function getTemplateBlocks(){
        return [
            'testimonial'=>Testimonial::class,
            'call_to_action'=>CallToAction::class,
            'list_featured_item'=>ListFeaturedItem::class,
            'our_team'=>OurTeam::class,
            'form_search_tour' => FormSearchTour::class,
            'list_tours' => ListTours::class,
            'tour_types' => TourTypes::class,
            'tour_deals' => TourDeals::class
        ];
    }

    public function category_icon(TourCategory $cat){
        echo view('Tour::admin.category.form-icon',['row' => $cat]);
    }

    public function save_category_icon(TourCategory $cat, Request $request){
        $cat->cat_icon = $request->input('cat_icon');
        $cat->save();
    }
}
