<?php

namespace Modules\Type\Types;

use Modules\Tour\Models\Tour;
use Modules\Type\Abstracts\BaseType;

class SpaType extends BaseType
{

    public $model = Tour::class;

    public array $permissions = [
        'manage' => 'tour_manage_others'
    ];

    public function adminActions():array
    {
        return [
            'view'=>[
                'permission'=>'tour_create',
                'title'=>__('Spa')
            ],
            'edit'=>[
                'permission'=>'tour_update',
            ]
        ];
    }

    protected function getLabels(): array
    {
        return [
            'name'=>__("Spa"),
            'plural'=>__("Spas"),
        ];
    }
}
