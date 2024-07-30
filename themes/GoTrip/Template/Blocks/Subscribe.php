<?php
namespace Themes\GoTrip\Template\Blocks;

use Modules\Media\Helpers\FileHelper;
use Modules\Template\Blocks\BaseBlock;

class Subscribe extends BaseBlock
{
    function getOptions()
    {
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

        $arg[] = [
            'id'    => 'bg_image',
            'type'  => 'uploader',
            'label' => __('Background Image Uploader'),
        ];

        $arg[] = [
            'id' => 'style',
            'type' => 'radios',
            'label' => __('Subscribe Style'),
            'values' => [
                [
                    'value' => '',
                    'name' => __("Style 1")
                ],
                [
                    'value' => 'style_2',
                    'name' => __("Style 2")
                ],
                [
                    'value' => 'style_3',
                    'name' => __("Style 3")
                ]
            ]
        ];


        return ([
            'settings' => $arg,
            'category'=>__("Other Block")
        ]);
    }

    public function getName()
    {
        return __('Subscribe');
    }

    public function content($model = [])
    {
        $data = [];
        if (!empty($model['bg_image'])) {
            $data['bg_image_url'] = FileHelper::url($model['bg_image'], 'full');
        }
        $data = array_merge($model, $data);
        return $this->view('Template::frontend.blocks.subscribe.index', $data);
    }

    public function contentAPI($model = []){
        return $model;
    }
}
