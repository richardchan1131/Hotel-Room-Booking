<?php if($translation->trip_ideas): ?>
    <section class="layout-pt-md layout-pb-lg">
        <div class="row">
            <div class="col-auto">
                <div class="sectionTitle -md">
                    <h2 class="sectionTitle__title"><?php echo e(__("Top sights in  :text",['text'=>$translation->name])); ?></h2>
                    <p class=" sectionTitle__text mt-5 sm:mt-0"><?php echo e(__('These popular destinations have a lot to offer')); ?></p>
                </div>
            </div>
        </div>
        <div class="row y-gap-30 pt-40">
            <?php if(!empty($translation->trip_ideas)): ?>
                <?php if(!is_array($translation->trip_ideas)) $translation->trip_ideas = json_decode($translation->trip_ideas); ?>
                <?php $__currentLoopData = $translation->trip_ideas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key=>$trip_idea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="col-lg-6">
                        <div class="rounded-4 border-light">
                            <div class="d-flex flex-wrap y-gap-30">
                                <div class="col-auto">
                                    <div class="ratio ratio-1:1 w-200">
                                        <?php if($trip_idea['image_id']): ?>
                                            <?php echo get_image_tag($trip_idea['image_id'],'full',['class'=>'img-ratio','lazy'=>false]); ?>

                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="d-flex flex-column justify-center h-full px-30 py-20">
                                        <h3 class="text-18 fw-500"><?php echo e($trip_idea['title']); ?></h3>
                                        <p class="text-15 mt-5"><?php echo e(get_exceprt($trip_idea['content'],80,'...')); ?></p>
                                        <?php if($trip_idea['link']): ?>
                                            <a href="<?php echo e($trip_idea['link']); ?>" class="d-block text-14 text-blue-1 fw-500 underline mt-5"><?php echo e(__("See More")); ?></a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
        </div>
    </section>
<?php endif; ?>
<?php /**PATH /home/r114961reze/public_html/themes/GoTrip/Location/Views/frontend/layouts/details/location-trip-idea.blade.php ENDPATH**/ ?>