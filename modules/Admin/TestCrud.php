<?php


namespace Modules\Admin;


use Modules\Page\Models\Page;

class TestCrud extends BaseCrudModule
{
    public $model = Page::class;

    public function index(){
        return [
          "permission"=>"xxx",
          "layouts"=>[

          ]
        ];
    }
    public function create(){
        return [
          "permission"=>"page_create",
          "layouts"=>[
                "div"=>[
                    "class"=>"xxx",
                    "text"=>"xxx"
                ],
              "span"=>[
                  "text"=>"Xin chào bạn"
              ]
          ]
        ];
    }
}
