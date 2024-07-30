<div class="row justify-content-center">
    <div class="col-md-6">
        <img style="max-width: 100%" src="<?php echo e(asset('images/pro/pro-preview.png')); ?>" alt="">
    </div>
    <div class="col-md-6">
        <div class="py-3 pr-3 h-100">
            <form method="post" action="<?php echo e(route('pro.buy')); ?>" class=" h-100 d-flex flex-column "> <?php echo csrf_field(); ?>
                <h5 class="mb-3">Upgrade to PRO to unlock unlimited access to all of our features, including:</h5>
                <div class="mb-5">
                    <div class="mb-1">
                        <i class="fa fa-check text-success"></i>
                        New modern template
                    </div>
                    <div class="mb-1">
                        <i class="fa fa-check text-success"></i>
                        Support Center plugin
                    </div>
                    <div class="mb-1">
                        <i class="fa fa-check text-success"></i>
                        More Payment gateways
                    </div>
                    <div class="mb-1">
                        ... new features coming soon
                    </div>
                </div>
                <button class="btn btn-info btn-block btn-md mb-3">
                    <img width="32px" class="mr-3" src="<?php echo e(asset('/images/premium.png')); ?>" alt="Upgrade">
                    <strong><?php echo e(__("Upgrade for :price",['price'=>'$'.config('pro.price_yearly')])); ?></strong>
                </button>
                <p class="text-center">
                    <i>* After purchasing, you can download the PRO version</i>
                </p>
            </form>
        </div>
    </div>
</div>
<?php /**PATH /home/r114961reze/public_html/app/Pro/Views/admin/upgrade-form.blade.php ENDPATH**/ ?>