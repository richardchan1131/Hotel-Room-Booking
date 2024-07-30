// Form validation
var forms = document.getElementsByClassName('needs-validation');
// Loop over them and prevent submission
var validation = Array.prototype.filter.call(forms, function(form) {
    form.addEventListener('submit', function(event) {
        if (form.checkValidity() === false) {
            event.preventDefault();
            event.stopPropagation();
        }
        form.classList.add('was-validated');
    }, false);
});
//Login
$('.bravo-theme-gotrip-login-form [type=submit]').on("click", function (e) {
    e.preventDefault();
    let form = $(this).closest('.bravo-theme-gotrip-login-form');
    var redirect = form.find('input[name=redirect]').val();

    $.ajax({
        url: bookingCore.url + '/login',
        data: {
            'email': form.find('input[name=email]').val(),
            'password': form.find('input[name=password]').val(),
            'remember': form.find('input[name=remember]').is(":checked") ? 1 : '',
            'g-recaptcha-response': form.find('[name=g-recaptcha-response]').val(),
            'redirect':form.find('input[name=redirect]').val()
        },
        method: 'POST',
        beforeSend: function () {
            form.find('.error').hide();
            form.find('.icon-arrow-top-right').hide();
            form.find('.icon-loading').removeClass('d-none');
        },
        dataType:'json',
        success: function (data) {
            if(data.two_factor){
                return window.location.href = bookingCore.url + '/two-factor-challenge';
            }
            form.find('.icon-arrow-top-right').show();
            form.find('.icon-loading').addClass('d-none');
            if (data.error === true) {
                if (data.messages !== undefined) {
                    for(var item in data.messages) {
                        var msg = data.messages[item];
                        form.find('.error-'+item).show().text(msg[0]);
                    }
                }
                if (data.messages.message_error !== undefined) {
                    form.find('.message-error').show().html('<div class="alert alert-danger">' + data.messages.message_error[0] + '</div>');
                }
            }
            if(data.message){
                form.find('.message-error').show().html('<div class="alert alert-danger">' + data.message + '</div>');
            }
            if (typeof BravoReCaptcha !== 'undefined') {
                BravoReCaptcha.reset('login');
                BravoReCaptcha.reset('login_normal');

            }
            if(redirect.trim('/')){
                window.location.href = bookingCore.url_root + form.find('input[name=redirect]').val();
            }else{
                window.location.reload();
            }

        },
        error:function (e){
            form.find('.icon-arrow-top-right').show();
            form.find('.icon-loading').addClass('d-none');
            var html = ajax_error_to_string(e);
            if (typeof BravoReCaptcha !== 'undefined') {
                BravoReCaptcha.reset('login');
                BravoReCaptcha.reset('login_normal');

            }
            if(html){
                form.find('.message-error').show().html('<div class="alert alert-danger">' + html + '</div>');
            }
        }
    });
})
$("input[value!='']").addClass('has-value');

$(".mobile-footer .menu-item-has-children > a").on("click", function (e) {
    e.preventDefault();
    var p = $(this).parent();
    $(".mobile-footer .menu-item-has-children").not(p).find(".subnav").removeClass("active");
    p.find(".subnav").toggleClass("active")
})

$(document).ready(function () {
    'use strict';
    $(document).on("click",".searchMenu-loc .js-search-option",function (e){
        e.preventDefault();
        $(this).closest(".searchMenu-loc").addClass("has-val");
    });

    checkValueInput();

    function checkValueInput() {
        $(".searchMenu-loc").each(function () {
            let t = $(this);
            if(t.find(".js-search-get-id").val()){
                t.addClass("has-val");
            }
        })
    }

    $(".searchMenu-loc .clear-loc").on("click", function (e) {
        e.preventDefault();
        $(this).closest('.searchMenu-loc').removeClass("has-val").find("input").val('');
    })

    $(".gotrip-dropdown .menu-item-has-children > a").on("click", function (e) {
        e.preventDefault();
        let p = $(this).parent();
        $(".gotrip-dropdown .menu-item-has-children").not(p).removeClass("show");
        p.toggleClass("show");
    })

    $(".bravo-faq-lists .js-accordion .accordion__button").on("click", function (e) {
        e.preventDefault();
        const elements = document.querySelectorAll('.js-accordion .accordion__item');
        elements.forEach((element) => {
            element.querySelector('.accordion__content').removeAttribute('style');
            element.classList.remove('is-active');
        });
    })

    $(".gotrip-detail-book-mobile").click(function (){
        $('html, body').animate({
            scrollTop: $(".bravo_single_book").offset().top - 30
        }, 1000);
    });
    $(".gotrip-detail-hotel-book-mobile").click(function (){
        $('html, body').animate({
            scrollTop: $(".hotel_rooms_form").offset().top - 60
        }, 1000);
    });
})
