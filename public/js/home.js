jQuery(function ($) {
    $.fn.bravoAutocomplete = function (options) {
        var key = typeof options.key != 'undefined' ? options.key : 'id'
        return this.each(function () {
            var $this = $(this);
            var main = $(this).closest(".smart-search");
            var textLoading = options.textLoading;
            main.append('<div class="bravo-autocomplete on-message"><div class="list-item"></div><div class="message">'+textLoading+'</div></div>');
            $(document).on("click.Bst", function(event){
                if (main.has(event.target).length === 0 && !main.is(event.target)) {
                    main.find('.bravo-autocomplete').removeClass('show');
                } else {
                    if (options.dataDefault.length > 0) {
                        main.find('.bravo-autocomplete').addClass('show');
                    }
                }
            });
            if (options.dataDefault.length > 0) {
                var items = '';
                for (var index in options.dataDefault) {
                    var item = options.dataDefault[index];
                    items += '<div class="item" data-id="' + item[key] + '" data-text="' + item.title + '"> <i class="'+options.iconItem+'"></i> ' + item.title + ' </div>';
                }
                main.find('.bravo-autocomplete .list-item').html(items);
                main.find('.bravo-autocomplete').removeClass("on-message");
            }
            var requestTimeLimit;
            if(typeof options.url !='undefined' && options.url) {
                $this.keyup(function () {
                    main.find('.bravo-autocomplete').addClass("on-message");
                    main.find('.bravo-autocomplete .message').html(textLoading);
                    main.find('.child_id').val("");
                    var query = $(this).val();
                    clearTimeout(requestTimeLimit);
                    if (query.length === 0) {
                        if (options.dataDefault.length > 0) {
                            var items = '';
                            for (var index in options.dataDefault) {
                                var item = options.dataDefault[index];
                                items += '<div class="item" data-id="' + item[key] + '" data-text="' + item.title + '"> <i class="' + options.iconItem + '"></i> ' + item.title + ' </div>';
                            }
                            main.find('.bravo-autocomplete .list-item').html(items);
                            main.find('.bravo-autocomplete').removeClass("on-message");
                        } else {
                            main.find('.bravo-autocomplete').removeClass('show');
                        }
                        return;
                    }
                    requestTimeLimit = setTimeout(function () {
                        $.ajax({
                            url: options.url,
                            data: {
                                search: query,
                            },
                            dataType: 'json',
                            type: 'get',
                            beforeSend: function () {
                            },
                            success: function (res) {
                                if (res.status === 1) {
                                    var items = '';
                                    for (var ix in res.data) {
                                        var item = res.data[ix];
                                        items += '<div class="item" data-id="' + item[key] + '" data-text="' + item.title + '"> <i class="' + options.iconItem + '"></i> ' + get_highlight(item.title, query) + (item.desc ? '<span class="item-desc">'+item.desc+'</span>' : '') +' </div>';
                                    }
                                    main.find('.bravo-autocomplete .list-item').html(items);
                                    main.find('.bravo-autocomplete').removeClass("on-message");
                                }
                                if ( typeof res.message === undefined) {
                                    main.find('.bravo-autocomplete').addClass("on-message");
                                }else{
                                    main.find('.bravo-autocomplete .message').html(res.message);
                                }
                            }
                        })
                    }, 700);

                    function get_highlight(text, val) {
                        return text.replace(
                            new RegExp(val + '(?!([^<]+)?>)', 'gi'),
                            '<span class="h-line">$&</span>'
                        );
                    }

                    main.find('.bravo-autocomplete').addClass('show');
                });
            }
            main.find('.bravo-autocomplete').on('click','.item',function () {
                var id = $(this).attr('data-id'),
                    text = $(this).attr('data-text');
                if(id.length > 0 && text.length > 0){
                    text = text.replace(/-/g, "");
                    //text = text.substring(1);
                    text = trimFunc(text,' ');
                    text = trimFunc(text,'-');
                    main.find('.parent_text').val(text).trigger("change");
                    main.find('.child_id').val(id).trigger("change");
                }else{
                    console.log("Cannot select!")
                }
                setTimeout(function () {
                    main.find('.bravo-autocomplete').removeClass('show');
                },100);
            });

            var trimFunc = function (s, c) {
                if (c === "]") c = "\\]";
                if (c === "\\") c = "\\\\";
                return s.replace(new RegExp(
                    "^[" + c + "]+|[" + c + "]+$", "g"
                ), "");
            }
        });
    };
});

jQuery(function ($) {
    function parseErrorMessage(e){
        var html = '';
        if(e.responseJSON){
            if(e.responseJSON.errors){
                return Object.values(e.responseJSON.errors).join('<br>');
            }
        }
        return html;
    }
    $(".g-map-place").each(function () {
        var map = $(this).find('.map').attr('id');
        var searchInput =  $(this).find('input[name=map_place]');
        var latInput = $(this).find('input[name="map_lat"]');
        var lgnInput = $(this).find('input[name="map_lgn"]');
        new BravoMapEngine(map, {
            fitBounds: true,
            center: [ 51.505, -0.09],
            ready: function (engineMap) {
            engineMap.searchBox(searchInput,function (dataLatLng) {
                latInput.attr("value", dataLatLng[0]);
                lgnInput.attr("value", dataLatLng[1]);
            });
        }
    });

    });


    $(".bravo-form-search-slider .effect").each(function () {
        $(this).find(".owl-carousel").owlCarousel({
            items: 1,
            loop: true,
            margin: 0,
            nav: false,
            autoplay:true,
            autoplayTimeout:5000,
            autoplayHoverPause:false,
            animateOut: 'fadeOut'
        })
    });

    $(".bravo-form-search-all.carousel_v2").each(function () {
        $(this).find(".owl-carousel").owlCarousel({
            items: 1,
            loop: true,
            margin: 0,
            nav: false,
            autoplay:true,
            autoplayTimeout:5000,
            autoplayHoverPause:false,
            animateOut: 'fadeOut'
        })
    });


    $(".bravo-form-search-tour.carousel_v2  .effect").each(function () {
        $(this).find(".owl-carousel").owlCarousel({
            items: 1,
            loop: true,
            margin: 0,
            nav: false,
            autoplay:true,
            autoplayTimeout:5000,
            autoplayHoverPause:false,
            animateOut: 'fadeOut'
        })
    });

    $(".bravo-list-tour.carousel").each(function () {
        $(this).find(".owl-carousel").owlCarousel({
            items: 4,
            loop: false,
            margin: 15,
            nav: false,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }
        })
    });
    $(".bravo-box-category-tour").each(function () {
        $(this).find(".owl-carousel").owlCarousel({
            items: 4,
            loop: true,
            margin: 30,
            nav: false,
            dots: true,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }
        })
    });

    $(".bravo-client-feedback").each(function () {
        $(this).find(".owl-carousel").owlCarousel({
            items: 1,
            loop: true,
            margin: 0,
            nav: true,
            dots: false,
        })
    });

    $(".bravo-list-tour.carousel_simple").each(function () {
        $(this).find(".owl-carousel").owlCarousel({
            items: 3,
            loop: false,
            margin: 15,
            nav: false,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        })
    });

    $(".bravo-list-space").each(function () {
        $(this).find(".owl-carousel").owlCarousel({
            items: 3,
            loop: false,
            margin: 15,
            nav: false,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 3
                }
            }
        })
    });

    $(".bravo-list-hotel").each(function () {
        $(this).find(".owl-carousel").owlCarousel({
            items: 4,
            loop: false,
            margin: 15,
            nav: false,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }
        })
    });

    $(".bravo-list-car").each(function () {
        $(this).find(".owl-carousel").owlCarousel({
            items: 4,
            loop: false,
            margin: 15,
            nav: false,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }
        })
    });
    $(".bravo-list-boat").each(function () {
        $(this).find(".owl-carousel").owlCarousel({
            items: 4,
            loop: false,
            margin: 15,
            nav: false,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }
        })
    });
    $(".bravo-list-event").each(function () {
        $(this).find(".owl-carousel").owlCarousel({
            items: 4,
            loop: false,
            margin: 15,
            nav: false,
            responsive: {
                0: {
                    items: 1
                },
                768: {
                    items: 2
                },
                1000: {
                    items: 4
                }
            }
        })
    });

    $(".bravo_fullHeight").each(function () {
        var height = $(document).height();
        if ($(document).find(".bravo-admin-bar").length > 0) {
            height = height - $(".bravo-admin-bar").height();
        }
        $(this).css('min-height', height);
    });

    // Date Picker Range
    $('.form-date-search').each(function () {
        var single_picker = false;
        if($(this).hasClass("is_single_picker")){
            single_picker = true;
        }
        var nowDate = new Date();
        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
        var parent = $(this),
            date_wrapper = $('.date-wrapper', parent),
            check_in_input = $('.check-in-input', parent),
            check_out_input = $('.check-out-input', parent),
            check_in_out = $('.check-in-out', parent),
            check_in_render = $('.check-in-render', parent),
            check_out_render = $('.check-out-render', parent);
        var options = {
            singleDatePicker: single_picker,
            autoApply: true,
            disabledPast: true,
            customClass: '',
            widthSingle: 300,
            onlyShowCurrentMonth: true,
            minDate: today,
            opens: bookingCore.rtl ? 'right':'left',
            locale: {
                format: "YYYY-MM-DD",
                direction: bookingCore.rtl ? 'rtl':'ltr',
                firstDay:daterangepickerLocale.first_day_of_week
            }
        };
        if (typeof  daterangepickerLocale == 'object') {
            options.locale = _.merge(daterangepickerLocale,options.locale);
        }
        check_in_out.daterangepicker(options,
            function (start, end, label) {
                check_in_input.val(start.format(bookingCore.date_format));
                check_in_render.html(start.format(bookingCore.date_format));
                check_out_input.val(end.format(bookingCore.date_format));
                check_out_render.html(end.format(bookingCore.date_format));
            });
        date_wrapper.click(function (e) {
            check_in_out.trigger('click');
        });
    });

    // Date Picker
    $('.date-picker').each(function () {
        var options = {
            "singleDatePicker": true,
            opens: bookingCore.rtl ? 'right':'left',
            locale: {
                format: bookingCore.date_format,
                direction: bookingCore.rtl ? 'rtl':'ltr',
                firstDay:daterangepickerLocale.first_day_of_week
            }
        };
        if (typeof  daterangepickerLocale == 'object') {
            options.locale = _.merge(daterangepickerLocale,options.locale);
        }
        $(this).daterangepicker(options);
    });

    // Date Picker Range for hotel
    $('.form-date-search-hotel').each(function () {
        var nowDate = new Date();
        var today = new Date(nowDate.getFullYear(), nowDate.getMonth(), nowDate.getDate(), 0, 0, 0, 0);
        var parent = $(this),
            date_wrapper = $('.date-wrapper', parent),
            check_in_input = $('.check-in-input', parent),
            check_out_input = $('.check-out-input', parent),
            check_in_out = $('.check-in-out', parent),
            check_in_render = $('.check-in-render', parent),
            check_out_render = $('.check-out-render', parent);
        var options = {
            singleDatePicker: false,
            autoApply: true,
            disabledPast: true,
            customClass: '',
            widthSingle: 300,
            onlyShowCurrentMonth: true,
            minDate: today,
            opens: bookingCore.rtl ? 'right':'left',
            locale: {
                format: "YYYY-MM-DD",
                direction: bookingCore.rtl ? 'rtl':'ltr',
                firstDay:daterangepickerLocale.first_day_of_week
            }
        };

        if (typeof  daterangepickerLocale == 'object') {
            options.locale = _.merge(daterangepickerLocale,options.locale);
        }
        check_in_out.daterangepicker(options).on('apply.daterangepicker',
            function (ev, picker) {
                if (picker.endDate.diff(picker.startDate, 'day') <= 0) {
                    picker.endDate.add(1, 'day');
                }
                check_in_input.val( picker.startDate.format(bookingCore.date_format) );
                check_in_render.html( picker.startDate.format(bookingCore.date_format) );
                check_out_input.val( picker.endDate.format(bookingCore.date_format) );
                check_out_render.html( picker.endDate.format(bookingCore.date_format) );
                check_in_out.val( picker.startDate.format("YYYY-MM-DD") + " - "+  picker.endDate.format("YYYY-MM-DD") )
            });
        date_wrapper.click(function (e) {
            check_in_out.trigger('click');
        });
    });

    //Review
    $('.review-form .review-items .rates .fa').each(function () {
        var list = $(this).parent(),
            listItems = list.children(),
            itemIndex = $(this).index(),
            parentItem = list.parent();
        $(this).hover(function () {
            for (var i = 0; i < listItems.length; i++) {
                if (i <= itemIndex) {
                    $(listItems[i]).addClass('hovered');
                } else {
                    break;
                }
            }
            $(this).click(function () {
                for (var i = 0; i < listItems.length; i++) {
                    if (i <= itemIndex) {
                        $(listItems[i]).addClass('selected');
                    } else {
                        $(listItems[i]).removeClass('selected');
                    }
                }
                parentItem.children('.review_stats').val(itemIndex + 1);
            });
        }, function () {
            listItems.removeClass('hovered');
        });
    });
    window.ajax_error_to_string =  function(e){
        if(typeof e.responseJSON !== 'undefined'){
            if(e.responseJSON.errors){
                var html = [];
                for(var k in e.responseJSON.errors){
                    html.push(e.responseJSON.errors[k].join("<br/>"));
                }

                return html.join("<br/>");
            }

            if(e.responseJSON.message){
                return e.responseJSON.message;
            }
        }
    }
    //Login
    $('.bravo-form-login [type=submit]').click(function (e) {
        e.preventDefault();
        let form = $(this).closest('.bravo-form-login');
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
                form.find('.icon-loading').css("display", 'inline-block');
            },
            dataType:'json',
            success: function (data) {
                if(data.two_factor){
                    return window.location.href = bookingCore.url + '/two-factor-challenge';
                }
                form.find('.icon-loading').hide();
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
                form.find('.icon-loading').hide();
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
    $('.bravo-form-register [type=submit]').click(function (e) {
        e.preventDefault();
        let form = $(this).closest('.bravo-form-register');
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': form.find('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            'url':  bookingCore.routes.register,
            'data': {
                'email': form.find('input[name=email]').val(),
                'password': form.find('input[name=password]').val(),
                'first_name': form.find('input[name=first_name]').val(),
                'last_name': form.find('input[name=last_name]').val(),
                'phone': form.find('input[name=phone]').val(),
                'term': form.find('input[name=term]').is(":checked") ? 1 : '',
                'g-recaptcha-response': form.find('[name=g-recaptcha-response]').val(),
            },
            'type': 'POST',
            beforeSend: function () {
                form.find('.error').hide();
                form.find('.icon-loading').css("display", 'inline-block');
            },
            success: function (data) {
                form.find('.icon-loading').hide();
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
                if (typeof BravoReCaptcha !== 'undefined') {
                    BravoReCaptcha.reset('register');
                    BravoReCaptcha.reset('register_normal');
                }
                if (data.redirect !== undefined) {
                    window.location.href = data.redirect
                }
            },
            error:function (e) {
                form.find('.icon-loading').hide();
                if(typeof e.responseJSON !== "undefined" && typeof e.responseJSON.message !='undefined'){
                    form.find('.message-error').show().html('<div class="alert alert-danger">' + e.responseJSON.message + '</div>');
                }

                if (typeof BravoReCaptcha !== 'undefined') {
                    BravoReCaptcha.reset('register');
                    BravoReCaptcha.reset('register_normal');
                }
            }
        });
    })
    $('#register').on('show.bs.modal', function (event) {
        $('#login').modal('hide')
    })
    $('#login').on('show.bs.modal', function (event) {
        $('#register').modal('hide')
    });

    var onSubmitSubscribe = false;
    //Subscribe box
    $('.bravo-subscribe-form').submit(function (e) {
        e.preventDefault();

        if (onSubmitSubscribe) return;

        $(this).addClass('loading');
        var me = $(this);
        me.find('.form-mess').html('');

        $.ajax({
            url: me.attr('action'),
            type: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (json) {
                onSubmitSubscribe = false;
                me.removeClass('loading');

                if (json.message) {
                    me.find('.form-mess').html('<span class="' + (json.status ? 'text-success' : 'text-danger') + '">' + json.message + '</span>');
                }

                if (json.status) {
                    me.find('input').val('');
                }

            },
            error: function (e) {
                console.log(e);
                onSubmitSubscribe = false;
                me.removeClass('loading');

                if(parseErrorMessage(e)){
                    me.find('.form-mess').html('<span class="text-danger">' + parseErrorMessage(e) + '</span>');
                }else
                if (e.responseText) {
                    me.find('.form-mess').html('<span class="text-danger">' + e.responseText + '</span>');
                }

            }
        });

        return false;
    });

    //Menu
    $(".bravo-more-menu").click(function () {
        $(this).trigger('bravo-trigger-menu-mobile');
    });
    $(".bravo-menu-mobile .b-close").click(function () {
        $(".bravo-more-menu").trigger('bravo-trigger-menu-mobile');
    });
    $(document).on("click",".bravo-effect-bg",function () {
        $(".bravo-more-menu").trigger('bravo-trigger-menu-mobile');
    })
    $(document).on("bravo-trigger-menu-mobile",".bravo-more-menu",function () {
        $(this).toggleClass('active');
        if($(this).hasClass('active')){
            $(".bravo-menu-mobile").addClass("active");
            $('body').css('overflow','hidden').append("<div class='bravo-effect-bg'></div>");
        }else{
            $(".bravo-menu-mobile").removeClass("active");
            $("body").css('overflow','initial').find(".bravo-effect-bg").remove();
        }
    });
    $(".bravo-menu-mobile .g-menu ul li .fa").click(function (e) {
        e.preventDefault();
        $(this).closest('li').toggleClass('active');
    });
    $(".bravo-menu-mobile").each(function () {
        var h_profile = $(this).find(".user-profile").height();
        var h1_main = $(window).height();
        $(this).find(".g-menu").css("max-height", h1_main - h_profile - 15);
    });

    $(".bravo-more-menu-user").click(function () {
        $(".bravo_user_profile > .container-fluid > .row > .col-md-3").addClass("active");
        $("body").css('overflow','hidden').append("<div class='bravo-effect-user-bg'></div>");
    });
    $(document).on("click",".bravo-effect-user-bg,.bravo-close-menu-user",function () {
        $(".bravo_user_profile > .container-fluid > .row > .col-md-3").removeClass("active");
        $('body').css('overflow','initial').find(".bravo-effect-user-bg").remove();
    })

    $('[data-toggle="tooltip"]').tooltip();

    $('.dropdown-toggle').dropdown();

    $('.select-guests-dropdown .btn-minus').click(function(e){
        e.stopPropagation();
        var parent = $(this).closest('.form-select-guests');
        var input = parent.find('.select-guests-dropdown [name='+$(this).data('input')+']');
        var min = parseInt(input.attr('min'));
        var old = parseInt(input.val());

        if(old <= min){
            return;
        }
        input.val(old-1);
        updateGuestCountText(parent);
    });

    $('.select-guests-dropdown .btn-add').click(function(e){
        e.stopPropagation();
        var parent = $(this).closest('.form-select-guests');
        var input = parent.find('.select-guests-dropdown [name='+$(this).data('input')+']');
        var max = parseInt(input.attr('max'));
        var old = parseInt(input.val());

        if(old >= max){
            return;
        }
        input.val(old+1);
        updateGuestCountText(parent);
    });

    $('.select-guests-dropdown input').keyup(function(e){
        var parent = $(this).closest('.form-select-guests');
        updateGuestCountText(parent);
    });
    $('.select-guests-dropdown input').change(function(e){
        var parent = $(this).closest('.form-select-guests');
        updateGuestCountText(parent);
    });

    function updateGuestCountText(parent){
        var adults = parseInt(parent.find('[name=adults]').val());
        var children = parseInt(parent.find('[name=children]').val());

        var adultsHtml = parent.find('.render .adults .multi').data('html');
        console.log(parent,adultsHtml);
        parent.find('.render .adults .multi').html(adultsHtml.replace(':count',adults));

        var childrenHtml = parent.find('.render .children .multi').data('html');
        parent.find('.render .children .multi').html(childrenHtml.replace(':count',children));
        if(adults > 1){
            parent.find('.render .adults .multi').removeClass('d-none');
            parent.find('.render .adults .one').addClass('d-none');
        }else{
            parent.find('.render .adults .multi').addClass('d-none');
            parent.find('.render .adults .one').removeClass('d-none');
        }

        if(children > 1){
            parent.find('.render .children .multi').removeClass('d-none');
            parent.find('.render .children .one').addClass('d-none');
        }else{
            parent.find('.render .children .multi').addClass('d-none');
            parent.find('.render .children .one').removeClass('d-none').html(parent.find('.render .children .one').data('html').replace(':count',children));
        }

    }

    $('.select-guests-dropdown .dropdown-item-row').click(function(e){
        e.stopPropagation();
    });

    //Flight
    $('.select-seat-type-dropdown .btn-minus').on('click',function(e){
        e.stopPropagation();
        var parent = $(this).closest('.form-select-seat-type');
        var inputAttr = $(this).data('input-attr');
        if(typeof inputAttr =='undefined'){
            inputAttr = 'name';
        }
        var input = parent.find('.select-seat-type-dropdown ['+inputAttr+'='+$(this).data('input')+']');
        var min = parseInt(input.attr('min'));
        var old = parseInt(input.val());

        if(old <= min){
            return;
        }
        input.val(old-1);
        updateCustomSelectDropdown(input);
    });

    $('.select-seat-type-dropdown .btn-add').on('click',function(e){
        e.stopPropagation();
        var parent = $(this).closest('.form-select-seat-type');
        var inputAttr = $(this).data('input-attr');
        if(typeof inputAttr =='undefined'){
            inputAttr = 'name';
        }
        var input = parent.find('.select-seat-type-dropdown ['+inputAttr+'='+$(this).data('input')+']');
        var max = parseInt(input.attr('max'));
        var old = parseInt(input.val());

        if(old >= max){
            return;
        }
        input.val(old+1);
        updateCustomSelectDropdown(input);
    });
    $('.select-seat-type-dropdown input').on('keyup',function(e){
        updateCustomSelectDropdown($(this));
    });
    $('.select-seat-type-dropdown input').on('change',function(e){
        updateCustomSelectDropdown($(this));
    });

    function updateCustomSelectDropdown(input){
        var parent =input.closest('.form-select-seat-type');
        var target = input.attr('id');
        var number = parseInt(input.val());
        var render = parent.find('[id='+target+'_render]')

        var htmlString = render.find('.multi').data('html');
        var min = input.attr('min')
        console.log(
            render
        )
        if(number > min){
            render.find('.multi').removeClass('d-none').html(htmlString.replace(':count',number));
            render.find('.one').addClass('d-none');
        }else{
            render.find('.multi').addClass('d-none');
            render.find('.one').removeClass('d-none');
        }
    }
    $('.select-seat-type-dropdown .dropdown-item-row').on('click',function(e){
        e.stopPropagation();
    });

    $(".smart-search .smart-search-location").each(function () {
        var $this = $(this);
        var string_list = $this.attr('data-default');
        var default_list = [];
        if(string_list.length > 0){
            default_list = JSON.parse(string_list);
        }
        var url = $this.data('url');
        var key = $this.data('key');
        var options = {
            url: url ? url : bookingCore.url+'/location/search/searchForSelect2',
            dataDefault: default_list,
            textLoading: $this.attr("data-onLoad"),
            iconItem: "icofont-location-pin",
            key: key ? key : 'id'
        };
        $this.bravoAutocomplete(options);
    });

    $(".smart-search .smart-select").each(function () {
        var $this = $(this);
        var string_list = $this.attr('data-default');
        var default_list = [];
        if(string_list.length > 0){
            default_list = JSON.parse(string_list);
        }
        var options = {
            dataDefault: default_list,
            iconItem: "",
            textLoading: $this.attr("data-onLoad"),
        };
        $this.bravoAutocomplete(options);
    });

    $(document).on("click",".service-wishlist",function(){
        var $this = $(this);
        $.ajax({
            url:  bookingCore.url+'/user/wishlist',
            data: {
                object_id: $this.attr("data-id"),
                object_model: $this.attr("data-type"),
            },
            dataType: 'json',
            type: 'POST',
            beforeSend: function() {
                $this.addClass("loading");
            },
            success: function (res) {
                $this.attr('class',"service-wishlist "+res.class);
            },
            error:function (e) {
                if(e.status === 401){
                    $('#login').modal('show');
                }
            }
        })
    });

    $('.bravo-video-popup').click(function() {
        let video_url = $(this).data( "src" );
        let target = $(this).data( "target" );
        $(target).find(".bravo_embed_video").attr('src',video_url + "?autoplay=0&amp;modestbranding=1&amp;showinfo=0" );
        $(target).on('hidden.bs.modal', function () {
            $(target).find(".bravo_embed_video").attr('src',"" );
        });
    });


    var onSubmitContact = false;
    //Contact box
    $('.bravo-contact-block-form').submit(function (e) {
        e.preventDefault();
        if (onSubmitContact) return;
        $(this).addClass('loading');
        var me = $(this);
        me.find('.form-mess').html('');
        $.ajax({
            url: me.attr('action'),
            type: 'post',
            data: $(this).serialize(),
            dataType: 'json',
            success: function (json) {
                onSubmitContact = false;
                me.removeClass('loading');
                if (json.message) {
                    me.find('.form-mess').html('<span class="' + (json.status ? 'text-success' : 'text-danger') + '">' + json.message + '</span>');
                }
                if (json.status) {
                    me.find('input').val('');
                    me.find('textarea').val('');
                }
                if(typeof BravoReCaptcha != "undefined"){
                    BravoReCaptcha.reset('contact');
                }
            },
            error: function (e) {
                console.log(e);
                onSubmitContact = false;
                me.removeClass('loading');
                if(parseErrorMessage(e)){
                    me.find('.form-mess').html('<span class="text-danger">' + parseErrorMessage(e) + '</span>');
                }else
                if (e.responseText) {
                    me.find('.form-mess').html('<span class="text-danger">' + e.responseText + '</span>');
                }
                if(typeof BravoReCaptcha != "undefined"){
                    BravoReCaptcha.reset('contact');
                }
            }
        });
        return false;
    });

    $('.btn-submit-enquiry').click(function (e) {

        e.preventDefault();
        let form = $(this).closest('.enquiry_form_modal_form');

        $.ajax({
            url:bookingCore.url+'/booking/addEnquiry',
            data:form.find('textarea,input,select').serialize(),
            dataType:'json',
            type:'post',
            beforeSend: function () {
                form.find('.message_box').html('').hide();
                form.find('.icon-loading').css("display", 'inline-block');
            },
            success:function(res){
                if(res.errors){
                    res.message = '';
                    for(var k in res.errors){
                        res.message += res.errors[k].join('<br>')+'<br>';
                    }
                }
                if(res.message)
                {
                    if(!res.status){
                        form.find('.message_box').append('<div class="text text-danger">'+res.message+'</div>').show();
                    }else{
                        form.find('.message_box').append('<div class="text text-success">'+res.message+'</div>').show();
                    }
                }

                form.find('.icon-loading').hide();

                if(res.status){
                    form.find('textarea').val('');
                }

                if(typeof BravoReCaptcha != "undefined"){
                    BravoReCaptcha.reset('enquiry_form');
                }
            },
            error:function (e) {
                if(typeof BravoReCaptcha != "undefined"){
                    BravoReCaptcha.reset('enquiry_form');
                }
                form.find('.icon-loading').hide();
            }
        })
    })

    $('.review_upload_file').change(function () {
        var me = $(this);
        var p = $(this).closest('.review_upload_wrap');
        var lists = p.find('.review_upload_photo_list');

        me.isLoading = true;
        for(var i = 0 ;i < me.get(0).files.length ; i++) {
            var d = new FormData();
            d.append('type','image');
            d.append('file',me.get(0).files[i]);
            if(!me.showErr){
                $.ajax({
                    url: bookingCore.url + '/media/private/store',
                    data: d,
                    dataType: 'json',
                    type: 'post',
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        me.val('');
                        if (res.status === 0) {
                            bookingCoreApp.showError(res);
                        }
                        if (res.data) {
                            var count = $(".review_upload_photo_list > .col-md-2").length;
                            if(count > 5){
                                bookingCoreApp.showError('Maximum upload 6 pictures');
                            }else{
                                var div = $('<div class="col-md-2 mb-2"/>');
                                var item = $('<div class="review_upload_item"/>');
                                div.append(item);
                                var input = $("<input/>");
                                input.attr('type', 'hidden');
                                input.attr('name', me.data('name')+'[]');
                                input.val(JSON.stringify(res.data));

                                item.append(input);
                                item.css({
                                    'background-image':'url('+res.data.download+')'
                                });

                                if (me.data('multiple')) {
                                    lists.append(div);
                                } else {
                                    lists.html(div);
                                }
                            }

                        }
                    },
                    error: function (e) {
                        bookingCoreApp.showAjaxError(e);
                        me.val('');
                    }
                })
            }

        }

        $(this).val('');
    })

    $('.review_upload_item').click(function (e) {
        var p  = $(e.target).data('target');
        var fotorama = $(p+' .fotorama').fotorama();

    });

    $('.bc_popup').modal('show').on('hidden.bs.modal',function(){
        var id = $(this).attr('id');
        setCookie(id,1,parseInt($(this).data('days')));
    })

    $('.background-video-embed').each(function () {
        this.calcVideosSize = function (e) {
            let t = "16:9";
            "vimeo" === this.videoType && (t = e[0].width + ":" + e[0].height);
            const n = $('.background-video-container').outerWidth(),
                s = $('.background-video-container').outerHeight(),
                i = t.split(":"),
                o = i[0] / i[1],
                r = n / s > o;
            return { width: r ? n : s * o, height: r ? n / o : s };
        }

        let e;
        const t = this.calcVideosSize(e);

        $(this).attr('style', "width : "+t.width+"px; height : "+t.height+"px");
    });


    if( $('.bravo_header').hasClass("has_sticky") ){
        $(window).scroll(function(){
            if($(this).scrollTop()>=300){
                $('.bravo_wrap').addClass("header_sticky");
                $('.bravo_header').addClass("is_sticky");
            }else{
                $('.bravo_wrap').removeClass("header_sticky");
                $('.bravo_header').removeClass("is_sticky");
            }
        });
    }

});

jQuery(function($){
    'use strict';

    var notificationsWrapper   = $('.dropdown-notifications');
    var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
    var notificationsCountElem = notificationsToggle.find('.notification-icon');
    var notificationsCount     = parseInt(notificationsCountElem.html());
    var notifications          = notificationsWrapper.find('ul.dropdown-list-items');

    if(bookingCore.pusher_api_key && bookingCore.pusher_cluster){
        var pusher = new Pusher(bookingCore.pusher_api_key, {
            encrypted: true,
            cluster: bookingCore.pusher_cluster
        });
    }

    $(document).on("click",".markAsRead",function(e) {
        e.stopPropagation();
        e.preventDefault();
        var id = $(this).data('id');
        var url = $(this).attr('href');
        $.ajax({
            url: bookingCore.markAsRead,
            data: {'id' : id },
            method: "post",
            success:function (res) {
                window.location.href = url;
            }
        })
    });
    $(document).on("click",".markAllAsRead",function(e) {
        e.stopPropagation();
        e.preventDefault();
        $.ajax({
            url: bookingCore.markAllAsRead,
            method: "post",
            success:function (res) {
                $('.dropdown-notifications').find('li.notification').removeClass('active');
                notificationsCountElem.text(0);
                notificationsWrapper.find('.notif-count').text(0);
            }
        })
    });

    var callback = function(data) {
        var existingNotifications = notifications.html();
        var newNotificationHtml = '<li class="notification active">'
            +'<div class="media">' +
            '   <a class="markAsRead p-0" data-id="'+data.idNotification+'" href="'+data.link+'">'
            +'    <div class="media-left">'
            +'      <div class="media-object">'+ data.avatar
            +'      </div>'
            +'    </div>'
            +'    <div class="media-body">'
            +'      '+data.message+''
            +'      <div class="notification-meta">'
            +'        <small class="timestamp">about a few seconds ago</small>'
            +'      </div>'
            +'    </div>'
            +'  </a>' +
            '</div>'
            +'</li>';
        notifications.html(newNotificationHtml + existingNotifications);

        notificationsCount += 1;
        notificationsCountElem.text(notificationsCount);
        notificationsWrapper.find('.notif-count').text(notificationsCount);
    };

    if(bookingCore.isAdmin > 0 && bookingCore.pusher_api_key){
        var channel = pusher.subscribe('admin-channel');
        channel.bind('App\\Events\\PusherNotificationAdminEvent', callback);
    }

    if(bookingCore.currentUser > 0 && bookingCore.pusher_api_key){
        var channelPrivate = pusher.subscribe('user-channel-'+bookingCore.currentUser);
        channelPrivate.bind('App\\Events\\PusherNotificationPrivateEvent', callback);
    }

    if ($('.tabs-box').length) {
        $('.tabs-box .tab-buttons .tab-btn').on('click', function(e) {
            e.preventDefault();
            var target = $($(this).attr('data-tab'));
            if ($(target).is(':visible')) {
                return false;
            } else {
                target.parents('.tabs-box').find('.tab-buttons').find('.tab-btn').removeClass('active-btn');
                $(this).addClass('active-btn');
                target.parents('.tabs-box').find('.tabs-content').find('.tab').fadeOut(0);
                target.parents('.tabs-box').find('.tabs-content').find('.tab').removeClass('active-tab animated fadeIn');
                $(target).fadeIn(300);
                $(target).addClass('active-tab animated fadeIn');
            }
        });
    }

});


