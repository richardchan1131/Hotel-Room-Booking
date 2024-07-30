<div class="row y-gap-20 pt-40">
    <div class="col-auto">
        <h2 class="">{{ __("What to know before visiting :text",['text'=>$translation->name]) }}</h2>
    </div>
    <p class="text-15 text-dark-1">
        {!! clean($translation->content) !!}
    </p>
</div>
