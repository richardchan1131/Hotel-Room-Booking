<?php

namespace Modules\Media\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Modules\FrontendController;
use Modules\Media\Models\MediaFile;
use Modules\Media\Models\MediaFolder;
use Modules\Media\Resources\FolderResource;

class FolderController extends FrontendController
{
    public $mediaFolder;

    public function __construct(MediaFolder $mediaFolder)
    {
        parent::__construct();
        $this->mediaFolder = $mediaFolder;
    }

    public function index(Request $request){
        $folders = $this->mediaFolder::query();
        if (!Auth::user()->hasPermission("media_manage_others")) {
            $folders->ofMine();
        }
        if($s = $request->query('parent_id')){
            $folders->where('parent_id',$s);
        }else{
            $folders->where('parent_id',0);
        }

        return FolderResource::collection($folders->paginate(1000));
    }
    public function store(Request $request){
        $id = $request->input('id');
        if(!$id){
            $folder = new MediaFolder();
            $folder->user_id = auth()->id();
        }else{
            $folder = MediaFolder::ofMine()->find($id);
            if(!$folder){
                return $this->sendError(__("You are not allowed to edit this folder"));
            }
        }

        $request->validate([
            'name'=>[
                    'required',
                    Rule::unique('media_folders')->where(function ($query) use($request) {
                        return $query->where('name', $request->input('name'))
                            ->where('parent_id', $request->input('parent_id',0))
                            ->where('id','!=', $request->input('id',0));
                    }),
                ]
        ],[
            'name.unique'=>__("Folder name exists, please select new one")
        ]);

        $folder->name = $request->input('name');
        $folder->parent_id = $request->input('parent_id',0);

        $folder->save();

        return $this->sendSuccess(['data'=>new FolderResource($folder)]);
    }

    public function delete(Request $request){
        $request->validate([
            'id'=>'required'
        ]);

        $id = $request->input('id');
        $folder = $this->mediaFolder::query();
        if (!Auth::user()->hasPermission("media_manage_others")) {
            $folder->ofMine();
        }
        $folder = $folder->find($id);
        if(!$folder){
            return $this->sendError(__("You are not allowed to delete this folder"));
        }

        MediaFile::query()->inFolder($folder->id)->delete();
        $folder->delete();

        return $this->sendSuccess(__("Folder deleted"));
    }
}
