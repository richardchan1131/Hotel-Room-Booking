<?php
namespace Themes\GoTrip\Flight\Blocks;

use Modules\Flight\Models\SeatType;
use Modules\Location\Models\Location;
use Modules\Media\Helpers\FileHelper;
use Modules\Template\Blocks\BaseBlock;

class  FormSearchFlight extends BaseBlock
{
    public function getOptions(){
        return [
            'settings' => [
                [
                    'id'        => 'title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Title')
                ],
                [
                    'id'        => 'sub_title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Sub Title')
                ],
                [
                    'id'            => 'style',
                    'type'          => 'radios',
                    'label'         => __('Style Background'),
                    'values'        => [
                        [
                            'value'   => 'carousel_v2',
                            'name' => __("Slider Carousel")
                        ]
                    ]
                ],
                [
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
                ]
            ],
            'category'=>__("Service Flight")
        ];
    }

    public function getName()
    {
        return __('Flight: Form Search');
    }

    public function content($model = [])
    {
        $limit_location = 15;
        if( empty(setting_item("flight_location_search_style")) or setting_item("flight_location_search_style") == "normal" ){
            $limit_location = 1000;
        }
        $data = [
            'list_location' => Location::where("status","publish")->limit($limit_location)->with(['translation'])->get()->toTree()
        ];
        $data = array_merge($model, $data);

        $data['style'] = $model['style'] ?? "";
        $data['list_slider'] = $model['list_slider'] ?? "";

        $data['seatType'] =  SeatType::get();

        return view('Flight::frontend.blocks.form-search-flight.index', $data);
    }

    public function contentAPI($model = []){
        if (!empty($model['bg_image'])) {
            $model['bg_image_url'] = FileHelper::url($model['bg_image'], 'full');
        }
        return $model;
    }
}
