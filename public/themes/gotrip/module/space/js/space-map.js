function goTripReloadForm(url = ''){
    let action = window.location.href.split('?')[0];
    if (url) action = url;
    $('.map_loading').show();
    $.ajax({
        data:$('.bravo_form_search_map input,select,textarea,input:hidden[value!=""],#advance_filters input,select,textarea').serialize()+'&_ajax=1',
        url:action,
        dataType:'json',
        type:'get',
        success:function (json) {
            $('.map_loading').hide();
            if(json.status)
            {
                mapEngine.clearMarkers();
                mapEngine.addMarkers2(json.markers);
                $('.bravo-list-item').html(json.html);
                App.lazyLoading();
            }

        },
        error:function (e) {
            $('.map_loading').hide();
            if(e.responseText){
                $('.bravo-list-item').html('<p class="alert-text danger">'+e.responseText+'</p>')
            }
        }
    })
}

$('.bravo_form_search_map .bravo_form').submit(function (e){
    e.preventDefault();
    goTripReloadForm();
});

$('.btn-apply-price-range').on("click", function (e) {
    let parent = $(this).closest('.js-form-dd');
    parent.removeClass('-is-dd-wrap-active');
    parent.find('.dropRating').removeClass('-is-active');
    goTripReloadForm();
})

$(document).on('click','.bravo-review-score .button',function (){
    let val = $(this).attr('data-value');
    if(!$(this).hasClass("checked")){
        $(this).parent().find('.review_score').val(val);
    }else{
        $(this).parent().find('.review_score').val('');
    }
    $(this).toggleClass("checked bg-blue-1 text-light-1");
    goTripReloadForm();
})

$(document).on('click','.term-item',function (){
    let term = $(this).attr('data-term');
    $('.terms').val(term);
    goTripReloadForm();
})

$(document).on('click','.bravo-order .dropdown-item',function (){
    let order = $(this).attr('data-order');
    $('.orderby').val(order);
    goTripReloadForm();
})

$(document).on('click','.goTrip-bravo-pagination a',function (e) {
    e.preventDefault();
    goTripReloadForm($(this).attr('href'));
})
