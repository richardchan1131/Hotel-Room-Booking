<?php
$replies = $row->replies()->orderByDesc('id')->paginate(10);

?>
<div class="all-answers">
    <h3 class="title">All Replies</h3>
    <div class="list-group">
        @foreach($replies as $reply)
            <div class="forum-comment list-group-item py-4">
                <div class="forum-post-top d-flex align-items-center">
                    <a class="author-avatar mr-3 flex-shrink-0" href="{{route('user.profile',['id'=>$reply->user->id])}}">
                        <img style="width:50px;" class="rounded-lg" src="{{$reply->user->avatar_url ?? ''}}" alt="author avatar">
                    </a>
                    <div class="reply-post-author">
                        <a
                            class="author-name text-16 font-weight-medium" href="{{route('user.profile',['id'=>$reply->user->id])}}"
                        >{{$reply->user->display_name}}</a>
                        <div class="reply-author-meta d-flex">
                            <div class="author-badge mr-2">
                                @if($reply->user)
                                    <div class="author-badge badge @if($reply->user_id === $row->customer_id) badge-info @else  badge-warning @endif">
                                        <i class="fa fa-shield"></i>
                                        <span class="">{{ucfirst($reply->user->role_name)}}</span>
                                    </div>
                                @endif
                            </div>
                            <div class="author-badge">
                                <i class="fa fa-clock-o"></i>
                                <span>{{human_time_diff(strtotime($reply->created_at))}} ago</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="comment-content pl-5 mt-2">
                    <div class="ml-3">
                        {!! clean($reply->content) !!}
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="pagination-wrapper">
        <div class="view-post-of"></div>
        <div class="post-pagination">
            {{$replies->appends(request()->query())->links()}}
        </div>
    </div>
</div>@include('Support::frontend.layouts.ticket.form-reply')
