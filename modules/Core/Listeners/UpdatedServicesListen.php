<?php

    namespace Modules\Core\Listeners;

    use App\Notifications\AdminChannelServices;
    use App\Notifications\PrivateChannelServices;
    use App\User;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Log;
    use Modules\Core\Events\UpdatedServiceEvent;

    class UpdatedServicesListen
    {
        public function handle(UpdatedServiceEvent $event)
        {
            $services = $event->services;
            if(!empty($services)){
                $updatedBy = User::where('id',$services->update_user)->first();

                if(!empty($services->deleted_at)){
                    $message = __(':title has been deleted by :by', [
                        'title' => $services->title,
                        'status' => $services->status,
                        'by' => !empty($updatedBy) ? $updatedBy->display_name : Auth::user()->display_name
                    ]);
                }else{
                    $message = __(':title was updated to :status by :by', [
                        'title' => $services->title,
                        'status' => $services->status_text,
                        'by' => !empty($updatedBy) ? $updatedBy->display_name : Auth::user()->display_name
                    ]);
                }

                $data = [
                    'id'      => $services->id,
                    'event'   => 'UpdatedServiceEvent',
                    'to'      => 'admin',
                    'name'    => Auth::user()->display_name,
                    'avatar'  => Auth::user()->avatar_url,
                    'link'    => get_link_detail_services($services->type, $services->id, 'index'),
                    'type'    => $services->type,
                    'message' => $message
                ];
                // notify to admin
                Auth::user()->notify(new AdminChannelServices($data));
                // notify to vendor
                $vendor = User::where('id', $services->author_id)->where('status', 'publish')->first();
                if ($vendor and Auth::id() != $services->author_id) {
                    $data['to'] = 'vendor';
                    $data['link'] = get_link_vendor_detail_services($services->type, $services->id, 'index');
                    $vendor->notify(new PrivateChannelServices($data));
                }
            }

        }
    }
