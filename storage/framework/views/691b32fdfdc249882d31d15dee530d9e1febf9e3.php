<?php if($row->general_info): ?>
    <div id="go_to_map_content" class="pt-30 mt-30 border-top-light"></div>
    <div class="row y-gap-20">
        <div class="col-12">
            <h2 class="text-22 fw-500"><?php echo e(__('General info')); ?></h2>
        </div>
        <?php if(!empty($row->general_info)): ?>
            <?php if(!is_array($row->general_info)) $row->general_info = json_decode($row->general_info,true); ?>
            <?php $__currentLoopData = $row->general_info; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="col-xl-3 col-6">
                    <div class="text-15"><?php echo e($item['title']); ?></div>
                    <div class="fw-500"><?php echo e($item['desc']); ?></div>
                    <div class="text-15 text-light-1"><?php echo e($item['content']); ?></div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </div>
    <div class="mt-30 border-top-light"></div>
<?php endif; ?>
<?php /**PATH /home/r114961reze/public_html/themes/GoTrip/Location/Views/frontend/layouts/details/location-general-info.blade.php ENDPATH**/ ?>