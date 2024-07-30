(function ($){
    const form = $('.bravo_filter');
    const clearFilter = $('.bravo-clear-filter');
    const formTop = $('.bravo_form_search');
    let timeout = null;

    $(document).on('change','.bc-form-order select',function (){
        doSearch();
    });
    $(document).on('click','.switch-layout a',function (e){
        e.preventDefault();
        if(!$(this).hasClass('active')){
            $(this).addClass('active').siblings().removeClass('active');
            doSearch();
        }
    });
    $(document).on('click','.bravo-pagination a',function (e){
        e.preventDefault();
        doSearch($(this).attr('href'));
    });

    $('[name=s]','.civi-menu-filter').on('keyup',function(){
        if(timeout) window.clearTimeout(timeout);

        timeout = window.setTimeout(function (){
            doSearch();
        },300);
    })

    form.on('submit',function(e){
        e.preventDefault();
        doSearch();
    });
    formTop.on('submit',function(e){
        e.preventDefault();
        doSearch();
    });

    $('.civi-clear-top-filter').click(function(){
        formTop.find('input[type=text],input[type=hidden],select').val('');
        doSearch();
    })

    clearFilter.on('click',function (){
        clearFormFilter();
    })
    $(document).on('click','.ajax-search-result .civi-clear-filter',function (){
        clearFormFilter();
    });

    function clearFormFilter(){
        form.find('input[type=radio],input[type=checkbox]').prop('checked',false);
        form.find('input[type=text],input[type=hidden]').val('');
        clearFilter.hide();
        $('.ajax-search-result .civi-clear-filter').hide();
        doSearch();
    }


    function checkShowClear(){
        const filterFormData = {};
        form.find('input,textarea,select').serializeArray().map(function(x){ if(x.value)  filterFormData[x.name] = x.value;});

        if(Object.keys(filterFormData).length){
            toggleClearFilter(true);
        }else{
            toggleClearFilter(false);
        }
    }
    function toggleClearFilter(status){
        if(status){
            clearFilter.show();
            $('.ajax-search-result .civi-clear-filter').show();
        }else{
            clearFilter.hide();
            $('.ajax-search-result .civi-clear-filter').hide();
        }
    }
    checkShowClear();


    $('.orderby .dropdown-item').on('click',function (e){
        e.preventDefault();
        $('[name=orderby]').val($(this).data('value'));
        $('.orderby .dropdown-toggle').html($(this).html());
        doSearch();
    })

    window.doSearch = function(withUrl){
        let fullUrl = '';
        if(typeof withUrl === 'undefined') {
            const orderForm = $('.bc-form-order');
            let topFormData = [];
            let orderFormData = [];
            let filterFormData = [];
            topFormData = formTop.find('input,textarea,select').serializeArray().filter(function (x) {
                return x.value;
            });
            filterFormData = form.find('input,textarea,select').serializeArray().filter(function (x) {
                return x.value;
            });
            orderFormData = orderForm.find('input,textarea,select').serializeArray().filter(function (x) {
                return x.value;
            });
            // orderFormData.push({'name':'_display','value':$('.switch-layout .active').data('layout')});
            if (Object.keys(filterFormData).length) {
                toggleClearFilter(true);
            } else {
                toggleClearFilter(false);
            }
            const params = [...topFormData,...orderFormData, ...filterFormData];
            fullUrl = currentUrl + '?' + params.map((p)=>p.name+"="+p.value).join('&');
        }else{
            fullUrl = withUrl;
        }
        window.history.pushState({}, '', fullUrl);
        $('.item-loop-wrap').addClass('skeleton-loading');

        $.ajax({
            url:fullUrl,
            data:{
                _ajax:1
            },
            success : function(json){
                if(typeof json.fragments !== 'undefined'){
                    for(const k in json.fragments){
                        $(k).html(json.fragments[k]);
                    }
                }
                window.lazyLoadInstance.update();

                if(typeof json.markers !== 'undefined'){
                    $('#map').trigger('update-markers',[json.markers])
                }
            }
        })
    }

})(jQuery)
