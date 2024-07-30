<?php if(!empty($hotel_related)): ?>
    <div class="container">
        <div class="border-top-light"></div>
    </div>
    <section class="layout-pt-md layout-pb-lg">
        <div class="container">
            <div class="row justify-between items-end">
                <div class="col-auto">
                    <div class="sectionTitle -md">
                        <h2 class="sectionTitle__title"><?php echo e(__("You might also like")); ?></h2>
                        <p class=" sectionTitle__text mt-5 sm:mt-0"></p>
                    </div>
                </div>
                <div class="col-auto">
                    <a href="<?php echo e(route('hotel.search', ['location_id' => $row->location_id])); ?>" class="button h-50 px-24 -blue-1 bg-blue-1-05 text-blue-1">
                        <?php echo e(__('See All')); ?> <div class="icon-arrow-top-right ml-15"></div>
                    </a>
                </div>
            </div>
            <div class="row y-gap-30 pt-40 sm:pt-20">
                <?php $__currentLoopData = $hotel_related; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-xl-3 col-lg-3 col-sm-6">
                        <?php echo $__env->make('Hotel::frontend.layouts.search.loop-grid', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH E:\Gabriel code site\themes/GoTrip/Hotel/Views/frontend/layouts/details/hotel-related.blade.php ENDPATH**/ ?>