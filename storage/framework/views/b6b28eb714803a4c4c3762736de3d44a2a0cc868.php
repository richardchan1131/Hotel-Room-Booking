<?php
    $selected = (array) Request::query('attrs',[]);
?>
<?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if(empty($item['hide_in_filter_search'])): ?>
        <?php
            $translate = $item->translate();
        ?>
        <div class="sidebar__item g-filter-item">
            <h5 class="text-18 fw-500 mb-10"><?php echo e($translate->name); ?></h5>
            <div class="sidebar-checkbox ">
                <?php $__currentLoopData = $item->terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $translate = $term->translate(); ?>
                    <div class="row y-gap-10 items-center justify-between <?php if($key > 2 and empty($selected[$item->slug])): ?> hide <?php endif; ?>">
                        <div class="col-auto">
                            <label  class="cursor-pointer">
                                <div class="form-checkbox d-flex items-center">
                                    <input <?php if(in_array($term->slug,$selected[$item->slug] ?? [])): ?> checked <?php endif; ?> type="checkbox" name="attrs[<?php echo e($item->slug); ?>][]" value="<?php echo e($term->slug); ?>">
                                    <div class="form-checkbox__mark">
                                        <div class="form-checkbox__icon icon-check"></div>
                                    </div>
                                    <div class="text-15 ml-10"><?php echo $translate->name; ?></div>
                                </div>
                            </label>
                        </div>
                        <div class="col-auto">
                            <div class="text-15 text-light-1"></div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php if(count($item->terms) > 3 and empty($selected[$item->slug])): ?>
                    <button type="button" class="btn btn-link btn-more-item"><?php echo e(__("More")); ?> <i class="fa fa-caret-down"></i></button>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php /**PATH E:\Gabriel code site\themes/GoTrip/Layout/global/search/filters/attrs.blade.php ENDPATH**/ ?>