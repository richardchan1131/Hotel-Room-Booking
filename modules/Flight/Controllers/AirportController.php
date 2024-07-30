<?php


    namespace Modules\Flight\Controllers;


    use Auth;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Validation\Rule;
    use Maatwebsite\Excel\Facades\Excel;
    use Modules\AdminController;
    use Modules\Flight\Imports\AirportImportIATA;
    use Modules\Flight\Models\Airport;
    use Modules\Flight\Models\Flight;
    use Modules\Flight\Models\SeatType;
    use Modules\Flight\Resources\AirportResource;
    use Modules\Location\Models\Location;

    class AirportController extends AdminController
    {
        /**
         * @var string
         */
        private $airport;
        /**
         * @var string
         */
        private $location;

        /**
         * @var string
         */

        public function __construct()
        {
            $this->location = Location::class;
            $this->airport = Airport::class;
        }

        public function search(Request $request)
        {
            $pre_selected = $request->query('pre_selected');
            $selected = $request->query('selected');

            if($pre_selected && $selected){
                $items = $this->airport::find($selected);

                return [
                    'results'=>$items
                ];
            }
            $s = $request->query('search');
            $query = $this->airport::select('id', 'name','code','address','country');
            if ($s) {
                $query->where(function($query) use($s){
                    $query->where('name', 'LIKE', '%'.$s.'%');
                    $query->orWhere('address', 'LIKE', '%'.$s.'%');
                    $query->orWhere('code', $s);
                    $query->orWhere('country', $s);
                });
                $query->orderByRaw("
                    CASE WHEN code = ? then 1
                    When `name` like '%?%' then 2
                    When `address` like '%?%' then 3
                    When `country` = ? then 4
                    ELSE 5
                    END ASC
                ",[$s,$s,$s,$s]);
            }
            $res = $query->orderBy('id', 'desc')->limit(20)->get();
            return [
                'status'=>1,
                'data'=>AirportResource::collection($res)
            ];
        }

    }
