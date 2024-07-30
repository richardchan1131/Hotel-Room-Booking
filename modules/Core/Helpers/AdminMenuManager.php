<?php


namespace Modules\Core\Helpers;


class AdminMenuManager
{
    protected static $_all = [];

    protected static $_cached = [];
    protected static $_group_cached = [];

    protected static $_active;

    protected static $_groups = [
        'default' => [
            'name'     => '',
            'position' => 100
        ]
    ];

    public static function register_group($group, $name, $position = 10)
    {
        static::$_groups[$group] = [
            'name'     => $name,
            'position' => $position
        ];
    }

    public static function register($id, $callable, $priority = 1)
    {
        if (isset(static::$_all[$id]) and (static::$_all[$id]['priority'] ?? 1) > $priority) return;
        static::$_all[$id] = [
            'callable' => $callable,
            'priority' => $priority
        ];
    }

    public static function all()
    {
        if (!empty(static::$_cached)) {
            return static::$_cached;
        }

        $menus = [
            'admin'   => [
                'url'      => route('admin.index'),
                'title'    => __("Dashboard"),
                'icon'     => 'icon ion-ios-desktop',
                "position" => 0
            ],
            'general' => [
                "position"   => 80,
                'url'        => route('core.admin.settings.index', ['group' => 'general']),
                'title'      => __('Setting'),
                'icon'       => 'icon ion-ios-cog',
                'permission' => 'setting_update',
                'group' => 'system',
                'children'   => \Modules\Core\Models\Settings::getSettingPages(true)
            ],
        ];

        // Modules
        $custom_modules = \Modules\ServiceProvider::getActivatedModules();
        if (!empty($custom_modules)) {
            $custom_modules[] = [
                'id'    => 'theme',
                'class' => \Modules\Theme\ModuleProvider::class
            ];
            foreach ($custom_modules as $moduleData) {
                $module = $moduleData['id'];
                $moduleClass = $moduleData['class'];
                if (class_exists($moduleClass)) {
                    $menuConfig = call_user_func([$moduleClass, 'getAdminMenu']);

                    if (!empty($menuConfig)) {
                        $menus = array_merge($menus, $menuConfig);
                    }

                    $menuSubMenu = call_user_func([$moduleClass, 'getAdminSubMenu']);

                    if (!empty($menuSubMenu)) {
                        foreach ($menuSubMenu as $k => $submenu) {
                            $submenu['id'] = $submenu['id'] ?? '_' . $k;

                            if (!empty($submenu['parent']) and isset($menus[$submenu['parent']])) {
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
        if (!empty($plugins_modules)) {
            foreach ($plugins_modules as $module) {
                $moduleClass = "\\Plugins\\" . ucfirst($module) . "\\ModuleProvider";
                if (class_exists($moduleClass)) {
                    $menuConfig = call_user_func([$moduleClass, 'getAdminMenu']);
                    if (!empty($menuConfig)) {
                        $menus = array_merge($menus, $menuConfig);
                    }
                    $menuSubMenu = call_user_func([$moduleClass, 'getAdminSubMenu']);
                    if (!empty($menuSubMenu)) {
                        foreach ($menuSubMenu as $k => $submenu) {
                            $submenu['id'] = $submenu['id'] ?? '_' . $k;
                            if (!empty($submenu['parent']) and isset($menus[$submenu['parent']])) {
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
        if (!empty($custom_modules)) {
            foreach ($custom_modules as $module) {
                $moduleClass = "\\Custom\\" . ucfirst($module) . "\\ModuleProvider";
                if (class_exists($moduleClass)) {
                    $menuConfig = call_user_func([$moduleClass, 'getAdminMenu']);

                    if (!empty($menuConfig)) {
                        $menus = array_merge($menus, $menuConfig);
                    }

                    $menuSubMenu = call_user_func([$moduleClass, 'getAdminSubMenu']);

                    if (!empty($menuSubMenu)) {
                        foreach ($menuSubMenu as $k => $submenu) {
                            $submenu['id'] = $submenu['id'] ?? '_' . $k;
                            if (!empty($submenu['parent']) and isset($menus[$submenu['parent']])) {
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
        //$typeManager = app()->make(\Modules\Type\TypeManager::class);
        //$menuConfig = $typeManager->adminMenus();

        //$menus = array_merge($menus, $menuConfig);


        $currentUrl = url(\Modules\Core\Walkers\MenuWalker::getActiveMenu());
        $user = \Illuminate\Support\Facades\Auth::user();
        if (!empty($menus)) {
            foreach ($menus as $k => $menuItem) {

                if (!empty($menuItem['permission']) and !$user->hasPermission($menuItem['permission'])) {
                    unset($menus[$k]);
                    continue;
                }
                $menus[$k]['class'] = $currentUrl == url($menuItem['url']) ? 'active' : '';
                if (!empty($menuItem['children'])) {
                    $menus[$k]['class'] .= ' has-children';
                    foreach ($menuItem['children'] as $k2 => $menuItem2) {
                        if (!empty($menuItem2['permission']) and !$user->hasPermission($menuItem2['permission'])) {
                            unset($menus[$k]['children'][$k2]);
                            continue;
                        }
                        $menus[$k]['children'][$k2]['class'] = $currentUrl == url($menuItem2['url']) ? 'active' : '';
                    }
                }
            }

            //@todo Sort Menu by Position
            $menus = array_values(\Illuminate\Support\Arr::sort($menus, function ($value) {
                return $value['position'] ?? 100;
            }));
        }

        static::$_cached = $menus;

        return static::$_cached;
    }


    public static function menus()
    {
        $all = static::all();
        foreach ($all as $k => $item) {
            $all[$k]['icon'] = $item['icon'] ?? '';
        }
        return $all;
    }

    public static function groups_with_children()
    {
        $all = static::groups();

        $menu_items = collect(static::menus());

        foreach ($all as $id => $option) {
            $all[$id]['menus'] = $menu_items->where('group', $id)->all();
        }
        $all['default']['menus'] = $menu_items->where('group', '')->all();

        $all = \Illuminate\Support\Arr::sort($all, function ($value) {
            return $value['position'] ?? 0;
        });
        return $all;
    }

    public static function groups()
    {
        if (!empty(static::$_group_cached)) {
            return static::$_group_cached;
        }
        $all = static::$_groups;
        // Modules
        $custom_modules = \Modules\ServiceProvider::getActivatedModules();
        if (!empty($custom_modules)) {
            $custom_modules[] = [
                'id'    => 'theme',
                'class' => \Modules\Theme\ModuleProvider::class
            ];
            foreach ($custom_modules as $moduleData) {
                $moduleClass = $moduleData['class'];
                if (class_exists($moduleClass)) {
                    $menuConfig = call_user_func([$moduleClass, 'getAdminMenuGroups']);

                    if (!empty($menuConfig)) {
                        $all = array_merge($all, $menuConfig);
                    }
                }

            }
        }

        static::$_group_cached = $all;

        return static::$_group_cached;
    }

    public static function item($page_id)
    {
        if (isset(static::$_all[$page_id]) and isset(static::$_all[$page_id]['callable']) and is_callable(static::$_all[$page_id]['callable'])) {
            return call_user_func(static::$_all[$page_id]['callable']);
        }
        return null;
    }

    public static function isActive($id, $options)
    {
        return static::$_active == $id;
    }

    public static function setActive($id)
    {
        static::$_active = $id;
    }
}
