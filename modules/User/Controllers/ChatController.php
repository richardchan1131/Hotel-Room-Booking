<?php

namespace Modules\User\Controllers;

use Modules\FrontendController;

class ChatController extends FrontendController
{

    public function index(){
        $this->setActiveMenu(route('user.chat'));

        return view("User::frontend.chat.index",[
            'page_title'=>__("Messages")
        ]);
    }
}
