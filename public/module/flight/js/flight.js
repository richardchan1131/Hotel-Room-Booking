(function ($) {
    var isEmpty = function isEmpty(f) {
        return (/^function[^{]+\{\s*\}/m.test(f.toString())
        );
    }
    var flightFormBookModal = new Vue({
        el:'#flightFormBookModal',
        data:{
            id:'',
            buyer_fees:[],
            message:{
                content:'',
                type:false
            },
            flight:{
                airline:{},
                airport_from:{},
                airport_to:{}
            },
            html:'',
            onSubmit:false,
            step:1,
            firstLoad:true,
            i18n:[],
            total_price_before_fee:0,
            total_price_fee:0,
            onLoading:false
        },
        computed: {
            total_price:function() {
                var me = this;
                var total = 0;
                if(typeof me.flight.flight_seat !='undefined'){
                    _.forEach( me.flight.flight_seat,function (item) {
                        if(item.number >0){
                            total += item.number * item.price;
                        }
                    });
                }
                return total;
            },
            total_price_html:function(){
                if(!this.total_price) return '';
                return window.bravo_format_money(this.total_price);
            },
        },
        methods: {
            openModal(flightId) {
                $('#flightFormBookModal').modal();
                var me = this;
                me.id= flightId;
                if(me.onSubmit==true){
                    return false;
                }
                me.onSubmit = true;
                me.onLoading = true;// dung cai nay de them icon loading
                $.ajax({
                    url:bookingCore.module.flight+'/getData/'+me.id,
                    data:this.form,
                    dataType:'json',
                    method:'post',
                    success:function (json) {
                        if(json.status){
                            me.flight = json.data;
                        }
                        me.onSubmit = false;
                        me.onLoading = false;
                    },
                    error:function (e) {
                        me.onSubmit = false;
                        me.onLoading = false;
                    }
                });
            },
            flightCheckOut(){
                var me = this;
                me.message.content = '';
                var params = {
                    service_id:me.flight.id,
                    service_type:'flight',
                    flight_seat : me.flight.flight_seat
                }
                if(me.onSubmit==true){
                    return false;
                }
                me.onSubmit = true;
                $.ajax({
                    url:bookingCore.url+'/booking/addToCart',
                    data:params,
                    dataType:'json',
                    method:'post',
                    success:function (json) {
                        if(!json.status){
                            me.onSubmit = false;
                        }
                        if(json.message)
                        {
                            me.message.content = json.message;
                            me.message.type = json.status;
                        }
                        if(json.url){
                            window.location.href = json.url
                        }
                        if(json.errors && typeof json.errors == 'object')
                        {
                            var html = '';
                            for(var i in json.errors){
                                html += json.errors[i]+'<br>';
                            }
                            me.message.content = html;
                            bookingCoreApp.showError(html);
                        }
                        me.onSubmit = false;
                    },
                    error:function (e) {
                        me.onSubmit = false;
                        bravo_handle_error_response(e);
                        if(e.status == 401){
                            $('#flightFormBookModal').modal('hide');
                        }
                        if(e.status != 401 && e.responseJSON){
                            me.message.content = e.responseJSON.message ? e.responseJSON.message : 'Can not booking';
                            me.message.type = false;
                        }
                        me.onSubmit = false;
                    }
                });
            },

            minusNumberFlightSeat(flightSeat){
                if(flightSeat.number <= 0){
                    flightSeat.number = 0;
                }else{
                    flightSeat.number--;
                }
            },
            addNumberFlightSeat(flightSeat){
                if(flightSeat.number>=flightSeat.max_passengers){
                    flightSeat.number=flightSeat.max_passengers;
                }else{
                    flightSeat.number++;
                }
            },
            updateNumberFlightSeat(flightSeat){
                if(flightSeat.number>=flightSeat.max_passengers){
                    flightSeat.number=flightSeat.max_passengers;
                }
            }
        },
    })
    var flightFormBook = new Vue({
        el:'#flightFormBook',
        data:{
        },
        methods:{
            openModalBook(flightId){
                flightFormBookModal.openModal(flightId);
            }
        },
        mounted(){
            var me = this;
            $(document).on('click','.btn-choose-flight',function(){
                me.openModalBook($(this).data('id'));
            })
        }

    })


    $(".bravo_filter .g-filter-item").each(function () {
        if($(window).width() <= 990){
            $(this).find(".item-title").toggleClass("e-close");
        }
        $(this).find(".item-title").click(function () {
            $(this).toggleClass("e-close");
            if($(this).hasClass("e-close")){
                $(this).closest(".g-filter-item").find(".item-content").slideUp();
            }else{
                $(this).closest(".g-filter-item").find(".item-content").slideDown();
            }
        });
        $(this).find(".btn-more-item").click(function () {
            $(this).closest(".g-filter-item").find(".hide").removeClass("hide");
            $(this).addClass("hide");
        });
        $(this).find(".bravo-filter-price").each(function () {
            var input_price = $(this).find(".filter-price");
            var min = input_price.data("min");
            var max = input_price.data("max");
            var from = input_price.data("from");
            var to = input_price.data("to");
            var symbol = input_price.data("symbol");
            input_price.ionRangeSlider({
                type: "double",
                grid: true,
                min: min,
                max: max,
                from: from,
                to: to,
                prefix: symbol
            });
        });
    });
    $(".bravo_form_filter input[type=checkbox]").change(function () {
        $(this).closest(".bravo_form_filter").submit();
    });

})(jQuery);
