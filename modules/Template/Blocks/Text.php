<?php
namespace Modules\Template\Blocks;
class Text extends BaseBlock
{

    public function getName()
    {
        return __('Text');
    }

    public function getOptions()
    {
        return [
            'setting_tabs' => [
                'content' => [
                    'label' => __("Content"),
                    'icon'  => 'fa fa-pencil',
                    'order' => 1
                ],
                'style'   => [
                    'label' => __("Style"),
                    'order' => 2,
                    'icon'  => 'fa fa-object-group',
                ],
            ],
            'settings' => [
                [
                    'id'    => 'content',
                    'type'  => 'editor',
                    'label' => __('Editor'),
                    'tab'   => 'content'
                ],
                [
                    'id'        => 'class',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label' => __('Wrapper Class (opt)'),
                    'tab'   => 'content'
                ],
                [
                    'id'    => 'padding',
                    'type'  => 'spacing',
                    'label' => __('Padding'),
                    'tab'   => 'style'
                ],
            ],
            'category'=>__("Other Block")
        ];
    }

    public function content($model = [])
    {
        return $this->view('Template::frontend.blocks.text', $model);
    }
}
