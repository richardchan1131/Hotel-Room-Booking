<?php

namespace Modules\Template\Controllers;

use Illuminate\Http\Request;
use Modules\FrontendController;
use Modules\Template\Models\Template;

class LiveController extends FrontendController
{

    public function preview(Request $request, Template $template)
    {

        $data = [
            'row' => $template,
            'translation' => $template->translate()
        ];
        return view('Template::frontend.preview', $data);
    }
}
