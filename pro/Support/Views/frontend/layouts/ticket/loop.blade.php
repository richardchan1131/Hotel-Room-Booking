<a class="list-group-item list-group-item-action py-3" href="{{$ticket->getDetailUrl()}}">
    <div class="topic-item d-flex justify-content-between align-items-center">
        <div class="flex-grow-1">
            <h3 class="topic-name  text-16">
                <i class="fa fa-file-text-o mr-1"></i> {{$ticket->title}}
                @if($ticket->last_reply_by != auth()->id())
                    <i class="fa fa-info-circle" title="{{__("Need Response")}}" style="color: #ffc107;"></i>
                @endif
            </h3>
            <div class="ml-3 mt-2 topic-meta">
                @if(!empty($is_agent))
                    <span class="mr-1">
                        <i class="fa fa-user-o mr-1"></i> {{$ticket->customer->display_name ?? ''}}
                    </span>
                @endif
                @if($ticket->cat)
                    @php $cat_trans = $ticket->cat->translate() @endphp
                    <span class="mr-1">
                        <i class="fa fa-folder-o mr-1"></i> {{$cat_trans->name ?? ''}}</span>
                @endif
                @if($ticket->last_reply_at)
                    <span>
                        <i class="fa fa-clock-o"></i> {{human_time_diff($ticket->last_reply_at)}} ago
                    </span>
                @endif
            </div>
        </div>
        <div class="mr-3">
            @if($ticket->last_reply)
                {{$ticket->last_reply->display_name}}
            @endif
        </div>
        <div class="div">
            <span class="badge badge-{{$ticket->status_badge_class}}">{{$ticket->status_text}}</span>
        </div>
    </div>
</a>
