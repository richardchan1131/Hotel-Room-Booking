<?php
namespace Themes\GoTrip\Template\Blocks;

use Modules\Flight\Models\SeatType;
use Modules\Media\Helpers\FileHelper;
use Modules\Location\Models\Location;

class FormSearchAllService extends \Modules\Template\Blocks\FormSearchAllService
{

    public function getOptions()
    {
        $list_service = [];
        foreach (get_bookable_services() as $key => $service) {
            $list_service[] = ['value'   => $key,
                'name' => ucwords($key)
            ];
        }
        $arg[] = [
            'id'            => 'service_types',
            'type'          => 'checklist',
            'listBox'          => 'true',
            'label'         => "<strong>".__('Service Type')."</strong>",
            'values'        => $list_service,
        ];

        $arg[] = [
            'id'        => 'title',
            'type'      => 'input',
            'inputType' => 'text',
            'label'     => __('Title')
        ];
        $arg[] = [
            'id'        => 'sub_title',
            'type'      => 'input',
            'inputType' => 'text',
            'label'     => __('Sub Title')
        ];

        $arg[] =  [
            'id'            => 'style',
            'type'          => 'radios',
            'label'         => __('Style Background'),
            'values'        => [
                [
                    'value'   => '',
                    'name' => __("Normal")
                ],
                [
                    'value'   => 'normal2',
                    'name' => __("Normal Ver 2")
                ],
                [
                    'value'   => 'carousel_v2',
                    'name' => __("Slider Ver 2")
                ],
                [
                    'value'   => 'carousel_v3',
                    'name' => __("Slider Carousel")
                ]
            ]
        ];

        $arg[] = [
            'id'    => 'bg_image',
            'type'  => 'uploader',
            'label' => __('- Layout Normal: Background Image Uploader')
        ];

        $arg[] = [
            'id'          => 'list_slider',
            'type'        => 'listItem',
            'label'       => __('- Layout Slider: List Item(s)'),
            'title_field' => 'title',
            'settings'    => [
                [
                    'id'    => 'bg_image',
                    'type'  => 'uploader',
                    'label' => __('Background Image Uploader')
                ]
            ]
        ];

        $arg[] = [
            'type'=> "checkbox",
            'label'=>__("Hide form search service?"),
            'id'=> "hide_form_search",
            'default'=>false
        ];

        return [
            'settings' => $arg,
            'category'=>__("Other Block")
        ];
    }

    public function content($model = [])
    {
        $model['bg_image_url'] = FileHelper::url($model['bg_image'] ?? "", 'full') ?? "";
        $model['list_location'] = $model['tour_location'] =  Location::where("status","publish")->limit(1000)->with(['translation'])->get()->toTree();
        $model['style'] = $model['style'] ?? "";
        $model['list_slider'] = $model['list_slider'] ?? "";
        $model['modelBlock'] = $model;
        $model['seatType'] =  SeatType::get();
        $model['icons'] = [
            'hotel'  => 'icon-bed',
            'tour'   => 'icon-destination',
            'space'  => 'icon-ski',
            'event'  => 'icon-home',
            'car'    => 'icon-car',
            'boat'   => 'icon-yatch',
            'flight' => 'icon-tickets'
        ];
        return $this->view('Template::frontend.blocks.form-search-all-service.index', $model);
    }

}
