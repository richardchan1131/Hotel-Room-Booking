<div class="row x-gap-20 y-gap-20">
    <div class="col-auto">
        <div class="item d-flex align-items-center">
            <?php
                $param = request()->input();
                $orderby =  request()->input("orderby");
            ?>
            <div class="mr-5">
                <?php echo e(__("Sort by:")); ?>

            </div>
            <input type="hidden" name="orderby" value="<?php echo e($orderby); ?>">
            <div class="dropdown orderby">
                <span class="button -blue-1 h-40 px-20 rounded-100 bg-blue-1-05 text-15 text-blue-1"  data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="icon-up-down text-14 mr-10"></i>
                    <span class="dropdown-toggle">
                        <?php switch($orderby):
                            case ("price_low_high"): ?>
                                <?php echo e(__("Price (Low to high)")); ?>

                                <?php break; ?>
                            <?php case ("price_high_low"): ?>
                                <?php echo e(__("Price (High to low)")); ?>

                                <?php break; ?>
                            <?php case ("rate_high_low"): ?>
                                <?php echo e(__("Rating (High to low)")); ?>

                                <?php break; ?>
                            <?php default: ?>
                                <?php echo e(__("Recommended")); ?>

                        <?php endswitch; ?>
                        </span>
                </span>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item" href="#" data-value=""><?php echo e(__("Recommended")); ?></a>
                    <a class="dropdown-item" href="#" data-value="price_low_high"><?php echo e(__("Price (Low to high)")); ?></a>
                    <a class="dropdown-item" href="#" data-value="price_high_low"><?php echo e(__("Price (High to low)")); ?></a>
                    <a class="dropdown-item" href="#" data-value="rate_high_low"><?php echo e(__("Rating (High to low)")); ?></a>
                </div>
            </div>
        </div>
    </div>
    <?php if(empty($hidden_map_button)): ?>
        <div class="col-auto">
            <button class="button -blue-1 h-40 px-20 rounded-100 bg-blue-1-05 text-15 text-blue-1" onclick="window.location.href='<?php echo e(route($routeName,['_layout'=>'map'])); ?>'">
                <?php echo e(__("Show on the map")); ?>

            </button>
        </div>
        <div class="col-auto d-none lg:d-block">
            <button data-x-click="filterPopup" class="button -blue-1 h-40 px-20 rounded-100 bg-blue-1-05 text-15 text-blue-1">
                <i class="icon-up-down text-14 mr-10"></i>
                <?php echo e(__('Filter')); ?>

            </button>
        </div>
    <?php endif; ?>
</div>
<?php /**PATH /home/r114961reze/public_html/themes/GoTrip/Layout/global/search/orderby.blade.php ENDPATH**/ ?>