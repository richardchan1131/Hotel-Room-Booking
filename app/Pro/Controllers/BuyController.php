<?php

namespace App\Pro\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Theme\ThemeManager;

class BuyController extends Controller
{
    public function index(Request $request)
    {
        $data = [
            'domain'  => $request->getHost(),
            'version' => config('app.version'),
            'theme'   => ThemeManager::current()
        ];
        return redirect('https://bookingcore.co/product/buy/pro?code=' . base64_encode(json_encode($data)));
    }

}
