<?php if(!empty($breadcrumbs)): ?>
    <div class="blog-breadcrumb py-10 bg-light-2">
        <div class="container">
            <div class="row y-gap-10 items-center justify-between">
                <div class="col-auto">
                    <ol class="pl-0 ul row x-gap-10 y-gap-5 items-center text-14 text-light-1 list-unstyled" itemscope itemtype="https://schema.org/BreadcrumbList">
                        <li class="col-auto" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                            <a href="<?php echo e(url('/')); ?>" itemprop="item"><span itemprop="name"><?php echo e(__('Home')); ?></span></a>
                            <meta itemprop="position" content="1" />
                        </li>
                        <li class="col-auto">
                            <div class="">></div>
                        </li>
                        <?php $__currentLoopData = $breadcrumbs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k=>$breadcrumb): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($k): ?>
                                <li class="col-auto">
                                    <div class="">></div>
                                </li>
                            <?php endif; ?>
                            <li class="col-auto <?php echo e($breadcrumb['class'] ?? ''); ?>" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
                                <?php if(!empty($breadcrumb['url'])): ?>
                                    <a href="<?php echo e(url($breadcrumb['url'])); ?>" itemscope itemtype="https://schema.org/WebPage" itemprop="item" itemid="<?php echo e(url($breadcrumb['url'])); ?>"><span itemprop="name"><?php echo e($breadcrumb['name']); ?></span></a>
                                <?php else: ?>
                                    <span itemprop="name" class="text-dark-1"><?php echo e($breadcrumb['name']); ?></span>
                                <?php endif; ?>
                                <meta itemprop="position" content="<?php echo e($k + 2); ?>" />
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ol>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/r114961reze/public_html/themes/GoTrip/Layout/parts/bc.blade.php ENDPATH**/ ?>