<?php
namespace Modules\Property\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\AdminController;
use Modules\Property\Models\Property;
use Modules\Property\Models\PropertyDate;

class AvailabilityController extends \Modules\Property\Controllers\AvailabilityController
{
    protected $propertyClass;
    /**
     * @var PropertyDate
     */
    protected $propertyDateClass;
    protected $indexView = 'Property::admin.availability';

    public function __construct()
    {
        parent::__construct();
        $this->setActiveMenu('admin/module/property');
        $this->middleware('dashboard');
    }

}
