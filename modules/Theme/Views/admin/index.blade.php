@extends('Layout::admin.app')
@section("content")
    <div class="container">
        <div class="d-flex justify-content-between mb20">
            <h1 class="title-bar">{{ __('All Themes')}}</h1>
            <div class="title-actions">
            </div>
        </div>
        @include('admin.message')
        <div class="row">
            @foreach($rows as $theme_id=>$themeClass)
                <div class="col-md-4 mb-3">
                    <div class="card">
                        <img class="card-img-top" src="{{asset("themes/".$theme_id)}}{{$themeClass::$screenshot}}" alt="">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <h5 class="card-title">{{$themeClass::$name}}</h5>
                                <span class="badge badge-secondary">{{$themeClass::$version}}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    @if(\Modules\Theme\ThemeManager::current() == $theme_id)
                                        <form onsubmit="return confirm('{{__("Do you want to import all demo data?")}}')" action="{{route('theme.admin.seeding',['theme'=>$theme_id])}}" method="post">
                                            @csrf
                                            <button class="btn btn-warning"><i class="fa fa-magic"></i> {{__("Import Demo Data")}}</button>
                                            @if($time = $themeClass::lastSeederRun())
                                                <div>
                                                    <i>{{__('Last run: :date',['date'=>display_datetime($time)])}}</i>
                                                </div>
                                            @endif
                                        </form>
                                    @else
                                        <form action="{{route('theme.admin.activate',['theme'=>$theme_id])}}" method="post">
                                            @csrf
                                            <button class="btn btn-primary">{{__("Activate")}}</button>
                                        </form>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
