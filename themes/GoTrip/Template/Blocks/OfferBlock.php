<?php
namespace Themes\GoTrip\Template\Blocks;

use Modules\Template\Blocks\BaseBlock;
use Modules\Location\Models\Location;
use Modules\Media\Helpers\FileHelper;

class OfferBlock extends \Modules\Template\Blocks\OfferBlock
{
    public function getOptions()
    {
        return [
            'settings' => [
                [
                    'id'            => 'title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Title'),
                    'conditions' => ['style' => ['style1','style2']]
                ],
                [
                    'id'            => 'subtitle',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Subtitle'),
                    'conditions' => ['style' => ['style1','style2']]
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
                            'id'    => 'background_image',
                            'type'  => 'uploader',
                            'label' => __('Background Image Uploader')
                        ],
                        [
                            'type'=> "checkbox",
                            'label'=>__("OverLay"),
                            'id'=> "offer_overLay",
                            'default'=>false
                        ],
                        [
                            'id'        => 'link_title',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Title Link More')
                        ],
                        [
                            'id'        => 'link_more',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Link More')
                        ],
                        [
                            'id'        => 'featured_text',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Featured text')
                        ],
                        [
                            'id'        => 'featured_icon',
                            'type'      => 'input',
                            'inputType' => 'text',
                            'label'     => __('Featured icon (find icon class in : https://icofont.com/icons)')
                        ]
                    ]
                ],
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
                            'value'   => 'style1',
                            'name' => __("Style 1")
                        ],
                        [
                            'value'   => 'style2',
                            'name' => __("Style 2")
                        ]
                    ]
                ]
            ],
            'category'=>__("Other Block")
        ];
    }

    public function content($model = [])
    {
        return $this->view('Template::frontend.blocks.offer-block.index', $model);
    }

    public function contentAPI($model = []){
        if(!empty($model['list_item'])){
            foreach (  $model['list_item'] as &$item ){
                $item['background_image_url'] = FileHelper::url($item['background_image'], 'full');
            }
        }
        return $model;
    }
}
