<?php if(!empty($breadcrumbs)): ?>
    <section data-anim="fade" class="d-flex items-center py-15">
        <div class="">
            <div class="row y-gap-10 items-center justify-between">
                <div class="col-auto">
                    <div class="row x-gap-10 y-gap-5 items-center text-14 text-light-1">
                        <div class="col-auto">
                            <div class=""><a href="<?php echo e(url("/")); ?>"> <i class="fa fa-home"></i> <?php echo e(__('Home')); ?></a></div>
                        </div>
                        <div class="col-auto"><div class="">></div></div>
                        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-auto <?php echo e($breadcrumb['class'] ?? ''); ?>">
                                <?php if(!empty($breadcrumb['url'])): ?>
                                    <div><a href="<?php echo e(url($breadcrumb['url'])); ?>"><?php echo e($breadcrumb['name']); ?></a></div>
                                <?php else: ?>
                                    <div class="text-dark-1"><?php echo e($breadcrumb['name']); ?></div>
                                <?php endif; ?>
                            </div>
                            <?php if(!empty($breadcrumb['url'])): ?>
                                <div class="col-auto"><div class="">></div></div>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>
<div class="location_banner">
    <?php $banner = $row->getBannerImageUrlAttribute('full') ?>
    <div class="relative d-flex">
        <?php if(!empty($banner)): ?>
            <img src="<?php echo e($banner); ?>" alt="<?php echo e($translation->name); ?>" class="col-12 rounded-4">
        <?php else: ?>
            <div class="w-100 min-height-300 bg-dark-1"></div>
        <?php endif; ?>
        <div class="effect"></div>
        <div class="absolute z-2 px-50 py-60 text-banner">
            <h1 class="text-50 fw-600 text-white"><?php echo e($translation->name); ?></h1>
            <div class="text-white"><?php echo e(__("Explore deals, travel guides and things to do in :text",['text'=>$translation->name])); ?></div>
        </div>
    </div>
</div>
<div class="row x-gap-20 y-gap-20 items-center pt-20">
    <?php $types = get_bookable_services() ?>
    <?php if(!empty($types)): ?>
        <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type=>$moduleClass): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                if(!$moduleClass::isEnable()) continue;
            ?>
            <div class="col">
                <a href="<?php echo e($moduleClass::getLinkForPageSearch(false,['location_id'=>$row->id])); ?>" class="d-flex flex-column justify-center px-20 py-15 rounded-4 border-light text-16 lh-14 fw-500 col-12">
                    <i class="<?php echo e(call_user_func([$moduleClass,'getServiceIconFeatured'])); ?> text-25 mb-10"></i>
                    <?php echo e(call_user_func([$moduleClass,'getModelName'])); ?>

                </a>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>
<?php /**PATH /home/r114961reze/public_html/themes/GoTrip/Location/Views/frontend/layouts/details/location-banner.blade.php ENDPATH**/ ?>