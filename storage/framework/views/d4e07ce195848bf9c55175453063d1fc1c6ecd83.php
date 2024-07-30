<?php if($layout == 'grid'): ?>
    <div class="pt-30 mt-30 border-top-light"></div>
<?php else: ?>
    <div class="pt-30"></div>
<?php endif; ?>

<div class="row y-gap-30">
    <?php if($rows->total() > 0): ?>
        <?php $__currentLoopData = $rows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $row): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

            <?php if($layout == 'grid'): ?>
                <div class="col-lg-4 col-sm-6">
                    <?php echo $__env->make('Hotel::frontend.layouts.search.loop-grid',['wrap_class'=>'item-loop-wrap'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            <?php else: ?>
                <div class="col-12">
                    <?php echo $__env->make('Hotel::frontend.layouts.search.loop-list',['wrap_class'=>'item-loop-wrap inner-loop-wrap'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div class="col-lg-12">
            <?php echo e(__("Hotel not found")); ?>

        </div>
    <?php endif; ?>
</div>

<div class="bravo-pagination">
            <?php echo e($rows->appends(request()->except(['_ajax']))->links()); ?>

    <?php if($rows->total() > 0): ?>
        <div class="text-center mt-30 md:mt-10">
            <div class="text-14 text-light-1"><?php echo e(__("Showing :from - :to of :total hotels",["from"=>$rows->firstItem(),"to"=>$rows->lastItem(),"total"=>$rows->total()])); ?></div>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH E:\Gabriel code site\themes/GoTrip/Hotel/Views/frontend/ajax/search-result.blade.php ENDPATH**/ ?>