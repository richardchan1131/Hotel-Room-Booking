<?php

namespace Pro\Ai\Controllers;

use Illuminate\Http\Request;
use Modules\FrontendController;
use Pro\Ai\Drivers\AiDriver;

class TextController extends FrontendController
{

    private AiDriver $aiDriver;

    public function __construct(AiDriver $aiDriver)
    {
        parent::__construct();
        $this->aiDriver = $aiDriver;
    }

    public function generate(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'type'    => 'required'
        ]);

        $content = __("Write a ") . $request->input("type") . ' about ' . $request->input('message');

        $options = config('ai.data_types')[$request->input('type')] ?? [];
        $newContent = $this->aiDriver->generate($content, $options);

        return [
            'content' => $newContent
        ];
    }
}
