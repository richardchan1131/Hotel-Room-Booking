@extends('layouts.app')
@push('css')
    <link href="{{ asset('dist/frontend/module/news/css/news.css?_ver='.config('app.asset_version')) }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/daterange/daterangepicker.css") }}" >
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/ion_rangeslider/css/ion.rangeSlider.min.css") }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset("libs/fotorama/fotorama.css") }}" />
@endpush
@section('content')
<div class="bravo-news">
    @include('News::frontend.layouts.details.news-breadcrumb')
    <section data-anim="slide-up" class="layout-pt-md">
        <div class="container">
            <div class="row y-gap-40 justify-center text-center">
                <div class="col-auto">
                    <div class="text-15 fw-500 text-blue-1 mb-8">
                        @php $category = $row->category; @endphp
                        @if(!empty($category))
                            @php $t = $category->translate(); @endphp
                            {{$t->name ?? ''}}
                        @endif
                    </div>
                    <h1 class="text-30 fw-600">{{$translation->title}}</h1>
                    <div class="text-15 text-light-1 mt-10">{{ display_date($row->updated_at)}}</div>
                </div>
                <div class="col-12">
                    @if($image_url = get_file_url($row->image_id, 'full'))
                        <img src="{{ $image_url  }}" alt="{{$translation->title}}" class="col-12 rounded-8">
                    @endif
                </div>
            </div>
        </div>
    </section>
    <section data-anim="slide-up" class="layout-pt-md layout-pb-md">
        <div class="container">
            <div class="row y-gap-30 justify-center">
                <div class="col-xl-8 col-lg-10">
                    <div class="">
                        {!! $translation->content !!}
                        <div class="row y-gap-20 justify-between pt-30">
                            <div class="col-auto">
                                <div class="d-flex items-center">
                                    <div class="fw-500 mr-10">{{ __("Share") }}</div>
                                    <div class="d-flex items-center">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" original-title="{{__("Facebook")}}" class="flex-center size-40 rounded-full"><i class="icon-facebook text-14"></i></a>
                                        <a href="https://twitter.com/share?url={{$row->getDetailUrl()}}&amp;title={{$translation->title}}" target="_blank" original-title="{{__("Twitter")}}" class="flex-center size-40 rounded-full"><i class="icon-twitter text-14"></i></a>
                                        <a href="#" class="flex-center size-40 rounded-full"><i class="icon-instagram text-14"></i></a>
                                        <a href="#" class="flex-center size-40 rounded-full"><i class="icon-linkedin text-14"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <div class="row x-gap-10 y-gap-10">
                                    @if (!empty($tags = $row->getTags()) and count($tags) > 0)
                                        @foreach($tags as $tag)
                                            @php $t = $tag->translate(); @endphp
                                            <div class="col-auto">
                                                <a href="{{ $tag->getDetailUrl(app()->getLocale()) }}" class="button -blue-1 py-5 px-20 bg-blue-1-05 rounded-100 text-15 fw-500 text-blue-1">
                                                    {{$t->name ?? ''}}
                                                </a>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @if(!empty($row->user))
                        <div class="border-top-light border-bottom-light py-30 mt-30">
                            <div class="row y-gap-30">
                                <div class="col-auto">
                                    <img src="{{$row->author->avatar_url}}" alt="image" class="size-70 rounded-full">
                                </div>
                                <div class="col-md">
                                    <h3 class="text-18 fw-500">{{ $row->author->getDisplayName() }}</h3>
                                    <div class="text-14 text-light-1">{{ $row->author->city }}</div>
                                    <div class="text-15 mt-10">{{ $row->author->bio }}</div>
                                </div>
                            </div>
                        </div>
                    @endif


                </div>
            </div>
        </div>
    </section>
    @if(!empty($related))
        <section class="layout-pt-md layout-pb-lg">
        <div class="container">
            <div class="row justify-center text-center">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title">{{ __("Related content") }}</h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0">{{ __("Interdum et malesuada fames") }}</p>
                    </div>
                </div>
            </div>
            <div class="row y-gap-30 pt-40">
                @foreach( $related as $item)
                    <div class="col-lg-3 col-sm-6">
                        @php $item_translation = $item->translate();@endphp
                        <a href="" class="blogCard -type-2 d-block bg-white rounded-4 shadow-4">
                            <div class="blogCard__image">
                                <div class="ratio ratio-1:1 rounded-4">
                                    {!! get_image_tag($item->image_id,'medium',['class'=>'img-ratio rounded-4','alt'=>$item_translation->title,'lazy'=>false]) !!}
                                </div>
                            </div>
                            <div class="px-20 py-20">
                                <h4 class="text-dark-1 text-16 lh-18 fw-500">
                                    {!! clean($item_translation->title) !!}
                                </h4>
                                <div class="text-15 lh-16 text-light-1 mt-10 md:mt-5">
                                    {!! get_exceprt($translation->content,80,'...') !!}
                                </div>
                                <div class="text-light-1 text-15 lh-14 mt-10 text-right">
                                    {{ display_date($item->updated_at)}}
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
</div>
@endsection
