$(document).on('preview-updated', (e, data) => {
    window.initComponents();
    $('.swiper-slide').addClass("is-in-view")
    $("[data-anim^='slide-'], [data-anim-child^='slide-']").addClass("is-in-view")

    if(window.lazyLoadInstance){
        lazyLoadInstance.update();
    }
});
