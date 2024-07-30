<?php
namespace Themes\GoTrip\Event\Blocks;

use Modules\Core\Models\Terms;
use Modules\Template\Blocks\BaseBlock;
use Modules\Location\Models\Location;
use Modules\Media\Helpers\FileHelper;

class EventTermFeatureBox extends BaseBlock
{

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
                    'id'           => 'term_event',
                    'type'         => 'select2',
                    'label'        => __('Select term event'),
                    'select2'      => [
                        'ajax'     => [
                            'url'      => route('event.admin.attribute.term.getForSelect2', ['type' => 'event']),
                            'dataType' => 'json'
                        ],
                        'width'    => '100%',
                        'multiple' => "true",
                    ],
                    'pre_selected' => route('event.admin.attribute.term.getForSelect2', [
                        'type'         => 'event',
                        'pre_selected' => 1
                    ])
                ],
            ],
            'category'=>__("Service Event")
        ];
    }

    public function getName()
    {
        return __('Event: Term Feature Box');
    }

    public function content($model = [])
    {
        if (empty($term_event = $model['term_event'])) {
            return "";
        }
        $list_term = Terms::whereIn('id',$term_event)->with(['translation','event'])->get();
        $model['list_term'] = $list_term;
        return view('Event::frontend.blocks.term-featured-box.index', $model);
    }
}
