<form class="bravo-theme-gotrip-login-form y-gap-20" method="POST" action="<?php echo e(route('login')); ?>">
    <input type="hidden" name="redirect" value="<?php echo e(request()->query('redirect')); ?>">
    <?php echo csrf_field(); ?>
    <div class="col-12">
        <h4 class="form-title text-22 fw-500"><?php echo e(__('Welcome back')); ?></h4>
        <?php if(is_enable_registration()): ?>
            <p class="mt-10"><?php echo e(__("Don't have an account yet?")); ?> <a data-bs-toggle="modal" href="#register" class="text-blue-1"><?php echo e(__('Sign up for free')); ?></a></p>
        <?php endif; ?>
    </div>
    <div class="col-12">
        <div class="form-input">
            <input type="text" name="email" autocomplete="off">
            <label class="lh-1 text-14 text-light-1"><?php echo e(__('Email')); ?></label>
        </div>
    </div>
    <div class="col-12">
        <div class="form-input">
            <input type="password" name="password" autocomplete="off">
            <label class="lh-1 text-14 text-light-1"><?php echo e(__('Password')); ?></label>
        </div>
    </div>
    <div class="col-12 d-flex justify-content-between">
        <div class="d-flex ">
            <div class="form-checkbox" style="margin-top: 3px">
                <input type="checkbox" name="remember" id="remember-me" value="1">
                <div class="form-checkbox__mark">
                    <div class="form-checkbox__icon icon-check"></div>
                </div>
            </div>
            <div class="text-15 lh-15 text-light-1 ml-10"><?php echo e(__('Remember me')); ?></div>
        </div>
        <a href="<?php echo e(route("password.request")); ?>"><?php echo e(__('Forgot Password?')); ?></a>
    </div>
    <?php if(setting_item("user_enable_login_recaptcha")): ?>
        <div class="col-12">
            <div class="form-group">
                <?php echo e(recaptcha_field($captcha_action ?? 'login')); ?>

            </div>
        </div>
    <?php endif; ?>
    <div class="error message-error invalid-feedback"></div>
    <div class="col-12">
        <button class="button py-20 -dark-1 bg-blue-1 text-white w-100 form-submit" type="submit">
            <?php echo e(__('Sign In')); ?>

            <div class="icon-arrow-top-right ml-15"></div>
            <span class="spinner-grow spinner-grow-sm icon-loading ml-15 d-none" role="status" aria-hidden="true"></span>
        </button>
    </div>
    <?php if(setting_item('facebook_enable') or setting_item('google_enable') or setting_item('twitter_enable')): ?>
        <div class="advanced y-gap-20">
            <div class="col-12">
                <div class="text-center"><?php echo e(__('or sign in with')); ?></div>
                <?php if(setting_item('facebook_enable')): ?>
                    <a href="<?php echo e(url('/social-login/facebook')); ?>" class="button col-12 -outline-blue-1 text-blue-1 py-15 rounded-8 mt-10 cursor-pointer">
                        <i class="fa fa-facebook text-15 mr-10"></i>
                        <?php echo e(__('Facebook')); ?>

                    </a>
                <?php endif; ?>
                <?php if(setting_item('google_enable')): ?>
                    <a href="<?php echo e(url('social-login/google')); ?>" class="button col-12 -outline-red-1 text-red-1 py-15 rounded-8 mt-15 cursor-pointer" data-channel="google">
                        <i class="fa fa-google text-15 mr-10"></i>
                        <?php echo e(__('Google')); ?>

                    </a>
                <?php endif; ?>
                <?php if(setting_item('twitter_enable')): ?>
                    <a href="<?php echo e(url('social-login/twitter')); ?>" class="button col-12 -outline-dark-2 text-dark-2 py-15 rounded-8 mt-15 cursor-pointer" data-channel="twitter">
                        <i class="fa fa-twitter text-15 mr-10"></i>
                        <?php echo e(__('Twitter')); ?>

                    </a>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
    <div class="col-12">
        <div class="text-center px-30"><?php echo e(__('By creating an account, you agree to our Terms of Service and Privacy Statement.')); ?></div>
    </div>
</form>
<?php /**PATH /home/r114961reze/public_html/themes/GoTrip/Layout/auth/login-form.blade.php ENDPATH**/ ?>