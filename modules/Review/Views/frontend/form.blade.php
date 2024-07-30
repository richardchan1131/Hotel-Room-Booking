@if(setting_item($row->type."_enable_review"))
    <div class="bravo-reviews" id="bravo-reviews">
        <h3>{{__("Reviews")}}</h3>
        @if($review_score)
            <div class="review-box">
                <div class="row">
                    <div class="col-lg-5">
                        <div class="review-box-score">
                            <div class="review-score">
                                {{$review_score['score_total']}}<span class="per-total">/5</span>
                            </div>
                            <div class="review-score-text">
                                {{$review_score['score_text']}}
                            </div>
                            <div class="review-score-base">
                                {{__("Based on")}}
                                <span>
                                    @if($review_score['total_review'] > 1)
                                        {{ __(":number reviews",["number"=>$review_score['total_review'] ]) }}
                                    @else
                                        {{ __(":number review",["number"=>$review_score['total_review'] ]) }}
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="review-sumary">
                            @if($review_score['rate_score'])
                                @foreach($review_score['rate_score'] as $item)
                                    <div class="item">
                                        <div class="label">
                                            {{$item['title']}}
                                        </div>
                                        <div class="progress">
                                            <div class="percent green" style="width: {{$item['percent']}}%"></div>
                                        </div>
                                        <div class="number">{{$item['total']}}</div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <div class="review-list">
            @if($review_list)
                @foreach($review_list as $item)
                    @php $userInfo = $item->author; $picture = $item->getReviewMetaPicture(); @endphp
                    <div class="review-item">
                        <div class="review-item-head">
                            <div class="media">
                                <div class="media-left">
                                    @if($avatar_url = $userInfo->getAvatarUrl())
                                        <img class="avatar" src="{{$avatar_url}}" alt="{{$userInfo->getDisplayName()}}">
                                    @else
                                        <span class="avatar-text">{{ucfirst($userInfo->getDisplayName()[0])}}</span>
                                    @endif
                                </div>
                                <div class="media-body">
                                    <h4 class="media-heading">{{$userInfo->getDisplayName()}}</h4>
                                    <div class="date">{{display_datetime($item->created_at)}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="review-item-body">
                            <h4 class="title"> {{$item->title}} </h4>
                            @if($item->rate_number)
                                <ul class="review-star">
                                    @for( $i = 0 ; $i < 5 ; $i++ )
                                        @if($i < $item->rate_number)
                                            <li><i class="fa fa-star"></i></li>
                                        @else
                                            <li><i class="fa fa-star-o"></i></li>
                                        @endif
                                    @endfor
                                </ul>
                            @endif
                            <div class="detail">
                                {{$item->content}}
                            </div>
                        </div>
                        @if(!empty($picture))
                            @php $listImages = json_decode($picture->val, true); @endphp
                        <div class="review_upload_photo_list row mt-3">
                            @foreach($listImages as $oneImages)
                                @php $imagesData = json_decode($oneImages, true); @endphp
                                <div class="col-md-2 mb-2">
                                    <div class="review_upload_item" data-toggle="modal" data-target="#modal_room_{{$item->id}}" style="background-image: url({{@$imagesData['download']}});">
                                    </div>
                                </div>
                            @endforeach
                                <div class="modal" id="modal_room_{{$item->id}}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <div class="fotorama" data-nav="thumbs" data-width="100%" data-auto="true" data-allowfullscreen="true">
                                                    @foreach($listImages as $oneImages)
                                                        @php $imagesData = json_decode($oneImages, true); @endphp
                                                        <a class="w-100" href="{{@$imagesData['download']}}"></a>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        @endif
                    </div>
                @endforeach
            @endif
        </div>
        <div class="review-pag-wrapper">
            @if($review_list->total() > 0)
                <div class="bravo-pagination">
                    {{$review_list->appends(request()->query())->fragment('review-list')->links()}}
                </div>
                <div class="review-pag-text">
                    {{ __("Showing :from - :to of :total total",["from"=>$review_list->firstItem(),"to"=>$review_list->lastItem(),"total"=>$review_list->total()]) }}
                </div>
            @else
                <div class="review-pag-text">{{__("No Review")}}</div>
            @endif
        </div>
        @if(Auth::id())
            <div class="review-form">
                <div class="title-form">
                    {{__("Write a review")}}
                </div>
                <div class="form-wrapper">
                    @include('admin.message')
                    <form action="{{ route('review.store')}}" class="needs-validation" novalidate method="post">
                        @csrf
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input type="text" required class="form-control" name="review_title" placeholder="{{__("Title")}}">
                                    <div class="invalid-feedback">{{__('Review title is required')}}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 col-md-8">
                                <div class="form-group">
                                    <textarea name="review_content" required class="form-control" placeholder="{{__("Review content")}}" minlength="10"></textarea>
                                    <div class="invalid-feedback">
                                        {{__('Review content has at least 10 character')}}
                                    </div>
                                </div>
                            </div>
                            @if($tour_review_stats = setting_item($row->type."_review_stats"))
                                @php $tour_review_stats = json_decode($tour_review_stats) @endphp
                                <div class="col-xs-12 col-md-4">
                                    <div class="form-group review-items">
                                        @foreach($tour_review_stats as $item)
                                            <div class="item">
                                                <label>{{$item->title}}</label>
                                                <input class="review_stats" type="hidden" name="review_stats[{{$item->title}}]">
                                                <div class="rates">
                                                    <i class="fa fa-star-o grey"></i>
                                                    <i class="fa fa-star-o grey"></i>
                                                    <i class="fa fa-star-o grey"></i>
                                                    <i class="fa fa-star-o grey"></i>
                                                    <i class="fa fa-star-o grey"></i>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @else
                                <div class="col-xs-12 col-md-4">
                                    <div class="form-group review-items">
                                        <div class="item">
                                            <label>{{__("Review rate")}}</label>
                                            <input class="review_stats" type="hidden" name="review_rate">
                                            <div class="rates">
                                                <i class="fa fa-star-o grey"></i>
                                                <i class="fa fa-star-o grey"></i>
                                                <i class="fa fa-star-o grey"></i>
                                                <i class="fa fa-star-o grey"></i>
                                                <i class="fa fa-star-o grey"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                        @if(setting_item('review_upload_picture'))
                            <div class="review_upload_wrap">
                                <div class="mb-3"><i class="fa fa-camera"></i> {{__('Add photo')}}</div>

                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="review_upload_btn">
                                            <span class="helpText" id="helpText"></span>
                                            <input type="file" id="file" multiple data-name="review_upload" data-multiple="1" accept="image/*" class="review_upload_file">
                                        </div>
                                    </div>
                                    <div class="col-md-10">
                                        <div class="review_upload_photo_list row"></div>
                                    </div>
                                </div>


                            </div>
                        @endif
                        <div class="text-center">
                            <input type="hidden" name="review_service_id" value="{{$row->id}}">
                            <input type="hidden" name="review_service_type" value="{{$row->type}}">
                            <input id="submit" type="submit" name="submit" class="btn" value="{{__("Leave a Review")}}">
                        </div>
                    </form>
                </div>
            </div>
        @endif
        @if(!Auth::id())
            <div class="review-message">
                {!!  __("You must <a href='#login' data-toggle='modal' data-target='#login'>log in</a> to write review") !!}
            </div>
        @endif
    </div>
@endif
