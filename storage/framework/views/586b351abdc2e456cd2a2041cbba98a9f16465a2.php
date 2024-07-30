<?php if(!empty($row->location->name)): ?>
    <section class="pb-40">
        <?php $location =  $row->location->translate() ?>
        <div class="<?php echo e($class_container ?? "container"); ?>">
            <h3 class="text-22 fw-500 mb-10"><?php echo e(__('Where you’ll be')); ?></h3>
            <div class="mb-20"><?php echo e($location->name ?? ''); ?></div>
            <?php if($row->map_lat && $row->map_lng): ?>
                <div class="g-location">
                    <div class="location-map">
                        <div id="map_content" class="map rounded-4 map-500"></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH /home/r114961reze/public_html/themes/GoTrip/Layout/map/detail/map.blade.php ENDPATH**/ ?>