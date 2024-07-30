<?php

namespace Modules\News\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\FrontendController;
use Modules\Language\Models\Language;
use Modules\News\Models\News;
use Modules\News\Models\NewsCategory;
use Modules\News\Models\NewsTranslation;

class VendorNewsController extends FrontendController
{

    public function __construct()
    {
        $this->setActiveMenu(route('news.vendor.index'));
        parent::__construct();
    }

    public function index(Request $request)
    {
        $this->checkPermission('news_view');

        $dataNews = News::query()->where('author_id',auth()->id())->orderBy('id', 'desc');
        $post_name = $request->query('s');
        $cate = $request->query('cate_id');
        if ($cate) {
            $dataNews->where('cat_id', $cate);
        }
        if ($post_name) {
            $dataNews->where('title', 'LIKE', '%' . $post_name . '%');
            $dataNews->orderBy('title', 'asc');
        }

        $data = [
            'rows'        => $dataNews->with("author")->with("category")->paginate(20),
            'categories'  => NewsCategory::get(),
            'breadcrumbs' => [
                [
                    'name' => __('News'),
                    'url'  => route('news.vendor.index')
                ],
                [
                    'name'  => __('All'),
                    'class' => 'active'
                ],
            ],
            "languages"=>Language::getActive(false),
            "locale"=>\App::getLocale(),
            'page_title'=>__("News Management")
        ];
        return view('News::frontend.vendor.index', $data);
    }

    public function create(Request $request)
    {
        $this->checkPermission('news_create');
        $row = new News();
        $data = [
            'categories'        => NewsCategory::get()->toTree(),
            'row'         => $row,
            'breadcrumbs' => [
                [
                    'name' => __('News'),
                    'url'  => route('news.vendor.index')
                ],
                [
                    'name'  => __('Add News'),
                    'class' => 'active'
                ],
            ],
            'translation'=>new NewsTranslation()
        ];
        return view('News::frontend.vendor.detail', $data);
    }

    public function edit(Request $request, $id)
    {
        $this->checkPermission('news_update');

        $row = News::whereId($id)->whereCreateUser(auth()->id())->first();

        if (empty($row)) {
            return redirect(route('news.vendor.index'));
        }

        $translation = $row->translate($request->query('lang'));


        $data = [
            'row'  => $row,
            'translation'  => $translation,
            'categories' => NewsCategory::get()->toTree(),
            'tags' => $row->getTags(),
            'enable_multi_lang'=>true,
            'breadcrumbs' => [
                [
                    'name' => __('News'),
                    'url'  => route('news.vendor.index')
                ],
                [
                    'name'  => __('Edit: :name',['name'=>$row->title]),
                    'class' => 'active'
                ],
            ],
        ];
        return view('News::frontend.vendor.detail', $data);
    }

    public function store(Request $request, $id){
        if(is_demo_mode()){
            return redirect()->back()->with('danger',__("DEMO MODE: Disable update"));
        }
        $request->validate([
            'title'=>'required'
        ]);

        if($id>0){
            $this->checkPermission('news_update');
            $row = News::whereId($id)->whereCreateUser(auth()->id())->first();
            if (empty($row)) {
                return redirect(route('news.vendor.index'));
            }
        }else{
            $this->checkPermission('news_create');
            $row = new News();
            $row->author_id = auth()->id();
        }

        $old_status = $row->status;
        $row->fill($request->input());
        if($request->input('slug')){
            $row->slug = $request->input('slug');
        }
        if(setting_item('news_vendor_need_approve')){
            if($old_status != 'publish' and $row->status == 'publish'){
                $row->status = 'draft';
            }
        }

        $res = $row->saveOriginOrTranslation($request->query('lang'),true);

        if ($res) {
            if(is_default_lang($request->query('lang'))){
                $row->saveTag($request->input('tag_name'), $request->input('tag_ids'));
            }
            if($id > 0 ){
                return back()->with('success',  __('News updated') );
            }else{
                return redirect(route('news.vendor.edit',$row->id))->with('success', __('News created') );
            }
        }
    }

    public function bulkEdit(Request $request)
    {
        if(is_demo_mode()){
            return redirect()->back()->with('danger',__("DEMO MODE: Disable update"));
        }
        $this->checkPermission('news_update');
        $ids = $request->input('ids');
        $action = $request->input('action');
        if (empty($ids) or !is_array($ids)) {
            return redirect()->back()->with('error', __('No items selected!'));
        }
        $allowedActions = ['delete','draft','pending'];
        if(!setting_item('news_vendor_need_approve'))
        {
            $allowedActions[] = 'publish';
        }
        if (!in_array($action,$allowedActions)) {
            return redirect()->back()->with('error', __('Please select an action!'));
        }
        if ($action == "delete") {
            $this->checkPermission('news_delete');
            foreach ($ids as $id) {
                $query = News::where("id", $id);
                $query->where("create_user", Auth::id());

                $query->first();
                if(!empty($query)){
                    $query->delete();
                }
            }
        } else {
            $this->checkPermission('news_update');
            foreach ($ids as $id) {
                $query = News::where("id", $id);
                $query->where("create_user", Auth::id());

                $query->update(['status' => $action]);
            }
        }
        return redirect()->back()->with('success', __('Update success!'));
    }
}
