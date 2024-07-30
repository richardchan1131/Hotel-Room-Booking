<?php if($paginator->hasPages()): ?>
    <div class="border-top-light mt-30 pt-30 custom-pagination">
        <div class="row x-gap-10 y-gap-20 justify-between md:justify-center">
            
            <?php if($paginator->onFirstPage()): ?>
                <div class="col-auto md:order-1 disabled p-item">
                    <span class="button -blue-1 size-40 rounded-full border-light p-link">
                        <i class="icon-chevron-left text-12"></i>
                    </span>
                </div>
            <?php else: ?>
                <div class="col-auto md:order-1 p-item">
                    <a href="<?php echo e($paginator->previousPageUrl()); ?>" class="button -blue-1 size-40 rounded-full border-light p-link">
                        <i class="icon-chevron-left text-12"></i>
                    </a>
                </div>
            <?php endif; ?>

            
            <div class="col-md-auto md:order-3">
                <div class="row x-gap-20 y-gap-20 items-center md:d-none">
                    <?php $__currentLoopData = $elements; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $element): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        
                        <?php if(is_string($element)): ?>
                            <div class="col-auto p-item">
                                <div class="size-40 flex-center rounded-full p-link"><?php echo e($element); ?></div>
                            </div>
                        <?php endif; ?>

                        
                        <?php if(is_array($element)): ?>
                            <?php $__currentLoopData = $element; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $page => $url): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php if($page == $paginator->currentPage()): ?>
                                    <div class="col-auto active p-item">
                                        <div class="size-40 flex-center rounded-full p-link"><?php echo e($page); ?></div>
                                    </div>
                                <?php else: ?>
                                    <div class="col-auto p-item">
                                        <a href="<?php echo e($url); ?>" class="size-40 flex-center rounded-full p-link"><?php echo e($page); ?></a>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>


            
            <?php if($paginator->hasMorePages()): ?>
                <div class="col-auto md:order-2 p-item">
                    <a href="<?php echo e($paginator->nextPageUrl()); ?>" class="button -blue-1 size-40 rounded-full border-light">
                        <i class="icon-chevron-right text-12"></i>
                    </a>
                </div>
            <?php else: ?>
                <div class="col-auto md:order-2 disabled p-item">
                    <span href="<?php echo e($paginator->nextPageUrl()); ?>" class="button -blue-1 size-40 rounded-full border-light">
                        <i class="icon-chevron-right text-12"></i>
                    </span>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH E:\Gabriel code site\themes\GoTrip\resources\views/vendor/pagination/default.blade.php ENDPATH**/ ?>