<?php
    $footerStyle = !empty($row->footer_style) ? $row->footer_style : setting_item('footer_style','normal');
    $footer_classes = "-type-1";
    if($footerStyle == "style_1"){
        $footer_classes = "-type-1 text-white bg-dark-2";
    }
    if($footerStyle == "style_2"){
        $footer_classes = "-type-2 bg-light-2";
    }
    if($footerStyle == "style_3"){
        $footer_classes = "-type-3 text-white bg-dark-1";
    }
    if($footerStyle == "style_4"){
        $footer_classes = "-type-2 bg-blue-1 text-white";
    }
    if($footerStyle == "style_5"){
        $footer_classes = "-type-2 bg-dark-2 text-white";
    }
    if($footerStyle == "style_6"){
        $footer_classes = "-type-1 text-white bg-blue-1";
    }
	if($footerStyle == "style_7"){
        $footer_classes = "-type-2 bg-light-2 text-dark";
    }
    if($footerStyle == "style_8"){
        $footer_classes = "footer -type-2 bg-dark-3 text-white";
    }
?>

<div class="footer <?php echo e($footer_classes); ?> <?php echo e($footerStyle); ?>">
    <div class="container">
        <?php switch($footerStyle):
            case ('style_4'): ?>
            <?php case ('style_5'): ?> <?php echo $__env->make('Layout::parts.footer-style.style_4', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <?php break; ?>
            <?php case ('style_7'): ?> <?php echo $__env->make('Layout::parts.footer-style.style_7', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <?php break; ?>
            <?php case ('style_8'): ?> <?php echo $__env->make('Layout::parts.footer-style.style_4',['logoStyle' => 'light'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <?php break; ?>
            <?php default: ?> <?php echo $__env->make('Layout::parts.footer-style.normal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endswitch; ?>

        <section class="footer_middle_area py-20 <?php if($footerStyle == 'style_1'): ?> border-top-white-15 <?php else: ?> border-top-light <?php endif; ?>">
            <div class="row justify-between items-center y-gap-10">
                <div class="col-auto">
                    <?php echo setting_item_with_lang("footer_text_left") ?? ''; ?>

                </div>
                <div class="col-auto">
                    <div class="row y-gap-10 items-center">
                        <div class="col-auto">
                            <div class="d-flex items-center">
                                <div class="menu-footer">
                                    <div class="mobile-overlay"></div>
                                    <div class="header-menu__content">
                                        <div class="menu js-navList">
                                            <ul class="menu__nav -is-active">
                                                <?php echo $__env->make('Core::frontend.currency-switcher', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                                <?php echo $__env->make('Language::frontend.switcher-dropdown', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-auto">
                            <?php echo setting_item_with_lang("footer_text_right") ?? ''; ?>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
<?php /**PATH E:\Gabriel code site\themes/GoTrip/Layout/parts/footer-style/index.blade.php ENDPATH**/ ?>