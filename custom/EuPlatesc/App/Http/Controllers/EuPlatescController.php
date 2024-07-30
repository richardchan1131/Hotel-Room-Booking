<?php

namespace Custom\EuPlatesc\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Custom\EuPlatesc\App\Models\VendorEuPlatesc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\FrontendController;

class EuPlatescController extends Controller
{
    public function index()
    {
        $data = [
            'page_title' => __("Payment Settings"),
            'breadcrumbs' => [
                [
                    'name'  => __('Vendor dashboard'),
                    'url' => route('vendor.dashboard')
                ],
                [
                    'name'  => __('Payments'),
                    'class' => 'active'
                ],
            ],
            'euplatesc_data' => VendorEuPlatesc::where('vendor_id', Auth::id())->first()
            // 'payouts'=> VendorPayout::query()->where('vendor_id',Auth::id())->orderBy('id','desc')->paginate(20),
            // 'currentUser' => Auth::user(),
            // 'available_payout_amount'=>Auth::user()->available_payout_amount
        ];
        return view('EuPlatesc::index', $data);
    }

    public function save(Request $request)
    {
        VendorEuplatesc::where('vendor_id', Auth::user()->id)->updateOrCreate(
            ['vendor_id' => Auth::id()],
            [
                'mid' => $request->euplatesc_mid,
                'key' => $request->euplatesc_key,
                'active' => $request->euplatesc_active ? 1 : 0
            ]
        );

        return back()->with('success', __("Your EuPlatesc credetentials updated succesfully!"));
    }
}
