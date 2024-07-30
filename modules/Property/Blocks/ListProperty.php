<?php
namespace Modules\Property\Blocks;

use Modules\Template\Blocks\BaseBlock;
use Modules\Property\Models\Property;
use Modules\Location\Models\Location;

class ListProperty extends BaseBlock
{
    function getOptions()
    {
        $args = [

                [
                    'id'        => 'title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Title')
                ],
                [
                    'id'        => 'desc',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Desc')
                ],
                [
                    'id'        => 'number',
                    'type'      => 'input',
                    'inputType' => 'number',
                    'label'     => __('Number Item')
                ],
                [
                    'id'      => 'location_id',
                    'type'    => 'select2',
                    'label'   => __('Filter by Location'),
                    'select2' => [
                        'ajax'  => [
                            'url'      => url('/admin/module/location/getForSelect2'),
                            'dataType' => 'json'
                        ],
                        'width' => '100%',
                        'allowClear' => 'true',
                        'placeholder' => __('-- Select --')
                    ],
                    'pre_selected'=>url('/admin/module/location/getForSelect2?pre_selected=1'),
//                    'conditions'=>['order_by'=>'asc','order'=>'id']

                ],
                [
                    'id'            => 'order',
                    'type'          => 'radios',
                    'label'         => __('Order'),
                    'values'        => [
                        [
                            'value'   => 'id',
                            'name' => __("Date Create")
                        ],
                        [
                            'value'   => 'title',
                            'name' => __("Title")
                        ],
                    ],
                ],
                [
                    'id'            => 'order_by',
                    'type'          => 'radios',
                    'label'         => __('Order By'),
                    'values'        => [
                        [
                            'value'   => 'asc',
                            'name' => __("ASC")
                        ],
                        [
                            'value'   => 'desc',
                            'name' => __("DESC")
                        ],
                    ],
                ],[
                'id'            => 'layout',
                'type'          => 'radios',
                'label'         => __('Layout'),
                'values'        => [
                    [
                        'value'   => '',
                        'name' => __("Carousel Layout")
                    ],
                    [
                        'value'   => 'style_2',
                        'name' => __("View All Option")
                    ],
                    [
                        'value'   => 'style_3',
                        'name' => __("View All With 3 Items Grid")
                    ],
                    [
                        'value'   => 'style_4',
                        'name' => __("Style 4")
                    ]
                ]
            ],
            [
                'type'=> "checkbox",
                'label'=>__("Only featured items?"),
                'id'=> "is_featured",
                'default'=>true
            ],
            [
                'type'=> "checkbox",
                'label'=>__("Hide button scroll down?"),
                'id'=> "hide_scroll_down",
                'default'=>false
            ]

        ];
        return (['settings'=>$args]);
    }

    public function getName()
    {
        return __('Property: List Items');
    }

    public function content($model = [])
    {

        if (empty($model['layout'])) {
            $model['layout'] = 'index';
        }
        $model_property = Property::select("bc_properties.*")->with(['location','translation','hasWishList', 'user', 'Category']);
        if(empty($model['order'])) $model['order'] = "id";
        if(empty($model['order_by'])) $model['order_by'] = "desc";
        if(empty($model['number'])) $model['number'] = 5;
        if (!empty($model['location_id'])) {
            $location = Location::where('id', $model['location_id'])->where("status","publish")->first();
            if(!empty($location)){
                $model_property->join('bc_locations', function ($join) use ($location) {
                    $join->on('bc_locations.id', '=', 'bc_properties.location_id')
                        ->where('bc_locations._lft', '>=', $location->_lft)
                        ->where('bc_locations._rgt', '<=', $location->_rgt);
                });
            }
        }

        if(!empty($model['is_featured']))
        {
            $model_property->where('is_featured',1);
        }

        $model_property->orderBy("bc_properties.".$model['order'], $model['order_by']);
        $model_property->where("bc_properties.status", "publish");
        $model_property->with('location');
        $model_property->groupBy("bc_properties.id");
        $list = $model_property->limit($model['number'])->get();
        $data = [
            'rows'       => $list,
            'title'      => $model['title'],
            'desc'       => $model['desc'],
            'hide_scroll_down'=>$model['hide_scroll_down']??false
        ];

        return view('Property::frontend.blocks.list-property.'.$model['layout'], $data);
    }
}
