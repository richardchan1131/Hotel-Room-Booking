<?php
namespace Modules\Property\Blocks;

use Modules\Template\Blocks\BaseBlock;
use Modules\Core\Models\Terms;

class PropertyTermFeaturedBox extends BaseBlock
{
    function getOptions()
    {
        return ([
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
                    'id'           => 'term_property',
                    'type'         => 'select2',
                    'label'        => __('Select term property'),
                    'select2'      => [
                        'ajax'     => [
                            'url'      => route('property.admin.attribute.term.getForSelect2', ['type' => 'property']),
                            'dataType' => 'json'
                        ],
                        'width'    => '100%',
                        'multiple' => "true",
                    ],
                    'pre_selected' => route('property.admin.attribute.term.getForSelect2', [
                        'type'         => 'property',
                        'pre_selected' => 1
                    ])
                ],
            ]
        ]);
    }

    public function getName()
    {
        return __('Property: Term Featured Box');
    }

    public function content($model = [])
    {
        if (empty($term_property = $model['term_property'])) {
            return "";
        }
        $list_term = Terms::whereIn('id',$term_property)->get();
        $model['list_term'] = $list_term;
        return view('Property::frontend.blocks.term-featured-box.index', $model);
    }
}
