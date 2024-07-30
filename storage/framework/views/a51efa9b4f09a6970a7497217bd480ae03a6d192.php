<?php
$footerStyle = !empty($row->footer_style) ? $row->footer_style : setting_item('footer_style','normal');
$mailchimp_classes = "bg-dark-2";
$button_classes = "bg-blue-1 text-white";
if($footerStyle == "style_6"){
    $mailchimp_classes = "bg-blue-1";
    $button_classes = "bg-yellow-1 text-dark-1";
}
?>
<section class="layout-pt-md layout-pb-md mailchimp <?php echo e($mailchimp_classes); ?> <?php if((!empty($row) && !empty($row->disable_subscribe_default) ) || !empty($disable_subscribe_default)): ?> d-none <?php endif; ?>">
    <div class="container">
        <div class="row y-gap-30 justify-between items-center">
            <div class="col-auto">
                <div class="row y-gap-20  flex-wrap items-center">
                    <div class="col-auto">
                        <div class="icon-newsletter text-60 sm:text-40 text-white"></div>
                    </div>

                    <div class="col-auto">
                        <h4 class="text-26 text-white fw-600"><?php echo e(__('Your Travel Journey Starts Here')); ?></h4>
                        <div class="text-white"><?php echo e(__("Sign up and we'll send the best deals to you")); ?></div>
                    </div>
                </div>
            </div>

            <div class="col-auto">
                <form action="<?php echo e(route('newsletter.subscribe')); ?>" class="subcribe-form bravo-subscribe-form bravo-form single-field -w-410 d-flex x-gap-10 y-gap-20">
                    <?php echo csrf_field(); ?>
                    <div>
                        <input class="bg-white h-60 email-input" type="text" name="email" placeholder="<?php echo e(__('Your Email')); ?>">
                    </div>
                    <div>
                        <button class="button -md h-60 <?php echo e($button_classes); ?>">
                            <?php echo e(__('Subscribe')); ?> <i class="fa fa-spinner fa-pulse fa-fw"></i>
                        </button>
                    </div>
                    <div class="form-mess"></div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php echo $__env->make('Layout::parts.footer-style.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('Layout::parts.login-register-modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php echo $__env->make('Popup::frontend.popup', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php if(Auth::id()): ?>
    <?php echo $__env->make('Media::browser', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php endif; ?>
<!-- Custom script for all pages -->
<script src="<?php echo e(asset('libs/lodash.min.js')); ?>"></script>
<script src="<?php echo e(asset('libs/jquery-3.6.3.min.js')); ?>"></script>
<script src="<?php echo e(asset('libs/vue/vue'.(!env('APP_DEBUG') ? '.min':'').'.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('themes/gotrip/libs/bs/js/bootstrap.bundle.min.js')); ?>"></script>
<script src="<?php echo e(asset('libs/bootbox/bootbox.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('themes/gotrip/js/vendors.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset('themes/gotrip/js/main.js?_ver='.config('app.asset_version'))); ?>"></script>

<?php echo App\Helpers\MapEngine::scripts(); ?>

<script src="<?php echo e(asset('libs/pusher.min.js')); ?>"></script>

<?php if(Auth::id()): ?>
    <script src="<?php echo e(asset('module/media/js/browser.js?_ver='.config('app.version'))); ?>"></script>
<?php endif; ?>
<script src="<?php echo e(asset('libs/carousel-2/owl.carousel.min.js')); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset("libs/daterange/moment.min.js")); ?>"></script>
<script type="text/javascript" src="<?php echo e(asset("libs/daterange/daterangepicker.min.js")); ?>"></script>
<script src="<?php echo e(asset('libs/select2/js/select2.min.js')); ?>"></script>
<?php if(setting_item('cookie_agreement_enable')==1 and request()->cookie('booking_cookie_agreement_enable') !=1 and !is_api()  and !isset($_COOKIE['booking_cookie_agreement_enable'])): ?>
    <div class="booking_cookie_agreement p-3 d-flex fixed-bottom">
        <div class="content-cookie"><?php echo clean(setting_item_with_lang('cookie_agreement_content')); ?></div>
        <button class="btn save-cookie"><?php echo clean(setting_item_with_lang('cookie_agreement_button_text')); ?></button>
    </div>
    <script>
        var save_cookie_url = '<?php echo e(route('core.cookie.check')); ?>';
    </script>
    <script src="<?php echo e(asset('js/cookie.js?_ver='.config('app.asset_version'))); ?>"></script>
<?php endif; ?>


<script src="<?php echo e(asset('themes/gotrip/dist/frontend/js/gotrip.js?_ver='.config('app.asset_version'))); ?>"></script>

<?php if(request('preview')): ?>
    <script src="<?php echo e(asset('themes/gotrip/module/template/preview.js?_ver='.config('app.asset_version'))); ?>"></script>
<?php endif; ?>

<?php \App\Helpers\ReCaptchaEngine::scripts() ?>
<?php echo $__env->yieldPushContent('js'); ?>

<?php /**PATH E:\Gabriel code site\themes/GoTrip/Layout/parts/footer.blade.php ENDPATH**/ ?>