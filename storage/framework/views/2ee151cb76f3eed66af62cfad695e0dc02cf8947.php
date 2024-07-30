<?php $translation = $row->translate();?>
<div class="row y-gap-30">
    <a href="<?php echo e($row->getDetailUrl()); ?>" class="blogCard -type-1 col-12">
        <div class="row y-gap-15 items-center md:justify-center md:text-center">
            <div class="col-auto">
                <div class="blogCard__image rounded-4">
                    <div class="ratio ratio-1:1 w-250">
                        <?php echo get_image_tag($row->image_id,'medium',['class'=>'img-ratio rounded-4','alt'=>$translation->title,'lazy'=>false]); ?>

                    </div>
                </div>
            </div>
            <div class="col-md">
                <div class="text-15 text-light-1"><?php echo e(display_date($row->updated_at)); ?></div>
                <h3 class="text-22 text-dark-1 mt-10 md:mt-5">
                    <?php echo clean($translation->title); ?>

                </h3>
                <div class="text-15 lh-16 text-light-1 mt-10 md:mt-5">
                    <?php echo get_exceprt($translation->content); ?>

                </div>
            </div>
        </div>
    </a>
</div>
<?php /**PATH /home/r114961reze/public_html/themes/GoTrip/News/Views/frontend/layouts/details/news-loop.blade.php ENDPATH**/ ?>