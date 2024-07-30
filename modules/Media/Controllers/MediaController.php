<?php
namespace Modules\Media\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Modules\Media\Helpers\FileHelper;
use Modules\Media\Models\MediaFile;

class MediaController extends Controller
{
    public function preview($id, $size = 'thumb')
    {
        return redirect(FileHelper::url($id, $size));
    }

    public function privateFileStore(Request $request)
    {
        if(!$user_id = Auth::id()){
            return $this->sendError(__("Please log in"));
        }

        $fileName = 'file';

        $file = $request->file($fileName);

        try {
            $this->validatePrivateFile($file,$request->input('type','default'));
        } catch (\Exception $exception) {
            return $this->sendError($exception->getMessage());
        }

        $folder = 'private/'.$user_id.'/';
        $folder = $folder . date('Y/m/d');

        $newFileName = md5(microtime(true).rand(0,999));

        $i = 0;
        do {
            $newFileName2 = $newFileName . ($i ? $i : '');
            $testPath = $folder . '/' . $newFileName2 . '.' . $file->getClientOriginalExtension();
            $i++;
        } while (Storage::disk('local')->exists($testPath));

        $check = $file->storeAs( $folder, $newFileName2 . '.' . $file->getClientOriginalExtension(),'local');

        if ($check) {
            try {
                $path = str_replace('private/','',$check);
                return $this->sendSuccess(['data' => [
                    'path'=>$path,
                    'name'=>Str::slug($file->getClientOriginalName()),
                    'size'=>$file->getSize(),
                    'file_type'=>$file->getMimeType(),
                    'file_extension'=> $file->getClientOriginalExtension(),
                    'download'=>route('media.private.view',['path'=>$path]),
                ]]);

            } catch (\Exception $exception) {

                Storage::disk('local')->delete($check);

                return $this->sendError($exception->getMessage());
            }
        }
        return $this->sendError(__("Can not upload the file"));
    }

    /**
     * @param $file UploadedFile
     * @param $group string
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function validatePrivateFile($file, $group = "default")
    {
        $allowedExts = [
            'jpg',
            'jpeg',
            'bmp',
            'png',
            'gif',
            'zip',
            'rar',
            'pdf',
            'xls',
            'xlsx',
            'txt',
            'doc',
            'docx',
            'ppt',
            'pptx',
            'webm',
            'mp4',
            'mp3',
            'flv',
            'vob',
            'avi',
            'mov',
            'wmv',
        ];
        $allowedExtsImage = [
            'jpg',
            'jpeg',
            'bmp',
            'png',
            'gif',
        ];
        $allowedMimeTypes  = [];
        $uploadConfigs = [
            'default' => [
                'types'    => $allowedExts,
                "max_size" => 20000000,
                "max_width"=>2500,
                "max_height"=>2500,
                // 20MB
            ],
            'image'=>[
                'types'    => $allowedExtsImage,
                "max_size" => 20000000,
                "max_width"=>2500,
                "max_height"=>2500
            ]
        ];
        $config = isset($uploadConfigs[$group]) ? $uploadConfigs[$group] : $uploadConfigs['default'];

        if (!in_array(strtolower($file->getClientOriginalExtension()), $config['types'])) {
            throw new \Exception(__("File type are not allowed"));
        }
        if ($file->getSize() > $config['max_size']) {
            throw new \Exception(__("Maximum upload file size is :max_size B", ['max_size' => $config['max_size']]));
        }

        if(in_array($file_extension = strtolower($file->getClientOriginalExtension()), $allowedExtsImage)) {

            if (!empty($config['max_width']) or !empty($config['max_width'])) {
                $imagedata = getimagesize($file->getPathname());
                if (empty($imagedata)) {
                    throw new \Exception(__("Can not get image dimensions"));
                }
                if (!empty($config['max_width']) and $imagedata[0] > $config['max_width']) {
                    throw new \Exception(__("Maximum width allowed is: :number", ['number' => $config['max_width']]));
                }
                if (!empty($config['max_height']) and $imagedata[1] > $config['max_height']) {
                    throw new \Exception(__("Maximum height allowed is: :number", ['number' => $config['max_height']]));
                }
            }
        }

        return true;
    }

    public function privateFileView(){

        $path = 'private/'.\request()->get('path');

        if(Storage::disk('local')->exists($path)) {

            header('Content-Type: ' . mime_content_type(Storage::disk('local')->path($path)));

            echo Storage::disk('local')->get($path);
            exit;
        }

        abort(404);
    }

    public function editImage(Request $request){
        $validate = [
            'image'     => 'required',
            'image_id'  => 'required',
        ];
        $request->validate($validate);

        if (!Auth::user()->hasPermission("media_upload")) {
            $result = [
                'message' => __('403'),
                'status'=>0
            ];
            return $result;
        }

        $image_id = $request->input('image_id');
        $image_data = $request->input('image');

        $file = MediaFile::find($image_id);
        $res = $file->editImage($image_data);
        return $this->sendSuccess($res);
    }
}
