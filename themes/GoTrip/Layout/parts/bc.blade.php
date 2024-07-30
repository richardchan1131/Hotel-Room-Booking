@if(!empty($breadcrumbs))
    <div class="blog-breadcrumb py-10 bg-light-2">
        <div class="container">
            <div class="row y-gap-10 items-center justify-between">
                <div class="col-auto">
                    <ol class="pl-0 ul row x-gap-10 y-gap-5 items-center text-14 text-light-1 list-unstyled" itemscope itemtype="https://schema.org/BreadcrumbList">
                        <li class="col-auto" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a href="{{url('/')}}" itemprop="item"><span itemprop="name">{{__('Home')}}</span></a>
                            <meta itemprop="position" content="1" />
                        </li>
                        <li class="col-auto">
                            <div class="">></div>
                        </li>
                        @foreach($breadcrumbs as $k=>$breadcrumb)
                            @if($k)
                                <li class="col-auto">
                                    <div class="">></div>
                                </li>
                            @endif
                            <li class="col-auto {{$breadcrumb['class'] ?? ''}}" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                                @if(!empty($breadcrumb['url']))
                                    <a href="{{url($breadcrumb['url'])}}" itemscope itemtype="https://schema.org/WebPage" itemprop="item" itemid="{{url($breadcrumb['url'])}}"><span itemprop="name">{{$breadcrumb['name']}}</span></a>
                                @else
                                    <span itemprop="name" class="text-dark-1">{{$breadcrumb['name']}}</span>
                                @endif
                                <meta itemprop="position" content="{{$k + 2}}" />
                            </li>
                        @endforeach
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endif
