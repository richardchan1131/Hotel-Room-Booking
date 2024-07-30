<?php
namespace Themes\GoTrip\Space\Blocks;

use Modules\Template\Blocks\BaseBlock;
use Modules\Space\Models\Space;
use Modules\Location\Models\Location;

class ListSpace extends BaseBlock
{
    protected $spaceClass;
    public function __construct(Space $spaceClass)
    {
        $this->spaceClass = $spaceClass;
    }

    public function getName()
    {
        return __('Space: List Items');
    }

    public function getOptions()
    {
        return [
            'settings' => [
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
                    'id'     => 'style',
                    'type'   => 'radios',
                    'label'  => __('Style'),
                    'values' => [
                        [
                            'value' => 'normal',
                            'name'  => __("Normal")
                        ],
                        [
                            'value' => 'style_1',
                            'name'  => __("Style 1")
                        ]
                    ]
                ],
                [
                    'id'           => 'location_id',
                    'type'         => 'select2',
                    'label'        => __('Filter by Location'),
                    'select2'      => [
                        'ajax'        => [
                            'url'      => route('location.admin.getForSelect2'),
                            'dataType' => 'json'
                        ],
                        'width'       => '100%',
                        'allowClear'  => 'true',
                        'placeholder' => __('-- Select --')
                    ],
                    'pre_selected' => route('location.admin.getForSelect2',['pre_selected'=>1])
                ],
                [
                    'id'     => 'order',
                    'type'   => 'radios',
                    'label'  => __('Order'),
                    'values' => [
                        [
                            'value' => 'id',
                            'name'  => __("Date Create")
                        ],
                        [
                            'value' => 'title',
                            'name'  => __("Title")
                        ],
                    ]
                ],
                [
                    'id'     => 'order_by',
                    'type'   => 'radios',
                    'label'  => __('Order By'),
                    'values' => [
                        [
                            'value' => 'asc',
                            'name'  => __("ASC")
                        ],
                        [
                            'value' => 'desc',
                            'name'  => __("DESC")
                        ],
                    ]
                ],
                [
                    'type'    => "checkbox",
                    'label'   => __("Only featured items?"),
                    'id'      => "is_featured",
                    'default' => true
                ],
                [
                    'id'           => 'custom_ids',
                    'type'         => 'select2',
                    'label'        => __('List by IDs'),
                    'select2'      => [
                        'ajax'        => [
                            'url'      => route('space.admin.getForSelect2'),
                            'dataType' => 'json'
                        ],
                        'width'       => '100%',
                        'multiple'    => "true",
                        'placeholder' => __('-- Select --')
                    ],
                    'pre_selected' => route('space.admin.getForSelect2', [
                        'pre_selected' => 1
                    ])
                ],
            ],
            'category' => __("Service Space")
        ];
    }

    public function content($model = [])
    {
        $list = $this->query($model);
        $model['style'] = !empty($model['style']) ? $model['style'] :  "normal";
        $template = ($model['style'] == "normal" ) ? "index" : $model['style'];
        $data = [
            'rows'       => $list,
            'style_list' => $model['style'],
            'title'      => $model['title'],
            'desc'       => $model['desc'],
        ];
        if (view()->exists($view = 'Space::frontend.blocks.list-space.'.$template)) {
            return view($view, $data);
        }
    }

    public function contentAPI($model = [])
    {
        $rows = $this->query($model);
        $model['data'] = $rows->map(function ($row) {
            return $row->dataForApi();
        });
        return $model;
    }

    public function query($model)
    {
        $listSpace = $this->spaceClass->search($model);
        $limit = $model['number'] ?? 5;
        return $listSpace->paginate($limit);
    }
}
