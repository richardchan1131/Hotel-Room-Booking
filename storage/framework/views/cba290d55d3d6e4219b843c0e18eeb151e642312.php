<?php
    $translation = $row->translate();
?>
<div class="row x-gap-20 y-gap-20 <?php echo e($wrap_class ?? ''); ?>">
    <div class="col-md-auto">
        <div class="has-skeleton">
            <div class="cardImage ratio ratio-1:1 w-250 md:w-1/1 rounded-4">
                <div class="cardImage__content">
                    <a href="<?php echo e($row->getDetailUrl()); ?>">
                        <?php if($row->image_url): ?>
                            <?php if(!empty($disable_lazyload)): ?>
                                <img  src="<?php echo e($row->image_url); ?>" class="rounded-4 col-12 js-lazy" alt="<?php echo e($translation->title ?? 'image'); ?>">
                            <?php else: ?>
                                <?php echo get_image_tag($row->image_id,'medium',['class'=>'rounded-4 col-12 js-lazy','alt'=>$translation->title]); ?>

                            <?php endif; ?>
                        <?php endif; ?>
                    </a>
                </div>
                <div class="service-wishlist <?php echo e($row->isWishList()); ?>" data-id="<?php echo e($row->id); ?>" data-type="<?php echo e($row->type); ?>">
                    <div class="cardImage__wishlist">
                        <button class="button -blue-1 bg-white size-30 rounded-full shadow-2">
                            <i class="icon-heart text-12"></i>
                        </button>
                    </div>
                </div>
                <div class="cardImage__leftBadge">
                    <?php if($row->is_featured == "1"): ?>
                        <div class="py-5 px-15 rounded-right-4 text-12 lh-16 fw-500 uppercase bg-yellow-1 text-dark-1">
                            <?php echo e(__("Featured")); ?>

                        </div>
                    <?php endif; ?>
                    <?php if($row->discount_percent): ?>
                        <div class="py-5 px-15 rounded-right-4 text-12 lh-16 fw-500 uppercase bg-blue-1 text-white mt-5">
                            <?php echo e(__("Sale off :number",['number'=>$row->discount_percent])); ?>

                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md">
        <div class="d-flex flex-column h-full justify-between">
            <div class="has-skeleton">
                <?php if(!empty($row->location->name)): ?>
                    <?php $location =  $row->location->translate() ?>
                <?php endif; ?>
                <h3 class="text-18 lh-16 fw-500">
                    <a href="<?php echo e($row->getDetailUrl()); ?>"><?php echo e($translation->title); ?></a>
                    <?php if($row->star_rate): ?>
                        <div class="star-rate d-inline-block ml-10">
                            <?php for($star = 1 ;$star <= $row->star_rate ; $star++): ?>
                                <i class="icon-star text-10 text-yellow-2"></i>
                            <?php endfor; ?>
                        </div>
                    <?php endif; ?>
                </h3>
                <?php if(!empty($location)): ?>
                    <p class="text-14 lh-14 mb-5"><?php echo e($location->name); ?></p>
                <?php endif; ?>
                <?php if(!empty($attribute = $row->getAttributeInListingPage())): ?>
                    <?php
                        $translate_attribute =  $attribute->translate();
                        $termsByAttribute = $row->termsByAttributeInListingPage
                    ?>
                    <div class="terms">
                        <div class="g-attributes">
                            <span class="attr-title"><i class="icofont-medal"></i> <?php echo e($translate_attribute->name ?? ""); ?>: </span>
                            <?php $__currentLoopData = $termsByAttribute; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php $translate_term = $term->translate() ?>
                                <span class="item <?php echo e($term->slug); ?> term-<?php echo e($term->id); ?>"><?php echo e($translate_term->name); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
            <?php $terms_ids = $row->terms->pluck('term_id');
                 $attributes = \Modules\Core\Models\Terms::getTermsById($terms_ids);
                 $terms = [];
            ?>
            <?php if(!empty($attributes)): ?>
                <?php $__currentLoopData = $attributes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attr): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $terms = array_merge($terms,$attr['child']) ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
            <?php if(!empty($terms)): ?>
                <div class="row x-gap-10 y-gap-10 pt-20">
                    <?php $__currentLoopData = $terms; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $term): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php if($k > 3) continue;
                            $translate_term = $term->translate()
                        ?>
                        <div class="col-auto">
                            <div class="has-skeleton border-light rounded-100 py-5 px-20 text-14 lh-14"><?php echo e($translate_term->name); ?></div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <div class="col-md-auto text-right md:text-left">
        <div class="has-skeleton">
            <?php if(setting_item('space_enable_review')): ?>
                <?php $reviewData = $row->getScoreReview(); $score_total = $reviewData['score_total'];?>
                <div class="row x-gap-10 y-gap-10 justify-end items-center md:justify-start">
                    <div class="col-auto">
                        <div class="text-14 lh-14 fw-500"><?php echo e($reviewData['review_text']); ?></div>
                        <div class="text-14 lh-14 text-light-1"><?php if($reviewData['total_review'] > 1): ?>
                                <?php echo e(__(":number Reviews",["number"=>$reviewData['total_review'] ])); ?>

                            <?php else: ?>
                                <?php echo e(__(":number Review",["number"=>$reviewData['total_review'] ])); ?>

                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <div class="flex-center text-white fw-600 text-14 size-40 rounded-4 bg-blue-1"><?php echo e($reviewData['score_total']); ?></div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="text-14 text-light-1 mt-40 md:mt-20"><?php echo e(__('From')); ?></div>
            <div class="d-flex justify-content-md-end align-baseline mt-5">
                <div class="text-16 text-red-1 line-through mr-5"><?php echo e($row->display_sale_price); ?></div>
                <div class="text-22 lh-12 fw-600"><?php echo e($row->display_price); ?></div>
            </div>
            <div class="text-14 text-light-1 mt-5"><?php echo e(__('/night')); ?></div>
            <a href="<?php echo e($row->getDetailUrl()); ?>" class="button -md -dark-1 bg-blue-1 text-white mt-24">
                <?php echo e(__('See Availability')); ?> <div class="icon-arrow-top-right ml-15"></div>
            </a>
        </div>
    </div>
</div>
<?php /**PATH /home/r114961reze/public_html/themes/GoTrip/Hotel/Views/frontend/layouts/search/loop-list.blade.php ENDPATH**/ ?>