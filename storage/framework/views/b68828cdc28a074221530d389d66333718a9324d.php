<div class="preloader js-preloader <?php if(empty(setting_item('enable_preload'))): ?> -is-hidden <?php endif; ?>">
    <?php if(!empty($logo_preload_id = setting_item('logo_preload_id'))): ?>
        <div class="preloader__wrap">
            <div class="preloader__icon">
                <img class="logo-light" src="<?php echo e(get_file_url($logo_preload_id,'full')); ?>" alt="<?php echo e(setting_item("site_title")); ?>">
            </div>
        </div>
    <?php endif; ?>
    <div class="preloader__title"><?php echo e(setting_item('site_title')); ?></div>
</div>
<?php /**PATH /home/r114961reze/public_html/themes/GoTrip/Layout/parts/preload.blade.php ENDPATH**/ ?>