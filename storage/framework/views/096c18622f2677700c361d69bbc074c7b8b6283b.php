<?php
    $headerStyle = (!empty($row->header_style)) ? $row->header_style : 'normal' ;
    $dataBg = 'bg-dark-1';
    $navTextStyle =  'text-white';
    switch ($headerStyle){
        case 'transparent': $headerClass = 'bg-green is-sticky'; break;
        case 'transparent_v2': $headerClass = 'header_2'; break;
        case 'transparent_v3': $headerClass = '-type-2'; break;
        case 'transparent_v4':{
            $headerClass = '-type-5 transparent_v4';
            $dataBg = '-header-5-sticky';
            $navTextStyle = 'text-dark-1';
            break;
        }
        case 'transparent_v5':{
            $headerClass = '';
            $dataBg = 'bg-white';
            $navTextStyle = 'text-dark-1';
            break;
        }
        case 'transparent_v6':
        case 'transparent_v9':{
            $headerClass = '';
            $dataBg = 'bg-white';
            $container_class = 'header__container header__container-1500 mx-auto';
            $navTextStyle = 'text-dark-1';
            break;
        }
        case 'transparent_v7':{
            $headerClass = '';
            $dataBg = 'bg-dark-1';
            $container_class = 'header__container';
            break;
        }
        case 'normal_white':{
            $headerClass = '';
            $navTextStyle = 'text-dark-1';
            $dataBg = 'bg-white';
            break;
        }
        default: $headerClass = '-fixed bg-dark-3';
    }
?>
<?php switch($headerStyle):
    case ("transparent_v8"): ?>
        <?php echo $__env->make("Layout::parts.header-style.transparent_v8", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php break; ?>
    <?php default: ?>
        <header data-add-bg="<?php echo e($dataBg); ?>" class="header <?php echo e($headerClass); ?> js-header bravo_header" data-x="header" data-x-toggle="is-menu-opened">
            <div data-anim="fade" class="<?php echo e($container_class ?? 'header__container'); ?> px-30 sm:px-20 <?php if($headerStyle == 'transparent_v2'): ?> container <?php endif; ?> is-in-view">
                <div class="row justify-between items-center">
                    <div class="col-auto <?php if($headerStyle == 'transparent_v7'): ?> col-left <?php endif; ?>">
                        <?php
                            $logo = setting_item('logo_id');
                            $logoDark = setting_item('logo_id_dark');
                            if($headerStyle == 'transparent_v9') $logo = $logoDark ;
                        ?>
                        <?php if($headerStyle == 'transparent_v2'): ?>
                            <?php echo $__env->make("Layout::parts.header-style.$headerStyle", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            <div class="d-none xl:d-block">
                                <?php echo $__env->make("Layout::parts.header-style.normal", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                            </div>
                        <?php elseif($headerStyle == 'transparent_v4'): ?>
                            <?php echo $__env->make("Layout::parts.header-style.transparent_v2",['textColor' => 'text-dark-1'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php elseif($headerStyle == 'normal_white'): ?>
                            <?php echo $__env->make("Layout::parts.header-style.normal",['textColor' => 'text-dark-1'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php else: ?>
                            <?php echo $__env->make("Layout::parts.header-style.normal", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endif; ?>
                    </div>
            <?php if($headerStyle == 'transparent_v3'): ?>
                <div class="col-auto xl:d-none">
                    <a href="<?php echo e(url(app_get_locale(false,'/'))); ?>" class="header-logo mr-20" data-x="header-logo" data-x-toggle="is-logo-dark">
                        <?php if($logo): ?>
                            <img class="logo-light" src="<?php echo e(get_file_url($logo,'full')); ?>" alt="<?php echo e(setting_item("site_title")); ?>">
                        <?php endif; ?>
                        <?php if($logoDark): ?>
                            <img class="logo-dark" src="<?php echo e(get_file_url($logoDark,'full')); ?>" alt="<?php echo e(setting_item("site_title")); ?>">
                        <?php endif; ?>
                    </a>
                </div>
            <?php endif; ?>
            <div class="col-auto">
                <div class="d-flex items-center">
                    <div class="header-menu menu-right">
                        <div class="mobile-overlay"></div>
                        <div class="header-menu__content">
                            <div class="menu js-navList">
                                <ul class="menu__nav <?php echo e($navTextStyle); ?> -is-active">
                                    <?php echo $__env->make('Core::frontend.currency-switcher', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php echo $__env->make('Language::frontend.switcher-dropdown', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                    <?php if(!Auth::check()): ?>
                                        <div class="d-flex items-center ml-20 is-menu-opened-hide md:d-none">
                                            <?php $btn_expert = '-white bg-white text-dark-1';
                                                $btn_login = 'border-white -outline-white text-white';
                                                if ($headerStyle == 'transparent_v6'){
                                                    $btn_expert = '-blue-1 bg-dark-1 text-white';
                                                    $btn_login = 'border-dark-1 -blue-1 text-dark-1';
                                                }
                                                elseif ($headerStyle == 'normal_white'){
                                                    $btn_expert = '-white bg-blue-1 text-white';
                                                    $btn_login = 'border-dark-1 -blue-1 text-dark-1';
                                                }
                                                elseif ($headerStyle == 'transparent_v9'){
                                                    $btn_expert = '-blue-1 bg-dark-4 text-white';
                                                    $btn_login = 'border-dark-1 -blue-1 text-dark-1';
                                                }
                                                elseif ($headerStyle == 'transparent_v5'){
                                                    $btn_expert = '-blue-1 bg-dark-4 text-white';
                                                    $btn_login = 'border-dark-4 -blue-1 h-50 text-dark-4';
                                                }
                                            ?>

                                                    <?php if(!empty($page_vendor = get_page_url ( setting_item('vendor_page_become_an_expert')))): ?>
                                                        <a href="<?php echo e($page_vendor); ?>" class="<?php echo e($btn_expert); ?> button px-30 fw-400 text-14  h-50"><?php echo e(__('Become An Expert')); ?></a>
                                                    <?php endif; ?>
                                                    <a data-bs-toggle="modal" href="#login" class="<?php echo e($btn_login); ?> button px-30 fw-400 text-14  h-50 ml-20"><?php echo e(__('Sign In / Register')); ?></a>
                                                </div>
                                            <?php else: ?>
                                                <li class="login-item menu-item-has-children">
                                                    <a href="#" class="is_login">
                                                    <span class="mr-10">
                                                        <?php if($avatar_url = Auth::user()->getAvatarUrl()): ?>
                                                            <img class="avatar rounded-circle" src="<?php echo e($avatar_url); ?>" alt="<?php echo e(Auth::user()->getDisplayName()); ?>" width="30" height="30">
                                                        <?php else: ?>
                                                            <span class="avatar-text rounded-circle"><?php echo e(ucfirst( Auth::user()->getDisplayName()[0])); ?></span>
                                                        <?php endif; ?>
                                                        <?php echo e(__("Hi, :Name",['name'=>Auth::user()->getDisplayName()])); ?>

                                                    </span>
                                                        <i class="icon icon-chevron-sm-down"></i>
                                                    </a>
                                                    <ul class="subnav">
                                                        <?php if(Auth::user()->hasPermission('dashboard_vendor_access')): ?>
                                                            <li><a href="<?php echo e(route('vendor.dashboard')); ?>" class="dropdown-item"><i class="fa fa-line-chart mr-10"></i> <?php echo e(__("Vendor Dashboard")); ?></a></li>
                                                        <?php endif; ?>
                                                        <li class="<?php if(Auth::user()->hasPermission('dashboard_vendor_access')): ?> menu-hr <?php endif; ?>">
                                                            <a href="<?php echo e(route('user.profile.index')); ?>" class="dropdown-item"><i class="fa fa-address-card mr-10"></i> <?php echo e(__("My profile")); ?></a>
                                                        </li>
                                                        <?php if(setting_item('inbox_enable')): ?>
                                                            <li class="menu-hr"><a href="<?php echo e(route('user.chat')); ?>" class="dropdown-item"><i class="fa fa-comments mr-10"></i> <?php echo e(__("Messages")); ?></a></li>
                                                        <?php endif; ?>
                                                        <li class="menu-hr"><a href="<?php echo e(route('user.booking_history')); ?>" class="dropdown-item"><i class="fa fa-clock-o mr-10"></i> <?php echo e(__("Booking History")); ?></a></li>
                                                        <li class="menu-hr"><a href="<?php echo e(route('user.change_password')); ?>" class="dropdown-item"><i class="fa fa-lock mr-10"></i> <?php echo e(__("Change password")); ?></a></li>
                                                        <?php if(Auth::user()->hasPermission('dashboard_access')): ?>
                                                            <li class="menu-hr"><a href="<?php echo e(route('admin.index')); ?>" class="dropdown-item"><i class="fa fa-dashboard mr-10"></i> <?php echo e(__("Admin Dashboard")); ?></a></li>
                                                        <?php endif; ?>
                                                        <li class="menu-hr">
                                                            <a class="dropdown-item"  href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out mr-10"></i> <?php echo e(__('Logout')); ?></a>
                                                        </li>
                                                    </ul>
                                                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                                        <?php echo e(csrf_field()); ?>

                                                    </form>
                                                </li>
                                            <?php endif; ?>
                                            <div class="d-none xl:d-flex x-gap-20 items-center pl-30 text-white" data-x="header-mobile-icons" data-x-toggle="text-white">
                                                <div>
                                                    <?php if(!Auth::check()): ?>
                                                        <a href="<?php echo e(url('/login')); ?>" class="d-flex items-center icon-user text-inherit text-22"></a>
                                                    <?php else: ?>
                                                        <div class="login-mobile-item dropdown ml-20">
                                                            <a href="#" data-bs-toggle="dropdown" class="icon-user text-inherit text-22 is_login"></a>
                                                            <ul class="dropdown-menu text-left">
                                                                <li>
                                                                    <a href="#" class="dropdown-item">
                                                                        <?php if($avatar_url = Auth::user()->getAvatarUrl()): ?>
                                                                            <img class="avatar" src="<?php echo e($avatar_url); ?>" alt="<?php echo e(Auth::user()->getDisplayName()); ?>" width="30" height="30">
                                                                        <?php else: ?>
                                                                            <span class="avatar-text"><?php echo e(ucfirst( Auth::user()->getDisplayName()[0])); ?></span>
                                                                        <?php endif; ?>
                                                                        <?php echo e(__("Hi, :Name",['name'=>Auth::user()->getDisplayName()])); ?>

                                                                    </a>
                                                                </li>
                                                                <?php if(Auth::user()->hasPermission('dashboard_vendor_access')): ?>
                                                                    <li><a href="<?php echo e(route('vendor.dashboard')); ?>" class="dropdown-item"><i class="icon ion-md-analytics"></i> <?php echo e(__("Vendor Dashboard")); ?></a></li>
                                                                <?php endif; ?>
                                                                <li class="<?php if(Auth::user()->hasPermission('dashboard_vendor_access')): ?> menu-hr <?php endif; ?>">
                                                                    <a href="<?php echo e(route('user.profile.index')); ?>" class="dropdown-item"><i class="icon ion-md-construct"></i> <?php echo e(__("My profile")); ?></a>
                                                                </li>
                                                                <?php if(setting_item('inbox_enable')): ?>
                                                                    <li class="menu-hr"><a href="<?php echo e(route('user.chat')); ?>" class="dropdown-item"><i class="fa fa-comments"></i> <?php echo e(__("Messages")); ?></a></li>
                                                                <?php endif; ?>
                                                                <li class="menu-hr"><a href="<?php echo e(route('user.booking_history')); ?>" class="dropdown-item"><i class="fa fa-clock-o"></i> <?php echo e(__("Booking History")); ?></a></li>
                                                                <li class="menu-hr"><a href="<?php echo e(route('user.change_password')); ?>" class="dropdown-item"><i class="fa fa-lock"></i> <?php echo e(__("Change password")); ?></a></li>
                                                                <?php if(Auth::user()->hasPermission('dashboard_access')): ?>
                                                                    <li class="menu-hr"><a href="<?php echo e(route('admin.index')); ?>" class="dropdown-item"><i class="icon ion-ios-ribbon"></i> <?php echo e(__("Admin Dashboard")); ?></a></li>
                                                                <?php endif; ?>
                                                                <li class="menu-hr">
                                                                    <a class="dropdown-item"  href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-sign-out"></i> <?php echo e(__('Logout')); ?></a>
                                                                </li>
                                                            </ul>
                                                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                                                                <?php echo e(csrf_field()); ?>

                                                            </form>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div><button class="d-flex items-center icon-menu text-inherit text-20" data-x-click="header, header-logo, header-mobile-icons, mobile-menu"></button></div>
                                            </div>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="d-none xl:d-flex x-gap-20 items-center pl-30 <?php echo e($navTextStyle); ?>" data-x="header-mobile-icons" data-x-toggle="text-white">
                            <div><a href="<?php if(!Auth::check()): ?> <?php echo e(url('/login')); ?> <?php else: ?> <?php echo e(route('user.profile.index')); ?> <?php endif; ?>" class="d-flex items-center icon-user text-inherit text-22"></a></div>
                            <?php if($headerStyle !== 'transparent_v4'): ?>
                                <div><button class="d-flex items-center icon-menu text-inherit text-20" data-x-click="header, header-logo, header-mobile-icons, mobile-menu"></button></div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="d-none xl:d-flex x-gap-20 items-center pl-30" data-x="header-mobile-icons" data-x-toggle="text-white">
                </div>
            </div>
        </header>
    <?php break; ?>
<?php endswitch; ?>
<?php /**PATH E:\Gabriel code site\themes/GoTrip/Layout/parts/header.blade.php ENDPATH**/ ?>