<?php
namespace Themes\GoTrip\Template\Blocks;

use Modules\Template\Blocks\BaseBlock;

class TextImage extends BaseBlock
{

    public function getName()
    {
        return __('Text Image');
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
                    'type'      => 'textArea',
                    'label'     => __('Description')
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
                    'id'    => 'bg_image_1',
                    'type'  => 'uploader',
                    'label' => __('Image 1'),
                ],
                [
                    'id'    => 'bg_image_2',
                    'type'  => 'uploader',
                    'label' => __('Image 2')
                ]
            ],
            'category'=>__("Other Block")
        ];
    }

    public function content($model = [])
    {
        return $this->view('Template::frontend.blocks.text-image.index', $model);
    }
}
