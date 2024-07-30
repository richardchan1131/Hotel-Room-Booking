<?php

namespace Modules\Template\Admin;

use Illuminate\Http\Request;
use Modules\AdminController;
use Modules\Page\Models\Page;
use Modules\Template\Models\Template;

class LiveEditorController extends AdminController
{
    private Page $page;
    private Template $template;

    public function __construct(Page $page, Template $template)
    {
        $this->page = $page;
        $this->template = $template;
    }

    public function index(Request $request, Template $template)
    {
        $translation = $template->translate($request->query('lang', get_main_lang()));
        $refLink = $refPreviewLink = '';
        switch ($request->query('ref')) {
            case "page":
                $page = $this->page::find($request->query('refId'));
                if ($page) {
                    $refLink = route('page.admin.edit', ['id' => $page->id]);
                    $refPreviewLink = $page->getDetailUrl();
                }
                break;
        }

        $data = [
            'page_title' => __('Live Editor'),
            'translation' => $translation,
            'row' => $template,
            'refLink' => $refLink,
            'refPreviewLink' => $refPreviewLink
        ];
        //dd($translation->content_json);
        return view('Template::admin.live.index', $data);
    }

    public function preview(Request $request)
    {
        $request->validate([
            'block' => 'required'
        ]);
        $block = $request->input('block');
        $model = $request->input('model', []);

        return $this->sendSuccess([
            'preview' => $this->template->getPreview($block, $model)
        ]);
    }
}
