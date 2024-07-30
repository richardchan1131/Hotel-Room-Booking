<?php
namespace Themes\GoTrip\Template\Blocks;

use Modules\Media\Helpers\FileHelper;
use Modules\Template\Blocks\BaseBlock;

class Terms extends BaseBlock
{
    public function getOptions(){
        return [
            'settings' => [
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
                            'id'    => 'desc',
                            'type'      => 'editor',
                            'inputType' => 'textArea',
                            'label' => __('Desc')
                        ],
                    ]
                ]
            ],
            'category'=>__("Other Block")
        ];
    }

    public function getName()
    {
        return __('List Terms');
    }

    public function content($model = [])
    {
        return view('Template::frontend.blocks.terms.index', $model);
    }

    public function contentAPI($model = []){
        return $model;
    }
}
