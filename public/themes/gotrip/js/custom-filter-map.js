$('.bravo_form_search').on('submit',function(e){
    e.preventDefault();
    window.reloadForm();
})
$(document).on('click','.term-item',function (){
    let term = $(this).attr('data-term');
    $(this).closest('.terms-item').find('.terms').val(term);
    window.reloadForm();
})
$('.btn-apply-price-range').on("click", function (e) {
    let parent = $(this).closest('.js-form-dd');
    parent.removeClass('-is-dd-wrap-active');
    parent.find('.dropRating').removeClass('-is-active');
    window.reloadForm();
})

$(document).on('click','.bravo-review-score .button',function (){
    let val = $(this).attr('data-value');
    if(!$(this).hasClass("checked")){
        $(this).parent().find('.review_score').val(val);
    }else{
        $(this).parent().find('.review_score').val('');
    }
    $(this).toggleClass("checked bg-blue-1 text-light-1");
    window.reloadForm();
})

$('.orderby .dropdown-item').on('click',function (e){
    e.preventDefault();
    $('[name=orderby]').val($(this).data('value'));
    $('.orderby .dropdown-toggle').html($(this).html());
    window.reloadForm();
})
