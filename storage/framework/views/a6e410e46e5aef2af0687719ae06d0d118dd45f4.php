<div class="modal fade login" id="confirm_password" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content relative">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo e(__('Confirm password')); ?></h4>
                <span class="c-pointer" data-dismiss="modal" aria-label="Close">
                    <i class="input-icon field-icon fa">
                        <img src="<?php echo e(url('images/ico_close.svg')); ?>" alt="close">
                    </i>
                </span>
            </div>
            <div class="modal-body relative">
                <form class="bc-form-confirm-password bc-form" method="POST" action="<?php echo e(route('password.confirm')); ?>">
                    <div class="form-group">
                        <input type="password" class="form-control" name="password"  placeholder="<?php echo e(__('Password')); ?>">
                        <span class="invalid-feedback error error-password"></span>
                    </div>
                    <div class="error message-error invalid-feedback"></div>
                    <div class="form-group">
                        <button class="btn btn-primary form-submit" type="submit">
                            <?php echo e(__('Confirm')); ?>

                            <span class="spinner-grow spinner-grow-sm icon-loading" role="status" aria-hidden="true"></span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/r114961reze/public_html/resources/views/auth/confirm-password-modal.blade.php ENDPATH**/ ?>