@php $review_score = $row->review_data @endphp
@if(setting_item($row->type."_enable_review"))
    <section class="bravo-reviews" id="bravo-reviews">
        <div class="row y-gap-40 justify-between">
            <div class="col-xl-3">
                <h3 class="text-22 fw-500">{{__('Guest reviews')}}</h3>
                @if($review_score)
                    <div class="d-flex items-center mt-20">
                        <div class="flex-center bg-blue-1 rounded-4 size-70 text-22 fw-600 text-white">{{$review_score['score_total']}}</div>
                        <div class="ml-20">
                            <div class="text-16 text-dark-1 fw-500 lh-14">{{$review_score['score_text']}}</div>
                            <div class="text-15 text-light-1 lh-14 mt-4">
                                @if($review_score['total_review'] > 1)
                                    {{ __(":number reviews",["number"=>$review_score['total_review'] ]) }}
                                @else
                                    {{ __(":number review",["number"=>$review_score['total_review'] ]) }}
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="review-sumary">
                        @if($review_score['rate_score'])
                            <div class="row y-gap-20 pt-20">
                                @foreach($review_score['rate_score'] as $item)
                                    <div class="item col-12">
                                        <div class="">
                                            <div class="d-flex items-center justify-between">
                                                <div class="text-15 fw-500">{{$item['title']}}</div>
                                                <div class="text-15 text-light-1">{{$item['total']}}</div>
                                            </div>

                                            <div class="progressBar mt-10">
                                                <div class="progressBar__bg bg-blue-2"></div>
                                                <div class="progressBar__bar bg-blue-1" style="width: {{$item['percent']}}%"></div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            <div class="col-xl-8">
                @if($review_list)
                    <div class="review-list">
                        <div class="row y-gap-40">
                            @foreach($review_list as $item)
                                @php $userInfo = $item->author; $picture = $item->getReviewMetaPicture(); @endphp
                                <div class="col-12 review-item">
                                    <div class="row x-gap-20 y-gap-20 items-center">
                                        <div class="col-auto">
                                            @if($avatar_url = $userInfo->getAvatarUrl())
                                                <img class="avatar w-60 h-60 rounded-full" src="{{$avatar_url}}" alt="{{$userInfo->getDisplayName()}}">
                                            @else
                                                <span class="avatar-text w-60 h-60 rounded-full">{{ucfirst($userInfo->getDisplayName()[0])}}</span>
                                            @endif
                                        </div>
                                        <div class="col-auto">
                                            <div class="fw-500 lh-15">{{$userInfo->display_name}}</div>
                                            <div class="text-14 text-light-1 lh-15">{{display_datetime($item->created_at)}}</div>
                                        </div>
                                    </div>

                                    <h5 class="fw-500 text-blue-1 mt-20">{{$item->title}}</h5>
                                    <p class="text-15 text-dark-1 mt-10">{{$item->content}}</p>
                                    @if($item->rate_number)
                                        <ul class="review-star d-flex text-blue-1">
                                            @for( $i = 0 ; $i < 5 ; $i++ )
                                                @if($i < $item->rate_number)
                                                    <li class="me-1"><i class="fa fa-star"></i></li>
                                                @else
                                                    <li class="me-1"><i class="fa fa-star-o"></i></li>
                                                @endif
                                            @endfor
                                        </ul>
                                    @endif

                                    @if(!empty($picture))
                                        @php $listImages = json_decode($picture->val, true); @endphp
                                        <div class="row x-gap-30 y-gap-30 pt-20">
                                            @foreach($listImages as $oneImages)
                                                @php $imagesData = json_decode($oneImages, true); @endphp
                                                <div class="col-auto">
                                                    <img src="{{ $imagesData['download'] }}" alt="image" class="rounded-4">
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
                <div class="border-top-light mt-20 mb-20"></div>
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
            </div>
        </div>
        <div class="border-top-light pt-40 mt-40">
            @if(\Illuminate\Support\Facades\Auth::id())
                <div class="review-form">
                    <div class="form-wrapper">
                        @include('admin.message')
                        <form action="{{ route('review.store')}}" class="needs-validation" novalidate method="post">
                            @csrf
                            <div class="row y-gap-30 justify-between">
                                <div class="col-xl-3">
                                    <div class="row">
                                        <div class="col-auto">
                                            <h3 class="text-22 fw-500">{{__('Leave a Reply')}}</h3>
                                            <p class="text-15 text-dark-1 mt-5">{{ __('Your email address will not be published.') }}</p>
                                        </div>
                                    </div>

                                    @if($tour_review_stats = setting_item($row->type."_review_stats"))
                                        @php $tour_review_stats = json_decode($tour_review_stats) @endphp
                                        <div class="row y-gap-30 pt-30 review-items">
                                            @foreach($tour_review_stats as $item)
                                                <div class="col-sm-6">
                                                    <div class="item">
                                                        <div class="text-15 lh-1 fw-500">{{$item->title}}</div>
                                                        <input class="review_stats" type="hidden" name="review_stats[{{$item->title}}]">
                                                        <div class="rates d-flex x-gap-5 items-center pt-10">
                                                            <i class="fa fa-star-o grey"></i>
                                                            <i class="fa fa-star-o grey"></i>
                                                            <i class="fa fa-star-o grey"></i>
                                                            <i class="fa fa-star-o grey"></i>
                                                            <i class="fa fa-star-o grey"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                    @endif
                                </div>
                                <div class="col-xl-8">
                                    <form action="{{ route('review.store')}}" class="needs-validation" novalidate method="post">
                                        @csrf
                                        <div class="row y-gap-30">
                                            <div class="col-xl-12">
                                                <div class="form-input position-relative">
                                                    <input type="text" required name="review_title">
                                                    <label class="lh-1 text-16 text-light-1">{{__("Title")}}</label>
                                                    <div class="invalid-feedback">{{__('Review title is required')}}</div>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-input position-relative">
                                                    <textarea required rows="6" name="review_content"></textarea>
                                                    <label class="lh-1 text-16 text-light-1">{{__('Write Your Comment')}}</label>
                                                    <div class="invalid-feedback">{{__('Review content has at least 10 character')}}</div>
                                                </div>
                                            </div>
                                            @if(setting_item('review_upload_picture'))
                                                <div class="col-12">
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
                                                </div>
                                            @endif
                                            <div class="col-auto">
                                                <input type="hidden" name="review_service_id" value="{{$row->id}}">
                                                <input type="hidden" name="review_service_type" value="{{$row->type}}">
                                                <button type="submit" class="button -md -dark-1 bg-blue-1 text-white">
                                                    {{__('Post Comment')}} <div class="icon-arrow-top-right ml-15"></div>
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            @else
                <div class="review-message">
                    {!!  __("You must <a href='#login' data-bs-toggle='modal' data-target='#login'>log in</a> to write review") !!}
                </div>
            @endif
        </div>
    </section>
@endif
