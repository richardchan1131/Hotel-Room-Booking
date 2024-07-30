@php $translation = $row->translate();@endphp
<div class="row y-gap-30">
    <a href="{{$row->getDetailUrl()}}" class="blogCard -type-1 col-12">
        <div class="row y-gap-15 items-center md:justify-center md:text-center">
            <div class="col-auto">
                <div class="blogCard__image rounded-4">
                    <div class="ratio ratio-1:1 w-250">
                        {!! get_image_tag($row->image_id,'medium',['class'=>'img-ratio rounded-4','alt'=>$translation->title,'lazy'=>false]) !!}
                    </div>
                </div>
            </div>
            <div class="col-md">
                <div class="text-15 text-light-1">{{ display_date($row->updated_at)}}</div>
                <h3 class="text-22 text-dark-1 mt-10 md:mt-5">
                    {!! clean($translation->title) !!}
                </h3>
                <div class="text-15 lh-16 text-light-1 mt-10 md:mt-5">
                    {!! get_exceprt($translation->content) !!}
                </div>
            </div>
        </div>
    </a>
</div>
