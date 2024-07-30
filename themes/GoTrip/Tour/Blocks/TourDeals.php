<?php namespace Themes\GoTrip\Tour\Blocks;

use Modules\Location\Models\Location;
use Modules\Template\Blocks\BaseBlock;
use Modules\Tour\Models\Tour;

class TourDeals extends BaseBlock
{
    public function getOptions(){
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
                    'id'        => 'book_title',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Book Title')
                ],
                [
                    'id'        => 'book_desc',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Book Desc')
                ],
                [
                    'id'        => 'book_url',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Book Url')
                ],
                [
                    'id'        => 'book_url_text',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Book Url Text')
                ],
                [
                    'id'        => 'book_img',
                    'type'      => 'uploader',
                    'label'     => __('Book Image')
                ],
                [
                    'id'        => 'number',
                    'type'      => 'input',
                    'inputType' => 'number',
                    'label'     => __('Number Item')
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
                            'value'   => 'title',
                            'name' => __("Title")
                        ],
                    ]
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
                    ]
                ]
            ],
            'category'=>__("Service Tour")
        ];
    }

    public function getName()
    {
        return __('Tour: Tour Deals');
    }

    public function content($model = [])
    {
        $list = $this->query($model);
        $data = [
            'rows'       => $list,
            'title'      => $model['title'] ?? "",
            'desc'      => $model['desc'] ?? "",
            'book_title' => $model['book_title'] ?? '',
            'book_desc' => $model['book_desc'] ?? '',
            'book_url' => $model['book_url'] ?? '',
            'book_url_text' => $model['book_url_text'] ?? '',
            'book_img' => $model['book_img'] ?? '',
        ];
        return view('Tour::frontend.blocks.tour-deals.index', $data);
    }

    public function query($model){
        $model_Tour = Tour::select("bravo_tours.*")->with(['location','translation','hasWishList']);
        if(empty($model['order'])) $model['order'] = "id";
        if(empty($model['order_by'])) $model['order_by'] = "desc";
        if(empty($model['number'])) $model['number'] = 5;
        if (!empty($model['location_id'])) {
            $location = Location::where('id', $model['location_id'])->where("status","publish")->first();
            if(!empty($location)){
                $model_Tour->join('bravo_locations', function ($join) use ($location) {
                    $join->on('bravo_locations.id', '=', 'bravo_tours.location_id')
                        ->where('bravo_locations._lft', '>=', $location->_lft)
                        ->where('bravo_locations._rgt', '<=', $location->_rgt);
                });
            }
        }
        $model_Tour->orderBy("bravo_tours.".$model['order'], $model['order_by']);
        $model_Tour->where("bravo_tours.status", "publish");
        $model_Tour->with('location');
        $model_Tour->groupBy("bravo_tours.id");
        return $model_Tour->limit($model['number'])->get();
    }
}
