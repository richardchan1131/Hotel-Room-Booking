<div class="footer_one pt-60 pb-60">
    <div class="row y-gap-40 justify-between xl:justify-start">
        <?php if($list_widget_footers = setting_item_with_lang("list_widget_footer")): ?>
            <?php $list_widget_footers = json_decode($list_widget_footers); ?>
            <?php $__currentLoopData = $list_widget_footers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-xl-2 col-lg-3 col-sm-6">
                    <h5 class="text-16 fw-500 mb-30"><?php echo e($item->title); ?></h5>
                    <?php echo $item->content; ?>

                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH E:\Gabriel code site\themes/GoTrip/Layout/parts/footer-style/normal.blade.php ENDPATH**/ ?>