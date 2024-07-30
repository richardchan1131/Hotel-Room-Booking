<?php
namespace Themes\GoTrip\Boat\Blocks;

use Modules\Location\Models\Location;
use Modules\Media\Helpers\FileHelper;

class FormSearchBoat extends \Modules\Boat\Blocks\FormSearchBoat
{
    public function getOptions()
    {
        return [
            'settings' => [
                [
                    'id'            => 'style',
                    'type'          => 'radios',
                    'label'         => __('Style Background'),
                    'values'        => [
                        [
                            'value'   => 'boatousel',
                            'name' => __("Slider Boatousel")
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
                            'id'    => 'bg_image',
                            'type'  => 'uploader',
                            'label' => __('Background Image Uploader')
                        ]
                    ]
                ],
                [
                    'id'        => 'scroll_down_id',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Scroll Down ID')
                ]
            ],
            'category'=>__("Service Boat")
        ];
    }

    public function getName()
    {
        return __('Boat: Form Search');
    }

    public function content($model = [])
    {
        $limit_location = 15;
        if( empty(setting_item("boat_location_search_style")) or setting_item("boat_location_search_style") == "normal" ){
            $limit_location = 1000;
        }
        $data = [
            'list_location' => Location::where("status","publish")->limit($limit_location)->with(['translation'])->get()->toTree(),
        ];
        $data = array_merge($model, $data);
        $data['style'] = $model['style'] ?? "";
        $data['list_slider'] = $model['list_slider'] ?? "";
        return $this->view('Boat::frontend.blocks.form-search-boat.index', $data);
    }

    public function contentAPI($model = []){
        if (!empty($model['bg_image'])) {
            $model['bg_image_url'] = FileHelper::url($model['bg_image'], 'full');
        }
        return $model;
    }
}
