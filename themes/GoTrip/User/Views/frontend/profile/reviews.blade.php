<?php
/**
 * Created by PhpStorm.
 * User: h2 gaming
 * Date: 8/17/2019
 * Time: 3:39 PM
 */
$reviews = \Modules\Review\Models\Review::query()->where([
    'vendor_id'=>$user->id,
    'status'=>'approved'
])
    ->orderBy('id','desc')
    ->with('author')
    ->paginate(3);
?>
@if($reviews->total())
    <div class="bravo-reviews">
        <h3>{{__('Reviews from guests')}}</h3>

        @if($reviews)
            <div class="review-list mt-20">
                <div class="row y-gap-40">
                    @foreach($reviews as $item)
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

        <div class="text-center mt-30"><a class="button h-50 px-24 -dark-1 bg-blue-1 text-white d-inline-flex" href="{{route('user.profile.reviews',['id'=> $user->user_name ?? $user->id])}}">{{__('View all reviews (:total)',['total'=>$reviews->total()])}}</a></div>
    </div>
@endif
