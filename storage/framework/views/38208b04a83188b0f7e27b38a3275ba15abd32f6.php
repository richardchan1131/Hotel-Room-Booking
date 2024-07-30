<?php
    if($headerStyle == "normal_white"){
        $logo = $logoDark;
    }
?>
<div class="d-flex items-center gotrip-header-<?php echo e($headerStyle); ?>">
    <a href="<?php echo e(url(app_get_locale(false,'/'))); ?>" class="<?php if($headerStyle == 'transparent_v3'): ?> d-none xl:d-flex <?php endif; ?> header-logo mr-20" data-x="header-logo" data-x-toggle="is-logo-dark">
        <?php if($logo): ?>
            <img class="logo-light" src="<?php echo e(get_file_url($logo,'full')); ?>" alt="<?php echo e(setting_item("site_title")); ?>">
        <?php endif; ?>
        <?php if($logoDark): ?>
            <img class="logo-dark" src="<?php echo e(get_file_url($logoDark,'full')); ?>" alt="<?php echo e(setting_item("site_title")); ?>">
        <?php endif; ?>
    </a>
    <div class="header-menu " data-x="mobile-menu" data-x-toggle="is-menu-active">
        <div class="mobile-overlay"></div>
        <div class="header-menu__content">
            <div class="mobile-bg js-mobile-bg"></div>
            <div class="menu js-navList">
                <?php $textColor = $textColor ?? 'text-white';
                    if ($headerStyle == 'transparent_v5' || $headerStyle == 'transparent_v6' || $headerStyle == 'transparent_v9') $textColor = 'text-dark-1';
                    generate_menu('primary',[
                        'walker'=>\Themes\GoTrip\Core\Walkers\MenuWalker::class,
                        'custom_class' => $textColor,
                        'desktop_menu' => true,
                        'enable_mega_menu' => true
                     ])
                ?>
            </div>
            <div class="mobile-footer px-20 py-10 border-top-light js-mobile-footer">
                <?php echo $__env->make('Core::frontend.currency-switcher', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php echo $__env->make('Language::frontend.switcher-dropdown', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/r114961reze/public_html/themes/GoTrip/Layout/parts/header-style/normal.blade.php ENDPATH**/ ?>