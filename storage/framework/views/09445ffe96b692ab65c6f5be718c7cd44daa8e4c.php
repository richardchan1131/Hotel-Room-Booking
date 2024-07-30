<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="<?php echo e($html_class ?? ''); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php ($favicon = setting_item('site_favicon')); ?>
    <link rel="icon" type="image/png" href="<?php echo e(!empty($favicon)?get_file_url($favicon,'full'):url('images/favicon.png')); ?>" />
    <?php echo $__env->make('Layout::parts.seo-meta', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Jost:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <link href="<?php echo e(asset('libs/bootstrap/css/bootstrap.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('libs/font-awesome/css/font-awesome.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('libs/ionicons/css/ionicons.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('libs/icofont/icofont.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('dist/frontend/css/notification.css')); ?>" rel="newest stylesheet">
    <link href="<?php echo e(asset('dist/frontend/css/app.css?_ver='.config('app.asset_version'))); ?>" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("libs/daterange/daterangepicker.css")); ?>" >
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset("libs/select2/css/select2.min.css")); ?>" >
    <link href="<?php echo e(asset('themes/gotrip/css/vendors.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('themes/gotrip/css/main.css')); ?>" rel="stylesheet">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="<?php echo e(asset('dist/frontend/module/user/css/user.css?_ver='.config('app.asset_version'))); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('themes/gotrip/dist/frontend/css/app.css?_v='.config('app.asset_version'))); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('themes/gotrip/dist/frontend/css/user.css?_v='.config('app.asset_version'))); ?>">
    <?php echo $__env->make('Layout::parts.global-script', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <script>
        var image_editer = {
            language: '<?php echo e(app()->getLocale()); ?>',
            translations: {
        <?php echo e(app()->getLocale()); ?>: {
            'header.image_editor_title': '<?php echo e(__('Image Editor')); ?>',
                'header.toggle_fullscreen': '<?php echo e(__('Toggle fullscreen')); ?>',
                'header.close': '<?php echo e(__('Close')); ?>',
                'header.close_modal': '<?php echo e(__('Close window')); ?>',
                'toolbar.download': '<?php echo e(__('Save Change')); ?>',
                'toolbar.save': '<?php echo e(__('Save')); ?>',
                'toolbar.apply': '<?php echo e(__('Apply')); ?>',
                'toolbar.saveAsNewImage': '<?php echo e(__('Save As New Image')); ?>',
                'toolbar.cancel': '<?php echo e(__('Cancel')); ?>',
                'toolbar.go_back': '<?php echo e(__('Go Back')); ?>',
                'toolbar.adjust': '<?php echo e(__('Adjust')); ?>',
                'toolbar.effects': '<?php echo e(__('Effects')); ?>',
                'toolbar.filters': '<?php echo e(__('Filters')); ?>',
                'toolbar.orientation': '<?php echo e(__('Orientation')); ?>',
                'toolbar.crop': '<?php echo e(__('Crop')); ?>',
                'toolbar.resize': '<?php echo e(__('Resize')); ?>',
                'toolbar.watermark': '<?php echo e(__('Watermark')); ?>',
                'toolbar.focus_point': '<?php echo e(__('Focus point')); ?>',
                'toolbar.shapes': '<?php echo e(__('Shapes')); ?>',
                'toolbar.image': '<?php echo e(__('Image')); ?>',
                'toolbar.text': '<?php echo e(__('Text')); ?>',
                'adjust.brightness': '<?php echo e(__('Brightness')); ?>',
                'adjust.contrast': '<?php echo e(__('Contrast')); ?>',
                'adjust.exposure': '<?php echo e(__('Exposure')); ?>',
                'adjust.saturation': '<?php echo e(__('Saturation')); ?>',
                'orientation.rotate_l': '<?php echo e(__('Rotate Left')); ?>',
                'orientation.rotate_r': '<?php echo e(__('Rotate Right')); ?>',
                'orientation.flip_h': '<?php echo e(__('Flip Horizontally')); ?>',
                'orientation.flip_v': '<?php echo e(__('Flip Vertically')); ?>',
                'pre_resize.title': '<?php echo e(__('Would you like to reduce resolution before editing the image?')); ?>',
                'pre_resize.keep_original_resolution': '<?php echo e(__('Keep original resolution')); ?>',
                'pre_resize.resize_n_continue': '<?php echo e(__('Resize & Continue')); ?>',
                'footer.reset': '<?php echo e(__('Reset')); ?>',
                'footer.undo': '<?php echo e(__('Undo')); ?>',
                'footer.redo': '<?php echo e(__('Redo')); ?>',
                'spinner.label': '<?php echo e(__('Processing...')); ?>',
                'warning.too_big_resolution': '<?php echo e(__('The resolution of the image is too big for the web. It can cause problems with Image Editor performance.')); ?>',
                'common.x': '<?php echo e(__('x')); ?>',
                'common.y': '<?php echo e(__('y')); ?>',
                'common.width': '<?php echo e(__('width')); ?>',
                'common.height': '<?php echo e(__('height')); ?>',
                'common.custom': '<?php echo e(__('custom')); ?>',
                'common.original': '<?php echo e(__('original')); ?>',
                'common.square': '<?php echo e(__('square')); ?>',
                'common.opacity': '<?php echo e(__('Opacity')); ?>',
                'common.apply_watermark': '<?php echo e(__('Apply watermark')); ?>',
                'common.url': '<?php echo e(__('URL')); ?>',
                'common.upload': '<?php echo e(__('Upload')); ?>',
                'common.gallery': '<?php echo e(__('Gallery')); ?>',
                'common.text': '<?php echo e(__('Text')); ?>',
        }
        }
        };
    </script>
    <!-- Styles -->
    <?php echo $__env->yieldPushContent('css'); ?>
    <style type="text/css">
        .bravo_topbar, .bravo_header, .bravo_footer {
            display: none;
        }
        html, body, .bravo_wrap, .bravo_user_profile,
        .bravo_user_profile > .container-fluid > .row-eq-height > .col-md-3 {
            min-height: 100vh !important;
        }
    </style>
    
    <link href="<?php echo e(route('core.style.customCss')); ?>" rel="stylesheet">
    <?php if(setting_item_with_lang('enable_rtl')): ?>
        <link href="<?php echo e(asset('themes/gotrip/dist/frontend/css/rtl.css')); ?>" rel="stylesheet">
    <?php endif; ?>
    <link href="<?php echo e(asset('libs/carousel-2/owl.carousel.css')); ?>" rel="stylesheet">
    <?php if(setting_item_with_lang('enable_rtl')): ?>
        <link href="<?php echo e(asset('dist/frontend/css/rtl.css')); ?>" rel="stylesheet">
    <?php endif; ?>
</head>
<body class="user-page <?php echo e($body_class ?? ''); ?> <?php if(setting_item_with_lang('enable_rtl')): ?> is-rtl <?php endif; ?>">
<?php if(!is_demo_mode()): ?>
    <?php echo setting_item('body_scripts'); ?>

<?php endif; ?>
<div class="bravo_wrap">
    <div class="header-margin"></div>
    <?php echo $__env->make('Layout::parts.user.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <div class="dashboard bravo_user_profile p-0" data-x="dashboard" data-x-toggle="-is-sidebar-open">
        <?php echo $__env->make('User::frontend.layouts.sidebar', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="dashboard__main">
            <div class="dashboard__content bg-light-2">
                <?php echo $__env->yieldContent('content'); ?>
                <?php echo $__env->make( 'Layout::parts.user.footer' , \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
        <div class="modal" tabindex="-1" id="modal_booking_detail">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo e(__('Booking ID: #')); ?> <span class="user_id"></span></h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex justify-content-center"><?php echo e(__("Loading...")); ?></div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo e(asset('libs/filerobot-image-editor/filerobot-image-editor.min.js?_ver='.config('app.asset_version'))); ?>"></script>
<?php if(!is_demo_mode()): ?>
    <?php echo setting_item('footer_scripts'); ?>

<?php endif; ?>
</body>
</html>
<?php /**PATH /home/r114961reze/public_html/themes/GoTrip/Layout/user.blade.php ENDPATH**/ ?>