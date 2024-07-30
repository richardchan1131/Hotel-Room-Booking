<form action="#" class="form bravo-form-register" method="post">
    <?php echo csrf_field(); ?>
    <div class="row y-gap-20">
        <div class="col-12">
            <h1 class="text-22 fw-500"><?php echo e(__('Sign in or create an account')); ?></h1>
            <p class="mt-10"><?php echo e(__('Already have an account?')); ?> <a data-bs-toggle="modal" href="#login" class="text-blue-1"><?php echo e(__('Log in')); ?></a></p>
        </div>
        <div class="col-12">
            <div class="form-input">
                <input type="text" name="first_name" autocomplete="off">
                <label class="lh-1 text-14 text-light-1"><?php echo e(__('First Name')); ?></label>
            </div>
            <span class="invalid-feedback error error-first_name"></span>
        </div>
        <div class="col-12">
            <div class="form-input">
                <input type="text" name="last_name" autocomplete="off">
                <label class="lh-1 text-14 text-light-1"><?php echo e(__('Last Name')); ?></label>
            </div>
            <span class="invalid-feedback error error-last_name"></span>
        </div>
        <div class="col-12">
            <div class="form-input">
                <input type="text" name="phone" autocomplete="off">
                <label class="lh-1 text-14 text-light-1"><?php echo e(__('Phone')); ?></label>
            </div>
            <span class="invalid-feedback error error-phone"></span>
        </div>
        <div class="col-12">
            <div class="form-input">
                <input type="email" name="email" autocomplete="off">
                <label class="lh-1 text-14 text-light-1"><?php echo e(__('Email address')); ?></label>
            </div>
            <span class="invalid-feedback error error-email"></span>
        </div>
        <div class="col-12">
            <div class="form-input">
                <input type="password" name="password" autocomplete="off">
                <label class="lh-1 text-14 text-light-1"><?php echo e(__('Password')); ?></label>
            </div>
            <span class="invalid-feedback error error-password"></span>
        </div>
        <div class="col-12">
            <div class="d-flex">
                <div class="form-checkbox" style="margin-top: 3px">
                    <input type="checkbox" name="term" id="register-term">
                    <div class="form-checkbox__mark">
                        <div class="form-checkbox__icon icon-check"></div>
                    </div>
                </div>
                <label class="text-15 lh-15 text-light-1 ml-10" for="register-term"><?php echo e(__('I have read and accept the Terms and Privacy Policy?')); ?></label>
            </div>
            <span class="invalid-feedback error error-term"></span>
        </div>
        <?php if(setting_item("user_enable_register_recaptcha")): ?>
            <div class="form-group">
                <?php echo e(recaptcha_field($captcha_action ?? 'register')); ?>

            </div>
            <div><span class="invalid-feedback error error-g-recaptcha-response"></span></div>
        <?php endif; ?>
        <div class="error message-error invalid-feedback"></div>

        <div class="col-12">
            <button type="submit" class="button py-20 -dark-1 bg-blue-1 text-white w-100">
                <?php echo e(__('Sign Up')); ?> <div class="icon-arrow-top-right ml-15"></div>
            </button>
        </div>
    </div>
    <?php if(setting_item('facebook_enable') or setting_item('google_enable') or setting_item('twitter_enable')): ?>
        <div class="row y-gap-20 pt-30">
            <div class="col-12">
                <div class="text-center"><?php echo e(__('or sign in with')); ?></div>
            </div>
            <?php if(setting_item('facebook_enable')): ?>
                <a href="<?php echo e(url('/social-login/facebook')); ?>" class="button col-12 -outline-blue-1 text-blue-1 py-15 rounded-8 mt-10" data-channel="facebook">
                    <i class="fa fa-facebook text-15 mr-10"></i> <?php echo e(__('Login with Facebook')); ?>

                </a>
            <?php endif; ?>
            <?php if(setting_item('google_enable')): ?>
                <a href="<?php echo e(url('social-login/google')); ?>" class="button col-12 -outline-red-1 text-red-1 py-15 rounded-8 mt-15">
                    <i class="fa fa-google text-15 mr-10"></i> <?php echo e(__('Login with Google')); ?>

                </a>
            <?php endif; ?>
            <?php if(setting_item('twitter_enable')): ?>
                <a href="<?php echo e(url('social-login/twitter')); ?>" class="button col-12 -outline-dark-2 text-dark-2 py-15 rounded-8 mt-15">
                    <i class="fa fa-twitter text-15 mr-10"></i> <?php echo e(__('Login with Twitter')); ?>

                </a>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</form>
<?php /**PATH E:\Gabriel code site\themes/GoTrip/Layout/auth/register-form.blade.php ENDPATH**/ ?>