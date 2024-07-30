var mapEngine = new BravoMapEngine('bravo_results_map',{
    fitBounds:bookingCore.map_options.map_fit_bounds,
    center:[bravo_map_data.map_lat_default, bravo_map_data.map_lng_default ],
    zoom:bravo_map_data.map_zoom_default,
    disableScripts:true,
    markerClustering:bookingCore.map_options.map_clustering,
    ready: function (engineMap) {
        if(bravo_map_data.markers){
            engineMap.addMarkers2(bravo_map_data.markers);
        }
    }
});

jQuery(function ($) {


	$(".bravo-filter-price").each(function () {
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

	$('.bravo_form_search_map .smart-search .child_id').change(function () {
		reloadForm();
	});
    $('.bravo_form_search_map .g-map-place input[name=map_place]').change(function () {
        setTimeout(function () {
            reloadForm()
        },500)
        // reloadForm();
    });
	$('.bravo_form_search_map .input-filter').change(function () {
		reloadForm();
	});
	$('.bravo_form_search_map .btn-filter,.btn-apply-advances').click(function () {
		reloadForm();
	});
	$('.btn-apply-advances').click(function(){
		$('#advance_filters').addClass('d-none');
	})

	function reloadForm(byUrl){
        let filterFormData = $('.bravo_form_search_map').find('input,textarea,select').serializeArray().filter(function (x) {
            return x.value;
        });
        let advanceFormData = $('#advance_filters').find('input,textarea,select').serializeArray().filter(function (x) {
            return x.value;
        });
        const params = [...filterFormData,...advanceFormData];
        $('.map_loading').show();
        const fullUrl = typeof byUrl !== 'undefined' ? byUrl : currentUrl + '?' + params.map((p)=>p.name+"="+p.value).join('&');

        window.history.pushState({}, '', fullUrl);

        $('.item-loop-wrap').addClass('skeleton-loading');
		$.ajax({
            url:fullUrl,
            data:{
                _ajax:1,
                _map:1
            },
			type:'get',
			success:function (json) {
				$('.map_loading').hide();
				if(json.status)
				{
					mapEngine.clearMarkers();
					mapEngine.addMarkers2(json.markers);

                    if(typeof json.fragments !== 'undefined'){
                        for(const k in json.fragments){
                            $(k).html(json.fragments[k]);
                        }
                    }

					$('.listing_items').animate({
                        scrollTop:0
                    },'fast');

					if(window.lazyLoadInstance){
						window.lazyLoadInstance.update();
					}

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

	$('.toggle-advance-filter').click(function () {
		var id = $(this).data('target');
		$(id).toggleClass('d-none');
	});

    $(document).on('click', '.filter-item .dropdown-menu', function (e) {

        if(!$(e.target).hasClass('btn-apply-advances')){
            e.stopPropagation();
		}
    })
		.on('click','.bravo-pagination a',function (e) {
			e.preventDefault();
            reloadForm($(this).attr('href'));
        })
	;

});
