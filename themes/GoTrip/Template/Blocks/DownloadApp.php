<?php
namespace Themes\GoTrip\Template\Blocks;

use Modules\Media\Helpers\FileHelper;
use Modules\Template\Blocks\BaseBlock;


class DownloadApp extends BaseBlock
{
    function getOptions()
    {
        $list_service = [];


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
            'id' => 'list_item',
            'type' => 'listItem',
            'label' => __('List Item(s)'),
            'title_field' => 'title',
            'settings' => [
                [
                    'id' => 'title',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __('Title')
                ],
                [
                    'id' => 'subtitle',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __('Subtitle')
                ],
                [
                    'id' => 'icon',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __('Icon')
                ],
                [
                    'id' => 'link',
                    'type' => 'input',
                    'inputType' => 'text',
                    'label' => __('Link Download')
                ]
            ]
        ];

        $arg[] = [
            'id'    => 'bg_image',
            'type'  => 'uploader',
            'label' => __('Background Image Uploader'),
        ];

        $arg[] = [
            'id'            => 'style',
            'type'          => 'radios',
            'label'         => __('Style'),
            'values'        => [
                [
                    'value'   => 'style_1',
                    'name' => __("Style 1")
                ],
                [
                    'value'   => 'style_2',
                    'name' => __("Style 2")
                ],
                [
                    'value'   => 'style_3',
                    'name' => __("Style 3")
                ],
                [
                    'value'   => 'style_4',
                    'name' => __("Style 4")
                ],
            ]
        ];


        return ([
            'settings' => $arg,
            'category'=>__("Other Block")
        ]);
    }

    public function getName()
    {
        return __('Download App');
    }

    public function content($model = [])
    {
        $data = [];
        if (!empty($model['bg_image'])) {
            $data['bg_image_url'] = FileHelper::url($model['bg_image'], 'full');
        }
        $data = array_merge($model, $data);
        return $this->view('Template::frontend.blocks.download.index', $data);
    }

    public function contentAPI($model = []){
        return $model;
    }
}
