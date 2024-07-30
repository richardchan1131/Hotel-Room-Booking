<?php
    $actives = \App\Currency::getActiveCurrency();
    $current = \App\Currency::getCurrent('currency_main');
?>

<?php if(!empty($actives) and count($actives) > 1): ?>
    <li class="currency-dropdown menu-item-has-children">
        <?php $__currentLoopData = $actives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($current == $currency['currency_main']): ?>
                <a href="#" class="is_login">
                    <span class="mr-10"><?php echo e(strtoupper($currency['currency_main'])); ?></span>
                    <i class="icon icon-chevron-sm-down"></i>
                </a>
            <?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <ul class="subnav">
            <?php $__currentLoopData = $actives; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if($current != $currency['currency_main']): ?>
                    <li>
                        <a href="<?php echo e(get_currency_switcher_url($currency['currency_main'])); ?>" class="is_login dropdown-item">
                            <?php echo e(strtoupper($currency['currency_main'])); ?>

                        </a>
                    </li>
                <?php endif; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </li>
<?php endif; ?>

<?php /**PATH E:\Gabriel code site\themes/GoTrip/Core/Views/frontend/currency-switcher.blade.php ENDPATH**/ ?>