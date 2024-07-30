<?php
    $list_category = $model_category->with('translation')->get()->toTree();
?>
<?php if(!empty($list_category)): ?>
<div class="sidebar-widget widget_category">
    <div class="sidebar-title">
        <h2><?php echo e($item->title); ?></h2>
    </div>
    <ul>
        <?php
        $traverse = function ($categories, $prefix = '') use (&$traverse) {
            foreach ($categories as $category) {
                $translation = $category->translate();
                ?>
                    <li>
                        <span></span>
                        <a href="<?php echo e($category->getDetailUrl()); ?>"><?php echo e($prefix); ?> <?php echo e($translation->name); ?></a>
                    </li>
                <?php
                $traverse($category->children, $prefix . '-');
            }
        };
        $traverse($list_category);
        ?>
    </ul>
</div>
<?php endif; ?>
<?php /**PATH /home/r114961reze/public_html/themes/GoTrip/News/Views/frontend/layouts/sidebars/category.blade.php ENDPATH**/ ?>