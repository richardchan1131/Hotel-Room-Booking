<div class="carsSlider mt-40">
    <div class="carsSlider-slides js-cars-slides">
        @foreach($galleries as $key=>$item)
            @php if($key > 4) continue; @endphp
            <div class="carsSlider-slides__item rounded-4 @if($key == 0)-is-active @endif ">
                <img src="{{$item['thumb']}}" alt="{{ __("Gallery") }}">
            </div>
        @endforeach
    </div>
    <div class="carsSlider-slider">
        <div class="js-cars-slider">
            <div class="swiper-wrapper">
                @foreach($galleries as $key=>$item)
                    @php if($key > 4) continue; @endphp
                    <div class="swiper-slide">
                        <img src="{{$item['large']}}" data-alt="{{ __("Gallery") }}" class="rounded-4">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
