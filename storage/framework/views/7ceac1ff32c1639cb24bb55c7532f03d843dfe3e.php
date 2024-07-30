
<?php $__env->startSection('content'); ?>
    <?php
    $user = \Illuminate\Support\Facades\Auth::user();
    $hasAvailableTools = false;
    ?>
    <div class="container">
        <div class="row">
            <div class="col-md-1"></div>
            <div class="col-md-10">
                <div class="d-flex justify-content-between mb20">
                    <h1 class="title-bar"><?php echo e(__('Tools')); ?></h1>
                </div>
                <?php echo $__env->make('admin.message', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <div class="panel">
                    <div class="panel-body pd15">
                        <div class="row area-setting-row">
                            <?php if($user->hasPermission('setting_update')): ?>
                                <?php $hasAvailableTools = true; ?>
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" href="<?php echo e(route('core.admin.module.index')); ?>">
                                        <span class="setting-item-media">
                                            <i class="icon ion-md-color-wand"></i>
                                        </span>
                                            <span class="setting-item-info">
                                            <span class="setting-item-title"><?php echo e(__("Modules")); ?></span>
                                            <span class="setting-item-desc"><?php echo e(__("Modules for Booking Core")); ?></span>
                                        </span>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if($user->hasPermission('language_manage')): ?>
                                <?php $hasAvailableTools = true; ?>
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" href="<?php echo e(route('language.admin.index')); ?>">
                                            <span class="setting-item-media">
                                                <i class="icon ion-ios-globe"></i>
                                            </span>
                                            <span class="setting-item-info">
                                                <span class="setting-item-title"><?php echo e(__("Languages")); ?></span>
                                                <span class="setting-item-desc"><?php echo e(__("Manage languages of your website")); ?></span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if($user->hasPermission('language_translation')): ?>
                                <?php $hasAvailableTools = true; ?>
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" href="<?php echo e(route('language.admin.translations.index')); ?>">
                                            <span class="setting-item-media">
                                                <i class="icon ion-ios-globe"></i>
                                            </span>
                                            <span class="setting-item-info">
                                                <span class="setting-item-title"><?php echo e(__("Translations")); ?></span>
                                                <span class="setting-item-desc"><?php echo e(__("Translation manager of your website")); ?></span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if($user->hasPermission('system_log_view')): ?>
                                <?php $hasAvailableTools = true; ?>
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" href="<?php echo e(url('admin/logs')); ?>">
                                                <span class="setting-item-media">
                                                    <i class="icon ion-ios-nuclear"></i>
                                                </span>
                                            <span class="setting-item-info">
                                                <span class="setting-item-title"><?php echo e(__("System Log Viewer")); ?></span>
                                                <span class="setting-item-desc"><?php echo e(__("Views and manage system log of your website")); ?></span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                            <?php if($user->hasPermission('system_log_view')): ?>
                                <?php $hasAvailableTools = true; ?>
                                <div class="col-md-4 d-none">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" href="<?php echo e(route('core.admin.updater.index')); ?>">
                                        <span class="setting-item-media">
                                            <i class="icon ion-ios-nuclear"></i>
                                        </span>
                                            <span class="setting-item-info">
                                            <span class="setting-item-title"><?php echo e(__("Updater")); ?></span>
                                            <span class="setting-item-desc"><?php echo e(__("Updater Booking Core")); ?></span>
                                        </span>
                                        </a>
                                    </div>
                                </div>
                            <?php endif; ?>
                                <div class="col-md-4">
                                    <div class="area-setting-item">
                                        <a class="setting-item-link" href="<?php echo e(route('core.tool.clearCache')); ?>">
                                        <span class="setting-item-media">
                                            <i class="icon ion-ios-hammer"></i>
                                        </span>
                                            <span class="setting-item-info">
                                            <span class="setting-item-title"><?php echo e(__("Clear Cache")); ?></span>
                                            <span class="setting-item-desc"><?php echo e(__("Clear Cache for Booking Core")); ?></span>
                                        </span>
                                        </a>
                                    </div>
                                </div>
                            <?php if(!$hasAvailableTools): ?>
                                <div class="col-md-12">
                                    <?php echo e(__("No tools available")); ?>

                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/r114961reze/public_html/modules/Core/Views/admin/tools/index.blade.php ENDPATH**/ ?>