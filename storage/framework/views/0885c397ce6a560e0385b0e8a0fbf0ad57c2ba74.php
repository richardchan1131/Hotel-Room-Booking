<?php
$dataUser = Auth::user();
$menus = [
    'dashboard'       => [
        'url'        => route("vendor.dashboard"),
        'title'      => __("Dashboard"),
        'icon'       => 'fa fa-home',
        'permission' => 'dashboard_vendor_access',
        'position'   => 10
    ],
    'booking-history' => [
        'url'      => route("user.booking_history"),
        'title'    => __("Booking History"),
        'icon'     => 'fa fa-clock-o',
        'position' => 20
    ],
    "wishlist"=>[
        'url'   => route("user.wishList.index"),
        'title' => __("Wishlist"),
        'icon'  => 'fa fa-heart-o',
        'position' => 21
    ],
    'profile'         => [
        'url'      => route("user.profile.index"),
        'title'    => __("My Profile"),
        'icon'     => 'fa fa-cogs',
        'position' => 95
    ],
    'password'        => [
        'url'      => route("user.change_password"),
        'title'    => __("Change password"),
        'icon'     => 'fa fa-lock',
        'position' => 95
    ],
    'admin'           => [
        'url'        => route('admin.index'),
        'title'      => __("Admin Dashboard"),
        'icon'       => 'icon ion-ios-ribbon',
        'permission' => 'dashboard_access',
        'position'   => 100
    ]
];

// Modules
$custom_modules = \Modules\ServiceProvider::getActivatedModules();
if(!empty($custom_modules)){
    foreach($custom_modules as $module){
        $moduleClass = $module['class'];
        if(class_exists($moduleClass))
        {
            $menuConfig = call_user_func([$moduleClass,'getUserMenu']);
            if(!empty($menuConfig)){
                $menus = array_merge($menus,$menuConfig);
            }
            $menuSubMenu = call_user_func([$moduleClass,'getUserSubMenu']);
            if(!empty($menuSubMenu)){
                foreach($menuSubMenu as $k=>$submenu){
                    $submenu['id'] = $submenu['id'] ?? '_'.$k;
                    if(!empty($submenu['parent']) and isset($menus[$submenu['parent']])){
                        $menus[$submenu['parent']]['children'][$submenu['id']] = $submenu;
                        $menus[$submenu['parent']]['children'] = array_values(\Illuminate\Support\Arr::sort($menus[$submenu['parent']]['children'], function ($value) {
                            return $value['position'] ?? 100;
                        }));
                    }
                }
            }
        }
    }
}

// Plugins Menu
$plugins_modules = \Plugins\ServiceProvider::getModules();
if(!empty($plugins_modules)){
    foreach($plugins_modules as $module){
        $moduleClass = "\\Plugins\\".ucfirst($module)."\\ModuleProvider";
        if(class_exists($moduleClass))
        {
            $menuConfig = call_user_func([$moduleClass,'getUserMenu']);
            if(!empty($menuConfig)){
                $menus = array_merge($menus,$menuConfig);
            }
            $menuSubMenu = call_user_func([$moduleClass,'getUserSubMenu']);
            if(!empty($menuSubMenu)){
                foreach($menuSubMenu as $k=>$submenu){
                    $submenu['id'] = $submenu['id'] ?? '_'.$k;
                    if(!empty($submenu['parent']) and isset($menus[$submenu['parent']])){
                        $menus[$submenu['parent']]['children'][$submenu['id']] = $submenu;
                        $menus[$submenu['parent']]['children'] = array_values(\Illuminate\Support\Arr::sort($menus[$submenu['parent']]['children'], function ($value) {
                            return $value['position'] ?? 100;
                        }));
                    }
                }
            }
        }
    }
}

// Custom Menu
$custom_modules = \Custom\ServiceProvider::getModules();
if(!empty($custom_modules)){
    foreach($custom_modules as $module){
        $moduleClass = "\\Custom\\".ucfirst($module)."\\ModuleProvider";
        if(class_exists($moduleClass))
        {
            $menuConfig = call_user_func([$moduleClass,'getUserMenu']);
            if(!empty($menuConfig)){
                $menus = array_merge($menus,$menuConfig);
            }
            $menuSubMenu = call_user_func([$moduleClass,'getUserSubMenu']);
            if(!empty($menuSubMenu)){
                foreach($menuSubMenu as $k=>$submenu){
                    $submenu['id'] = $submenu['id'] ?? '_'.$k;
                    if(!empty($submenu['parent']) and isset($menus[$submenu['parent']])){
                        $menus[$submenu['parent']]['children'][$submenu['id']] = $submenu;
                        $menus[$submenu['parent']]['children'] = array_values(\Illuminate\Support\Arr::sort($menus[$submenu['parent']]['children'], function ($value) {
                            return $value['position'] ?? 100;
                        }));
                    }
                }
            }
        }
    }
}

$currentUrl = url(Illuminate\Support\Facades\Route::current()->uri());
if (!empty($menus))
    $menus = array_values(\Illuminate\Support\Arr::sort($menus, function ($value) {
        return $value['position'] ?? 100;
    }));
    foreach ($menus as $k => $menuItem) {
        if (!empty($menuItem['permission']) and !Auth::user()->hasPermission($menuItem['permission'])) {
            unset($menus[$k]);
            continue;
        }
        $menus[$k]['class'] = $currentUrl == url($menuItem['url']) ? 'active -is-active text-blue-1' : '';
        if (!empty($menuItem['children'])) {
            $menus[$k]['class'] .= ' has-children';
            foreach ($menuItem['children'] as $k2 => $menuItem2) {
                if (!empty($menuItem2['permission']) and !Auth::user()->hasPermission($menuItem2['permission'])) {
                    unset($menus[$k]['children'][$k2]);
                    continue;
                }
                $menus[$k]['children'][$k2]['class'] = $currentUrl == url($menuItem2['url']) ? 'active active_child' : '';
            }
        }
    }
?>
<div class="dashboard__sidebar bg-white scroll-bar-1">

    <div class="sidebar__user text-center mb-20">
        <div class="logo">
            <?php if($avatar_url = $dataUser->getAvatarUrl()): ?>
                <div class="avatar avatar-cover" style="background-image: url('<?php echo e($dataUser->getAvatarUrl()); ?>')"></div>
            <?php else: ?>
                <span class="avatar-text"><?php echo e(ucfirst($dataUser->getDisplayName()[0])); ?></span>
            <?php endif; ?>
        </div>
        <div class="user-profile-info">
            <div class="info-new">
                <span class="role-name badge badge-info"><?php echo e($dataUser->role_name); ?></span>
                <h5 class="text-16"><?php echo e($dataUser->getDisplayName()); ?></h5>
                <p class="text-10 mb-0"><?php echo e(__("Member Since :time",["time"=> date("M Y",strtotime($dataUser->created_at))])); ?></p>
            </div>
        </div>
        <?php if(!Auth::user()->hasPermission("dashboard_vendor_access") and setting_item('vendor_enable')): ?>
        <div class="user__profile-plan mt-10 text-center">
            <a class="become-vendor button -sm -dark-1 bg-blue-1 text-white" href="<?php echo e(route("user.upgrade_vendor")); ?>"><?php echo e(__("Become a vendor")); ?></a>
        </div>
        <?php endif; ?>
    </div>

    <div class="sidebar -dashboard">
        <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuItem): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="sidebar__item" data-position="<?php echo e($menuItem['position'] ?? 0); ?>">
                <div class="accordion -db-sidebar js-accordion">
                    <div class="accordion__item">
                        <div class="accordion__button">
                            <div class="sidebar__button <?php echo e($menuItem['class']); ?> col-12 d-flex items-center justify-between">
                                <div class="d-flex items-center text-15 lh-1 fw-500">
                                    <?php if(!empty($menuItem['icon'])): ?>
                                        <a href="<?php echo e(url($menuItem['url'])); ?>" class="icon text-center mr-15 text-24"><i class="<?php echo e($menuItem['icon']); ?>"></i></a>
                                    <?php endif; ?>
                                    <a href="<?php echo e(url($menuItem['url'])); ?>">
                                        <?php echo clean($menuItem['title']); ?>

                                    </a>
                                </div>
                                <?php if(!empty($menuItem['children'])): ?>
                                    <div class="icon-chevron-sm-down text-7"></div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php if(!empty($menuItem['children'])): ?>
                            <div class="accordion__content">
                                <ul class="list-disc pt-15 pb-5 pl-40">
                                    <?php $__currentLoopData = $menuItem['children']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menuItem2): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="<?php echo e($menuItem2['class']); ?>">
                                            <a href="<?php echo e(url($menuItem2['url'])); ?>">
                                                <?php if(!empty($menuItem2['icon'])): ?>
                                                    <i class="<?php echo e($menuItem2['icon']); ?>"></i>
                                                <?php endif; ?>
                                                <?php echo clean($menuItem2['title']); ?>

                                            </a>
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <div class="sidebar__item ">
                <form id="logout-form-vendor" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
                    <?php echo e(csrf_field()); ?>

                </form>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form-vendor').submit();" class="sidebar__button d-flex items-center text-15 lh-1 fw-500">
                    <i class="fa fa-sign-out icon text-center mr-15 text-24"></i> <?php echo e(__("Log Out")); ?>

                </a>
            </div>
            <div class="sidebar__item ">
                <a href="<?php echo e(url('/')); ?>" class="sidebar__button d-flex items-center text-15 lh-1 fw-500">
                    <i class="fa fa-long-arrow-left icon text-center mr-15 text-24"></i> <?php echo e(__("Back to Homepage")); ?>

                </a>
            </div>
    </div>
</div>
<?php /**PATH /home/r114961reze/public_html/themes/GoTrip/User/Views/frontend/layouts/sidebar.blade.php ENDPATH**/ ?>