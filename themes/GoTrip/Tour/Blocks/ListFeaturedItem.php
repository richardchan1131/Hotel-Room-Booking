<?php
namespace Themes\GoTrip\Tour\Blocks;

class ListFeaturedItem extends \Modules\Template\Blocks\ListFeaturedItem
{
    public function getOptions(){
        return [
            'settings' => [
                [
                    'id'            => 'style',
                    'type'          => 'radios',
                    'label'         => __('Style'),
                    'values'        => [
                        [
                            'value'   => 'normal',
                            'name' => __("Normal")
                        ],
                        [
                            'value'   => 'style2',
                            'name' => __("Style 2")
                        ],
                        [
                            'value'   => 'style3',
                            'name' => __("Style 3")
                        ],
                        [
                            'value'   => 'style4',
                            'name' => __("Style 4")
                        ],
                        [
                            'value'   => 'style5',
                            'name' => __("Style 5")
                        ],
                        [
                            'value'   => 'style6',
                            'name' => __("Style 6")
                        ]
                    ]
                ],
                [
                    'id'        => 'title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Title'),
                    'conditions' => ['style' => ['normal','style1','style2','style3','style4', 'style6']]
                ],
                [
                    'id'        => 'sub_title',
                    'type'      => 'input',
                    'inputType' => 'textArea',
                    'label'     => __('Sub Title'),
                    'conditions' => ['style' => ['normal','style1','style2','style3','style4', 'style6']]
                ],
                [
                    'id'        => 'description',
                    'type'      => 'textArea',
                    'label'     => __('Description'),
                    'conditions' => ['style' => ['style6']]
                ],
                [
                    'id'        => 'link_title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Title Link More'),
                    'conditions' => ['style' => ['style6']]
                ],
                [
                    'id'        => 'link_more',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Link More'),
                    'conditions' => ['style' => ['style6']]
                ],
                [
                    'id'          => 'list_item',
                    'type'        => 'listItem',
                    'label'       => __('List Item(s)'),
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
                            'inputType' => 'textArea',
                            'label'     => __('Sub Title')
                        ],
                        [
                            'id'    => 'icon_image',
                            'type'  => 'uploader',
                            'label' => __('Image Uploader')
                        ],
                        [
                            'id'        => 'order',
                            'type'      => 'input',
                            'inputType' => 'number',
                            'label'     => __('Order')
                        ],
                    ]
                ],
                [
                    'id'        => 'youtube_image',
                    'type'  => 'uploader',
                    'label'     => __('Youtube Image'),
                    'conditions' => ['style' => 'style3']
                ],
                [
                    'id'        => 'youtube',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Youtube Link'),
                    'conditions' => ['style' => 'style3']
                ],
            ],
            'category'=>__("Other Block")
        ];
    }
}
