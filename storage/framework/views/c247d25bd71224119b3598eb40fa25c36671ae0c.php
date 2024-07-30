<?php $types = get_bookable_services() ?>
<?php if(!empty($types)): ?>
    <?php $i = 0 ;$not_in =['flight']?>
    <?php $__currentLoopData = $types; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type=>$moduleClass): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            if(!$moduleClass::isEnable() or in_array($type,$not_in)==true) continue;
            $moduleInst = new $moduleClass();
            $services = $moduleInst->select($moduleInst::getTableName().'.*')
            ->join('bravo_locations', function ($join) use ($row,$moduleInst) {
                $join->on('bravo_locations.id', '=', $moduleInst::getTableName().'.location_id')
                    ->where('bravo_locations._lft', '>=', $row->_lft)
                    ->where('bravo_locations._rgt', '<=', $row->_rgt);
            })
            ->where($moduleInst::getTableName().'.status','publish')->with('location')->take(8)->get();
        ?>
        <?php if($services->count()>0): ?>

            <section class="layout-pt-md layout-pb-md bravo-location-service-list">
                <div class="row y-gap-20 justify-between items-end">
                    <div class="col-auto">
                        <div class="sectionTitle -md">
                            <h2 class="sectionTitle__title"><?php echo e(__('Most Popular :name',['name'=> call_user_func([$moduleClass,'getModelName']) ])); ?></h2>
                            <p class=" sectionTitle__text mt-5 sm:mt-0"><?php echo e(__("Interdum et malesuada fames ac ante ipsum")); ?></p>
                        </div>
                    </div>

                    <div class="col-auto">
                        <a href="<?php echo e($row->getLinkForPageSearch($type)); ?>" class="button -md -blue-1 bg-blue-1-05 text-blue-1">
                            <?php echo e(__('View More')); ?> <div class="icon-arrow-top-right ml-15"></div>
                        </a>
                    </div>
                </div>
                <div class="row y-gap-30 pt-40 sm:pt-20">
                    <?php $__currentLoopData = $services; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $service): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xl-3 col-lg-3 col-sm-6 loop-type-<?php echo e($type); ?>">
                            <?php
                                $view = ucfirst($type).'::frontend.layouts.search.loop-grid';
                            ?>
                            <?php if(view()->exists($view)): ?>
                                <?php echo $__env->make($view,['row' => $service], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <?php endif; ?>

                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </section>
            <?php $i++ ?>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>
<?php /**PATH /home/r114961reze/public_html/themes/GoTrip/Location/Views/frontend/layouts/details/location-service.blade.php ENDPATH**/ ?>