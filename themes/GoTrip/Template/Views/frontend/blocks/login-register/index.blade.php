@php
    $signinBtnClass = '-blue-1 text-blue-1 border-blue-1';
    $registerBtnClass = '-blue-1 bg-yellow-1 text-dark-1';
    if (!empty($style)){
        switch ($style){
            case 'style_1' : {
                $signinBtnClass = '-white bg-blue-1 text-white';
                $registerBtnClass = '-outline-blue-1 text-blue-1';
            } break;
        }
    }
@endphp
<section class="pt-80 pb-80 @if(empty($style)) bg-green-1 @endif">
    <div class="container">
        <div class="row y-gap-20 justify-between">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title">{{$title ?? ''}}</h2>
                    <p class="text-dark-1 sectionTitle__text mt-5 sm:mt-0">{{$sub_title ?? ''}}</p>
                </div>
            </div>

            <div class="col-auto">
                <div class="row x-gap-20 y-gap-20">
                    <div class="col-auto">
                        <a href="{{ url('/login') }}">
                            <button class="button px-40 h-60 {{$signinBtnClass}}">
                                {{__('Sign In')}}
                                <i class="icon-arrow-top-right ml-10"></i>
                            </button>
                        </a>
                    </div>

                    <div class="col-auto">
                        <a href="{{ url('/register') }}">
                            <button class="button px-40 h-60 {{$registerBtnClass}}">
                                {{__('Register')}}
                                <i class="icon-arrow-top-right ml-10"></i>
                            </button>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
