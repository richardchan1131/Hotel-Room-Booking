<?php

namespace Modules\User\Controllers;

use App\User;
use Chatify\Facades\ChatifyMessenger as Chatify;
use App\Models\ChMessage as Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request as FacadesRequest;
use Illuminate\Support\Facades\Response;
use Modules\FrontendController;

class MessagesController extends \Chatify\Http\Controllers\MessagesController
{

    public function iframe($id = null)
    {
        if(!setting_item('inbox_enable')) abort(404);

        $routeName= FacadesRequest::route()->getName();
        $type = in_array($routeName, ['user','group'])
            ? $routeName
            : 'user';

        $tmpUser = $id ? User::find($id) : false;
        if ($tmpUser and $id != auth()->id()) {
            // Init first message
            $lastMessage = Chatify::getLastMessageQuery($id);
            if (!$lastMessage) {
                $mess = new Message();
                $mess->from_id = auth()->id();
                $mess->to_id = $id;
                $mess->save();
            }
        }


        return view('Chatify::pages.app', [
            'id' => $id ?? 0,
            'type' => $type ?? 'user',
            'messengerColor' => Auth::user()->messenger_color ?? $this->messengerFallbackColor,
            'dark_mode' => Auth::user()->dark_mode < 1 ? 'light' : 'dark',
        ]);
    }

    /**
     * Search in messenger
     *
     * @param Request $request
     * @return void
     */
    public function search(Request $request)
    {
        $getRecords = null;
        $input = trim(filter_var($request['input'], FILTER_SANITIZE_STRING));
        $records = \App\Models\User::where('id','!=',Auth::user()->id)
            ->where('name', 'LIKE', "%{$input}%")
            ->orWhere('first_name', 'LIKE', "%{$input}%")
            ->orWhere('email', 'LIKE', "%{$input}%")
            ->paginate($request->per_page ?? $this->perPage);
        foreach ($records->items() as $record) {
            $getRecords .= view('Chatify::layouts.listItem', [
                'get' => 'search_item',
                'type' => 'user',
                'user' => $record,
            ])->render();
        }
        if($records->total() < 1){
            $getRecords = '<p class="message-hint center-el"><span>Nothing to show.</span></p>';
        }
        // send the response
        return Response::json([
            'records' => $getRecords,
            'total' => $records->total(),
            'last_page' => $records->lastPage()
        ], 200);
    }

    /**
     * Get contacts list
     *
     * @param Request $request
     * @return JSON response
     */
    public function getContacts(Request $request)
    {
        $user_id = intval($request->query('user_id'));
        $tmpUser = $user_id ? User::find($user_id) : false;

        // get all users that received/sent message from/to [Auth user]
        $users = Message::join('users',  function ($join) {
            $join->on('ch_messages.from_id', '=', 'users.id')
                ->orOn('ch_messages.to_id', '=', 'users.id');
        })
            ->where(function ($q) {
                $q->where('ch_messages.from_id', Auth::user()->id)
                    ->orWhere('ch_messages.to_id', Auth::user()->id);
            })
            ->where('users.id','!=',Auth::user()->id)
            ->select('users.*',DB::raw('MAX(ch_messages.created_at) max_created_at'))
            ->orderBy('max_created_at', 'desc')
            ->groupBy('users.id')
            ->paginate($request->per_page ?? $this->perPage);

        $usersList = $users->items();

        if (count($usersList) > 0) {
            $contacts = '';
            foreach ($usersList as $user) {
                // Get user data
                $contacts .= Chatify::getContactItem($user);
            }
        }else{
            $contacts = '<p class="message-hint center-el"><span>Your contact list is empty</span></p>';
        }
        if($tmpUser and ($usersList or !in_array($user_id,$users->pluck('id')->all()))){
            $contacts = Chatify::getContactItem($tmpUser);
        }

        return Response::json([
            'contacts' => $contacts,
            'total' => $users->total() ?? 0,
            'last_page' => $users->lastPage() ?? 1,
        ], 200);
    }

    /**
     * Fetch data by id for (user/group)
     *
     * @param Request $request
     * @return collection
     */
    public function idFetchData(Request $request)
    {
        // Favorite
        $favorite = Chatify::inFavorite($request['id']);

        // User data
        if ($request['type'] == 'user') {
            $fetch = \App\Models\User::where('id', $request['id'])->first();
            if($fetch){
                $userAvatar = $fetch->avatar_url;
            }
        }

        // send the response
        return Response::json([
            'favorite' => $favorite,
            'fetch' => $fetch ?? [],
            'user_avatar' => $userAvatar ?? null,
        ]);
    }
}
