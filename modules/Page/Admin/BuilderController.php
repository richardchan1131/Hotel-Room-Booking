<?php


namespace Modules\Page\Admin;


use Illuminate\Http\Request;
use Modules\AdminController;
use Modules\Page\Models\Page;
use Modules\Template\Models\Template;

class BuilderController extends AdminController
{
    public function edit(Request $request, $id)
    {
        $this->checkPermission('page_update');
        $row = Page::find($id);

        if (empty($row)) {
            return redirect(route('page.admin.index'));
        }

        $translation = $row->translate($request->query('lang',get_main_lang()));

        $data = [
            'translation'  => $translation,
            'row'            =>$row,
            'templates'   => Template::orderBy('id', 'desc')->limit(100)->get(),
            'breadcrumbs' => [
                [
                    'name' => __('Pages'),
                    'url'  => route('page.admin.index')
                ],
                [
                    'name'  => __('Edit Page With Builder'),
                    'class' => 'active'
                ],
            ],
            'enable_multi_lang'=>true
        ];
        return view('Page::admin.builder.detail', $data);
    }
}
