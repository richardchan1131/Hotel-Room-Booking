(function ($) {
    new Vue({
        el:'#bravo_boat_book_app',
        data:{
            id:'',
            extra_price:[],
            buyer_fees:[],
            message:{
                content:'',
                type:false
            },
            message2:{
                content:'',
                type:false
            },
            html:'',
            onSubmit:false,
            start_date:'',
            end_date:'',
            start_date_html:'',

            step:1,
            start_date_obj:'',
            allEvents:[],

            hour:1,
            day:0,
            start_time:"00:00",

            number:1,
            total_price_before_fee:0,
            total_price_fee:0,

            is_form_enquiry_and_book:false,
            enquiry_type:'book',
            enquiry_is_submit:false,
            enquiry_name:"",
            enquiry_email:"",
            enquiry_phone:"",
            enquiry_note:"",
        },
        watch:{
            extra_price:{
                handler:function f() {
                    this.step = 1;
                },
                deep:true
            },
            start_time(){
                this.start_date = "";
            },
        },
        computed:{
            total_price:function(){
                var me = this;
                var type = 'hour';
                var duration = me.hour;
                if(me.day > 0){
                    duration = me.day;
                    type = 'day';
                }
                if(duration < 1){
                    return 0;
                }
                if (me.start_date !== "") {
                    var total_price = 0;
                    if(type == 'hour') {
                        var startDate = new Date(me.start_date).getTime();
                        var isBook = true;
                        for (var ix in me.allEvents) {
                            var item = me.allEvents[ix];
                            var cur_date = new Date(item.start).getTime();
                            if (cur_date == startDate) {
                                total_price += parseFloat(item.price_per_hour);
                                if (item.active === 0) {
                                    isBook = false
                                }
                            }
                        }
                        total_price = me.number * total_price * duration;
                    }
                    if(type == 'day') {
                        var startDate = new Date(me.start_date).getTime();
                        var endDate = new Date(startDate + ( 86400000 * duration) ).getTime();
                        var isBook = true;
                        for (var ix in me.allEvents) {
                            var item = me.allEvents[ix];
                            var cur_date = new Date(item.start).getTime();
                            if (cur_date >= startDate && cur_date < endDate) {
                                total_price += parseFloat(item.price_per_day);
                                if (item.active === 0) {
                                    isBook = false
                                }
                            }
                        }
                    }

                    for (var ix in me.extra_price) {
                        var item = me.extra_price[ix];
                        if(!item.price) continue;
                        var type_total = 0;
                        if (item.enable == 1) {
                            switch (item.type) {
                                case "one_time":
                                    type_total += parseFloat(item.price) * me.number;
                                    break;
                            }
                            total_price += type_total;
                        }
                    }
                    this.total_price_before_fee = total_price;

                    var total_fee = 0;
                    for (var ix in me.buyer_fees) {
                        var item = me.buyer_fees[ix];
                        if(!item.price) continue;

                        //for Fixed
                        var fee_price = parseFloat(item.price);

                        //for Percent
                        if (typeof item.unit !== "undefined" && item.unit === "percent" ) {
                            fee_price = ( total_price / 100 ) * fee_price;
                        }

                        total_fee += fee_price;
                    }
                    total_price += total_fee;
                    this.total_price_fee = total_fee;

                    if (isBook === false || me.number === 0) {
                        return 0;
                    } else {
                       return total_price;
                    }
                }
                return 0;
            },
            total_price_html:function(){
                if(!this.total_price) return '';
                return window.bravo_format_money(this.total_price);
            },
            pay_now_price:function(){
                if(this.is_deposit_ready){
                    var total_price_depossit = 0;

                    var tmp_total_price = this.total_price;
                    var deposit_fomular = this.deposit_fomular;
                    if(deposit_fomular === "deposit_and_fee"){
                        tmp_total_price = this.total_price_before_fee;
                    }

                    switch (this.deposit_type) {
                        case "percent":
                            total_price_depossit =  tmp_total_price * this.deposit_amount / 100;
                            break;
                        default:
                            total_price_depossit =  this.deposit_amount;
                    }
                    if(deposit_fomular === "deposit_and_fee"){
                        total_price_depossit = total_price_depossit + this.total_price_fee;
                    }

                    return  total_price_depossit
                }
                return this.total_price;
            },
            pay_now_price_html:function(){
                return window.bravo_format_money(this.pay_now_price);
            },
            daysOfWeekDisabled(){
                var res = [];

                for(var k in this.open_hours)
                {
                    if(typeof this.open_hours[k].enable == 'undefined' || this.open_hours[k].enable !=1 ){

                        if(k == 7){
                            res.push(0);
                        }else{
                            res.push(k);
                        }
                    }
                }

                return res;
            },
            is_deposit_ready:function () {
                if(this.deposit && this.deposit_amount) return true;
                return false;
            },

        },
        created:function(){
            for(var k in bravo_booking_data){
                this[k] = bravo_booking_data[k];
            }
        },
        mounted(){
            var me = this;
            var options = {
                singleDatePicker: true,
                showCalendar: false,
                sameDate: true,
                autoApply           : true,
                disabledPast        : true,
                dateFormat          : bookingCore.date_format,
                enableLoading       : true,
                showEventTooltip    : true,
                classNotAvailable   : ['disabled', 'off'],
                disableHightLight: true,
                minDate:this.minDate,
                opens: bookingCore.rtl ? 'right':'left',
                locale:{
                    direction: bookingCore.rtl ? 'rtl':'ltr',
                    firstDay:daterangepickerLocale.first_day_of_week
                },
                isInvalidDate:function (date) {
                    for(var k = 0 ; k < me.allEvents.length ; k++){
                        var item = me.allEvents[k];
                        if(item.start == date.format('YYYY-MM-DD')){
                            return item.active ? false : true;
                        }
                    }
                    return false;
                },
                addClassCustom:function (date) {
                    for(var k = 0 ; k < me.allEvents.length ; k++){
                        var item = me.allEvents[k];
                        if(item.start == date.format('YYYY-MM-DD') && item.classNames !== undefined){
                            var class_names = "";
                            for(var i = 0 ; i < item.classNames.length ; i++){
                                var classItem = item.classNames[i];
                                class_names += " "+classItem;
                            }
                            return class_names;
                        }
                    }
                    return "";
                }
            };

            if (typeof  daterangepickerLocale == 'object') {
                options.locale = _.merge(daterangepickerLocale,options.locale);
            }

            this.$nextTick(function () {

                $(this.$refs.start_date).daterangepicker(options).on('apply.daterangepicker',
                    function (ev, picker) {
                        me.start_date = picker.startDate.format('YYYY-MM-DD');
                        me.end_date = picker.endDate.format('YYYY-MM-DD');
                        me.start_date_html = picker.startDate.format(bookingCore.date_format);
                        for(var k = 0 ; k < me.allEvents.length ; k++){
                            var item = me.allEvents[k];
                            if(item.start === picker.endDate.format('YYYY-MM-DD')){

                            }
                        }
                        me.availabilityBooking();
                    })
                    .on('update-calendar',function (e,obj) {
                        me.fetchEvents(obj.leftCalendar.calendar[0][0], obj.rightCalendar.calendar[5][6])
                    });
            })
        },
        methods:{
            handleTotalPrice:function() {
            },
            fetchEvents(start,end){
                var me = this;
                var data = {
                    start: start.format('YYYY-MM-DD'),
                    end: end.format('YYYY-MM-DD'),
                    hour:me.hour,
                    day:me.day,
                    start_time:me.start_time,
                    id:bravo_booking_data.id,
                    for_single:1
                };

                $.ajax({
                    url: bravo_booking_i18n.load_dates_url,
                    dataType:"json",
                    type:'get',
                    data:data,
                    beforeSend: function() {
                        $('.daterangepicker').addClass("loading");
                    },
                    success:function (json) {
                        me.allEvents = json;
                        var drp = $(me.$refs.start_date).data('daterangepicker');
                        drp.allEvents = json;
                        drp.renderCalendar('left');
                        if (!drp.singleDatePicker) {
                            drp.renderCalendar('right');
                        }
                        $('.daterangepicker').removeClass("loading");
                    },
                    error:function (e) {
                        console.log(e);
                        console.log("Can not get availability");
                    }
                });
            },
            formatMoney: function (m) {
                return window.bravo_format_money(m);
            },
            validate(){
                if(!this.start_date)
                {
					this.message.status = false;
                    this.message.content = bravo_booking_i18n.no_date_select;
                    return false;
                }
                if(!this.number )
                {
					this.message.status = false;
                    this.message.content = bravo_booking_i18n.no_guest_select;
                    return false;
                }

                return true;
            },

            addHour(){
                var me = this;
                me.day = 0;
                me.start_date = me.message2.content = "";
                me.start_date_html = bravo_booking_data.start_date_html;
                if(parseInt(me.hour) < 23 ) me.hour = parseInt(me.hour) + 1;
            },
            minusHour(){
                var me = this;
                if(parseInt(me.hour) > 0) me.hour = parseInt(me.hour) - 1;
                me.start_date = me.message2.content = "";
                me.start_date_html = bravo_booking_data.start_date_html;
            },

            addDay(){
                var me = this;
                me.hour = 0;
                me.day = parseInt(me.day) + 1;
                me.start_date = me.message2.content = "";
                me.start_date_html = bravo_booking_data.start_date_html;
            },
            minusDay(){
                var me = this;
                if(parseInt(me.day) > 0) me.day = parseInt(me.day) - 1;
                me.start_date = me.message2.content = "";
                me.start_date_html = bravo_booking_data.start_date_html;
            },
            startTimeChange(){
                var me = this;
                me.start_date = me.message2.content = "";
                me.start_date_html = bravo_booking_data.start_date_html;
            },

            doSubmit:function (e) {
                e.preventDefault();
                if(this.onSubmit) return false;

                if(!this.validate()) return false;

                this.onSubmit = true;
                var me = this;

                this.message.content = '';

                if(this.step == 1){
                    this.html = '';
                }

                $.ajax({
                    url:bookingCore.url+'/booking/addToCart',
                    data:{
                        service_id:this.id,
                        service_type:"boat",
                        start_date:this.start_date,
                        hour:this.hour,
                        day:this.day,
                        start_time:this.start_time,

                        extra_price:this.extra_price,
                        number:this.number,
                    },
                    dataType:'json',
                    type:'post',
                    success:function(res){

                        if(!res.status){
                            me.onSubmit = false;
                        }
                        if(res.message)
                        {
                            me.message.content = res.message;
                            me.message.type = res.status;
                        }

                        if(res.step){
                            me.step = res.step;
                        }
                        if(res.html){
                            me.html = res.html
                        }

                        if(res.url){
                            window.location.href = res.url
                        }

                        if(res.errors && typeof res.errors == 'object')
                        {
                            var html = '';
                            for(var i in res.errors){
                                html += res.errors[i]+'<br>';
                            }
                            me.message.content = html;
                        }
                    },
                    error:function (e) {
                        console.log(e);
                        me.onSubmit = false;

                        bravo_handle_error_response(e);

                        if(e.status == 401){
                            $('.bravo_single_book_wrap').modal('hide');
                        }

                        if(e.status != 401 && e.responseJSON){
                            me.message.content = e.responseJSON.message ? e.responseJSON.message : 'Can not booking';
                            me.message.type = false;

                        }
                    }
                })
            },
            doEnquirySubmit:function(e){
                e.preventDefault();
                if(this.onSubmit) return false;
                if(!this.validateenquiry()) return false;
                this.onSubmit = true;
                var me = this;
                this.message.content = '';

                $.ajax({
                    url:bookingCore.url+'/booking/addEnquiry',
                    data:{
                        service_id:this.id,
                        service_type:'car',
                        name:this.enquiry_name,
                        email:this.enquiry_email,
                        phone:this.enquiry_phone,
                        note:this.enquiry_note,
                    },
                    dataType:'json',
                    type:'post',
                    success:function(res){
                        if(res.message)
                        {
                            me.message.content = res.message;
                            me.message.type = res.status;
                        }
                        if(res.errors && typeof res.errors == 'object')
                        {
                            var html = '';
                            for(var i in res.errors){
                                html += res.errors[i]+'<br>';
                            }
                            me.message.content = html;
                        }
                        if(res.status){
                            me.enquiry_is_submit = true;
                            me.enquiry_name = "";
                            me.enquiry_email = "";
                            me.enquiry_phone = "";
                            me.enquiry_note = "";
                        }
                        me.onSubmit = false;
                    },
                    error:function (e) {
                        me.onSubmit = false;
                        bravo_handle_error_response(e);
                        if(e.status == 401){
                            $('.bravo_single_book_wrap').modal('hide');
                        }
                        if(e.status != 401 && e.responseJSON){
                            me.message.content = e.responseJSON.message ? e.responseJSON.message : 'Can not booking';
                            me.message.type = false;
                        }
                    }
                })
            },
            validateenquiry(){
                if(!this.enquiry_name)
                {
                    this.message.status = false;
                    this.message.content = bravo_booking_i18n.name_required;
                    return false;
                }
                if(!this.enquiry_email)
                {
                    this.message.status = false;
                    this.message.content = bravo_booking_i18n.email_required;
                    return false;
                }
                return true;
            },

            availabilityBooking(){
                var me = this;
                var data = {
                    start_date: me.start_date,
                    hour:me.hour,
                    day:me.day,
                    start_time:me.start_time,
                    id:bravo_booking_data.id,
                };
                me.message2.content = '';
                $.ajax({
                    url: bravo_booking_i18n.availability_booking_url,
                    dataType:"json",
                    type:'get',
                    data:data,
                    beforeSend: function() {

                    },
                    success:function (res) {
                        if(!res.status){
                            me.onSubmit = false;
                        }
                        if(res.message)
                        {
                            me.message2.content = res.message;
                            me.message2.type = res.status;
                        }
                    },
                    error:function (e) {
                        console.log(e);
                    }
                });
            },

            openStartDate(){
                $(this.$refs.start_date).trigger('click');
            }
        }

    });




    $(window).on("load", function () {
        var urlHash = window.location.href.split("#")[1];
        if (urlHash &&  $('.' + urlHash).length ){
            var offset_other = 70
            if(urlHash === "review-list"){
                offset_other = 330;
            }
            $('html,body').animate({
                scrollTop: $('.' + urlHash).offset().top - offset_other
            }, 1000);
        }
    });

    $(".bravo-button-book-mobile").click(function () {
        $('.bravo_single_book_wrap').modal('show');
    });

    $(".bravo_detail_boat .g-faq .item .header").click(function () {
        $(this).parent().toggleClass("active");
    });

})(jQuery);
