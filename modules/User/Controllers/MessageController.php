<?php


namespace Modules\User\Controllers;


use App\Notifications\PrivateChannelServices;
use App\User;
use Chatify\Facades\ChatifyMessenger as Chatify;
use Chatify\Http\Controllers\MessagesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Str;

class MessageController extends MessagesController
{

    public function send(Request $request)
    {
        $version160 = method_exists(get_class(Chatify::getFacadeRoot()), 'parseMessage');
        // default variables
        $error = (object)[
            'status' => 0,
            'message' => null
        ];
        $attachment = null;
        $attachment_title = null;

        // if there is attachment [file]
        if ($request->hasFile('file')) {

            // allowed extensions
            $allowed_images = Chatify::getAllowedImages();
            $allowed_files  = Chatify::getAllowedFiles();
            $allowed        = array_merge($allowed_images, $allowed_files);

            $request->validate([
                'file' => 'required|mimes:'.implode(',',$allowed)
            ]);

            $file = $request->file('file');
            // if size less than 150MB
            if ($file->getSize() < Chatify::getMaxUploadSize()) {
                if (in_array($file->getClientOriginalExtension(), $allowed)) {
                    // get attachment name
                    $attachment_title = $file->getClientOriginalName();
                    // upload attachment and store the new name
                    $attachment = Str::uuid() . "." . $file->getClientOriginalExtension();
                    $file->storeAs("public/" . config('chatify.attachments.folder'), $attachment);
                } else {
                    $error->status = 1;
                    $error->message = "File extension not allowed!";
                }
            } else {
                $error->status = 1;
                $error->message = "File size you are trying to upload is too large!";
            }
        }

        if (!$error->status) {
            // send to database
            $messageID = mt_rand(9, 999999999) + time();
            $data = [
                'type' => $request['type'],
                'from_id' => Auth::user()->id,
                'to_id' => $request['id'],
                'body' => htmlentities(trim($request['message']), ENT_QUOTES, 'UTF-8'),
                'attachment' => ($attachment) ? json_encode((object)[
                    'new_name' => $attachment,
                    'old_name' => htmlentities(trim($attachment_title), ENT_QUOTES, 'UTF-8'),
                ]) : null,
            ];
            if(!$version160){
                $data['id'] = $messageID;
            }

            $message = Chatify::newMessage($data);

            // fetch message to send it with the response
            if($version160){
                $messageData = Chatify::parseMessage($message);
            }else{
                $messageData = Chatify::fetchMessage($messageID);
            }



            if (Auth::user()->id != $request['id']) {
                // send to user using pusher
                Chatify::push("private-chatify." . $request['id'], 'messaging', [
                    'from_id' => Auth::user()->id,
                    'to_id' => $request['id'],
                    'message' => Chatify::messageCard($messageData, true)
                ]);
            }

            $this->notifyUser($request,$messageData);
        }

        // send the response
        return Response::json([
            'status' => '200',
            'error' => $error,
            'message' => Chatify::messageCard(@$messageData),
            'tempID' => $request['temporaryMsgId'],
        ]);
    }

    protected function notifyUser(Request  $request,$message){
        $currentUser = auth()->user();

        $toUser = User::find($request->id);
        if(!$toUser) return;

        $message_content = __(':name send you message: :message', ['name' =>$currentUser->display_name, 'message' => Str::words($message['message'],6)]);
        if(empty($message['message']) and !empty($message['attachment'][0])){
            $message_content = __(':name send you file',['name' =>$currentUser->display_name]);
        }

        $data = [
            'id' =>  $message['id'],
            'event'=>'MessageSent',
            'to'=>'vendor',
            'name' =>  $currentUser->display_name,
            'avatar' => '',
            'link' => route('user.chat',['user_id'=>$currentUser->id]),
            'type' => 'chat',
            'message' => $message_content
        ];

        if($toUser){
            $toUser->notify(new PrivateChannelServices($data));
        }
    }
}
