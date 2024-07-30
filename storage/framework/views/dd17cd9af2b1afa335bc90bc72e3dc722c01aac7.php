<section data-anim-wrap class="section-bg pt-80 pb-80 md:pt-40 md:pb-40">

    <div data-anim-child="fade delay-1" class="section-bg__item -w-1500 rounded-4 bg-yellow-1"></div>

    <div class="container">
        <div class="row y-gap-30 items-center justify-between">
            <div data-anim-child="slide-up delay-2" class="col-xl-5 col-lg-6">
                <h2 class="text-30 lh-15"><?php echo e($title ?? ''); ?></h2>
                <p class="text-dark-1 pr-40 lg:pr-0 mt-15 sm:mt-5"><?php echo e($sub_title ?? ''); ?></p>

                <?php if(!empty($list_item)): ?>
                    <div class="row y-gap-20 items-center pt-30 sm:pt-10">
                        <?php $__currentLoopData = $list_item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-auto">
                                <div class="d-flex items-center px-20 py-10 rounded-8 border-white-15 text-white bg-dark-3">
                                    <div class="<?php echo e($item['icon'] ?? ''); ?> text-24"></div>
                                    <div class="ml-20">
                                        <div class="text-14"><a href="<?php echo e($item['link'] ?? '#'); ?>" target="_blank"><?php echo e($item['subtitle'] ?? ''); ?></a></div>
                                        <div class="text-15 lh-1 fw-500"><a href="<?php echo e($item['link'] ?? '#'); ?>" target="_blank"><?php echo e($item['title'] ?? ''); ?></a></div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                <?php endif; ?>
            </div>

            <?php if(!empty($bg_image_url)): ?>
                <div data-anim-child="slide-up delay-3" class="col-lg-6">
                    <img src="<?php echo e($bg_image_url); ?>" alt="image" data-src="<?php echo e($bg_image_url); ?>" class="js-lazy">
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php /**PATH /home/r114961reze/public_html/themes/GoTrip/Template/Views/frontend/blocks/download/style_2.blade.php ENDPATH**/ ?>