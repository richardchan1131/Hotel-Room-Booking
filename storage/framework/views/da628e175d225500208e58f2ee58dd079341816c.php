<footer class="footer -dashboard mt-60">
    <div class="footer__row row y-gap-10 items-center justify-between">
        <div class="col-auto">
            <div class="row y-gap-20 items-center">
                <div class="col-auto">
                    <div class="text-14 lh-14 mr-30">
                        <?php echo setting_item_with_lang("footer_text_left") ?? ''; ?>

                    </div>
                </div>
            </div>
        </div>

        <div class="col-auto">
            <div class="d-flex x-gap-5 y-gap-5 items-center">

            </div>
        </div>
    </div>
</footer>

<?php echo $__env->make('Popup::frontend.popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php if(Auth::id()): ?>
    <?php echo $__env->make('Media::browser', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>

<!-- Custom script for all pages -->
<script src="<?php echo e(asset('libs/lodash.min.js')); ?>"></script>
<script src="<?php echo e(asset('libs/jquery-3.6.3.min.js')); ?>"></script>

<?php echo App\Helpers\MapEngine::scripts(); ?>


<script src="<?php echo e(asset('libs/vue/vue'.(!env('APP_DEBUG') ? '.min':'').'.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('themes/gotrip/libs/bs/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('libs/bootbox/bootbox.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('themes/gotrip/js/vendors.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('themes/gotrip/js/main.js')); ?>"></script>
<script src="<?php echo e(asset('libs/pusher.min.js')); ?>"></script>

<?php if(Auth::id()): ?>
    <script src="<?php echo e(asset('module/media/js/browser.js?_ver='.config('app.version'))); ?>"></script>
<?php endif; ?>
<script src="<?php echo e(asset('libs/carousel-2/owl.carousel.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset("libs/daterange/moment.min.js")); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset("libs/daterange/daterangepicker.min.js")); ?>"></script>
<script src="<?php echo e(asset('libs/select2/js/select2.min.js')); ?>"></script>
<script src="<?php echo e(asset('module/user/js/user.js?_ver='.config('app.asset_version'))); ?>"></script>
<?php if(setting_item('cookie_agreement_enable')==1 and request()->cookie('booking_cookie_agreement_enable') !=1 and !is_api()  and !isset($_COOKIE['booking_cookie_agreement_enable'])): ?>
    <div class="booking_cookie_agreement p-3 d-flex fixed-bottom">
        <div class="content-cookie"><?php echo clean(setting_item_with_lang('cookie_agreement_content')); ?></div>
        <button class="btn save-cookie"><?php echo clean(setting_item_with_lang('cookie_agreement_button_text')); ?></button>
    </div>
    <script>
        var save_cookie_url = '<?php echo e(route('core.cookie.check')); ?>';
    </script>
    <script src="<?php echo e(asset('js/cookie.js?_ver='.config('app.version'))); ?>"></script>
<?php endif; ?>


<script src="<?php echo e(asset('themes/gotrip/dist/frontend/js/gotrip.js?_ver='.config('app.version'))); ?>"></script>

<?php \App\Helpers\ReCaptchaEngine::scripts() ?>
<?php if(setting_item('user_enable_2fa')): ?>
    <?php echo $__env->make('auth.confirm-password-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script src="<?php echo e(asset('/module/user/js/2fa.js')); ?>"></script>
<?php endif; ?>
<?php echo $__env->yieldPushContent('js'); ?>

<?php /**PATH /home/r114961reze/public_html/themes/GoTrip/Layout/parts/user/footer.blade.php ENDPATH**/ ?>