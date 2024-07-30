<div class="g-rules border-bottom-light mt-40 pb-50">
    <h3 class="text-22 fw-500"><?php echo e(__("Hotel Rules - Policies")); ?></h3>
    <div class="description pt-10">
        <div class="row">
            <div class="col-lg-4">
                <div class="key"><?php echo e(__("Check In")); ?></div>
            </div>
            <div class="col-lg-8">
                <div class="value">	<?php echo e($row->check_in_time); ?> </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4">
                <div class="key"><?php echo e(__("Check Out")); ?></div>
            </div>
            <div class="col-lg-8">
                <div class="value">	<?php echo e($row->check_out_time); ?> </div>
            </div>
        </div>
        <?php if($translation->policy): ?>
            <div class="row">
                <div class="col-lg-4">
                    <div class="key"><?php echo e(__("Hotel Policies")); ?></div>
                </div>
                <div class="col-lg-8">
                    <?php $__currentLoopData = $translation->policy; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="item <?php if($key > 1): ?> d-none <?php endif; ?>">
                            <div class="strong fw-500"><?php echo e($item['title']); ?></div>
                            <div class="context"><?php echo $item['content']; ?></div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php if( count($translation->policy) > 2): ?>
                        <div class="btn-show-all text-blue-1 fw-500">
                            <span class="text"><?php echo e(__("Show All")); ?></span>
                            <i class="fa fa-caret-down"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH E:\Gabriel code site\themes/GoTrip/Hotel/Views/frontend/layouts/details/hotel-rules-policy.blade.php ENDPATH**/ ?>