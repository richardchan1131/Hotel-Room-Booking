<?php switch($style):
    case ('carousel'): ?> <?php echo $__env->make("Template::frontend.blocks.form-search-all-service.style-normal", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <?php break; ?>
    <?php case ('carousel_v2'): ?> <?php echo $__env->make("Template::frontend.blocks.form-search-all-service.carousel_v2", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <?php break; ?>
    <?php case ('carousel_v3'): ?> <?php echo $__env->make("Template::frontend.blocks.form-search-all-service.carousel_v3", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <?php break; ?>
    <?php case ('normal2'): ?> <?php echo $__env->make("Template::frontend.blocks.form-search-all-service.style-normal-2", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?> <?php break; ?>
    <?php default: ?> <?php echo $__env->make("Template::frontend.blocks.form-search-all-service.style-normal", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endswitch; ?>
<?php /**PATH E:\Gabriel code site\themes/GoTrip/Template/Views/frontend/blocks/form-search-all-service/index.blade.php ENDPATH**/ ?>