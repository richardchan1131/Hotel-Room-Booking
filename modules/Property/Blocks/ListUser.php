<?php
namespace Modules\Property\Blocks;

use Modules\Template\Blocks\BaseBlock;
use Modules\User\Models\Role;
use Modules\User\Models\User;

class ListUser extends BaseBlock
{
    function getOptions()
    {
        $args = [

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
                    'id'      => 'role_id',
                    'type'    => 'select2',
                    'label'   => __('Filter by Role'),
                    'select2' => [
                        'ajax'  => [
                            'url'      => route('user.admin.role.getForSelect2'),
                            'dataType' => 'json'
                        ],
                        'width' => '100%',
                        'allowClear' => 'true',
                        'placeholder' => __('-- Select --')
                    ],
                    'pre_selected'=>route('user.admin.role.getForSelect2',['pre_selected'=>1]),
//                    'conditions'=>['order_by'=>'asc','order'=>'id']

                ],
                [
                    'id'            => 'order',
                    'type'          => 'radios',
                    'label'         => __('Order'),
                    'values'        => [
                        [
                            'value'   => 'id',
                            'name' => __("Date Create")
                        ],
                        [
                            'value'   => 'name',
                            'name' => __("Name")
                        ],
                    ],
                ],
                [
                    'id'            => 'order_by',
                    'type'          => 'radios',
                    'label'         => __('Order By'),
                    'values'        => [
                        [
                            'value'   => 'asc',
                            'name' => __("ASC")
                        ],
                        [
                            'value'   => 'desc',
                            'name' => __("DESC")
                        ],
                    ],
                ],
                [
                    'id'            => 'style',
                    'type'          => 'radios',
                    'label'         => __('Style'),
                    'values'        => [
                        [
                            'value'   => '',
                            'name' => __("Style 1")
                        ],
                        [
                            'value'   => 'style_2',
                            'name' => __("Style 2")
                        ],
                    ]
                ]

        ];
        return (['settings'=>$args]);
    }

    public function getName()
    {
        return __('User: List Users');
    }

    public function content($model = [])
    {

        if (empty($model['style'])) {
            $model['style'] = 'index';
        }

        if (!empty($model['role_id'])) {
            if(empty($model['order'])) $model['order'] = "id";
            if(empty($model['order_by'])) $model['order_by'] = "desc";
            if(empty($model['number'])) $model['number'] = 5;
            $query =   Role::where('id',$model['role_id'])->first()->users();

            $query->orderBy("users.".$model['order'], $model['order_by']);
            $query->where("users.status", "publish");
            $query->groupBy("users.id");
            $list = $query->limit($model['number'])->get();
        }else{
            $query = User::select("*");
            if(empty($model['order'])) $model['order'] = "id";
            if(empty($model['order_by'])) $model['order_by'] = "desc";
            if(empty($model['number'])) $model['number'] = 5;
            $query->orderBy("users.".$model['order'], $model['order_by']);
            $query->where("users.status", "publish");
            $query->groupBy("users.id");
            $list = $query->limit($model['number'])->get();
        }


        $data = [
            'rows'       => $list,
            'title'      => $model['title'],
            'desc'       => $model['desc'],
        ];

        return view('Property::frontend.blocks.list-users.'.$model['style'], $data);
    }
}
