<?php
$user = auth()->user();
?>
<div class="modal fade" tabindex="-1" role="dialog" id="enquiry_form_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content enquiry_form_modal_form">
            <div class="modal-header">
                <h5 class="modal-title"><?php echo e(__("Enquiry")); ?></h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body pt-0 pb-0">
                <input type="hidden" name="service_id" value="<?php echo e($row->id); ?>">
                <input type="hidden" name="service_type" value="<?php echo e($service_type ?? ''); ?>">
                <div class="form-input mb-3">
                    <input type="text" value="<?php echo e($user->display_name ?? ''); ?>" name="enquiry_name" >
                    <label class="lh-1 text-16 text-light-1"><?php echo e(__("Name *")); ?></label>
                </div>
                <div class="form-input mb-3">
                    <input type="text" value="<?php echo e($user->email ?? ''); ?>" name="enquiry_email" >
                    <label class="lh-1 text-16 text-light-1"><?php echo e(__("Email *")); ?></label>
                </div>
                <div class="form-input mb-3">
                    <input type="text" value="<?php echo e($user->phone ?? ''); ?>" name="enquiry_phone" >
                    <label class="lh-1 text-16 text-light-1"><?php echo e(__("Phone")); ?></label>
                </div>
                <div class="form-input mb-3" v-if="!enquiry_is_submit">
                    <textarea name="enquiry_note" rows="4"></textarea>
                    <label class="lh-1 text-16 text-light-1"><?php echo e(__("Note")); ?></label>
                </div>
                <?php if(setting_item("booking_enquiry_enable_recaptcha")): ?>
                    <div class="form-group">
                        <?php echo e(recaptcha_field('enquiry_form')); ?>

                    </div>
                <?php endif; ?>
                <div class="message_box"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="button -md -blue-1 bg-blue-1-05 text-blue-1" data-bs-dismiss="modal"><?php echo e(__('Close')); ?></button>
                <button type="button" class="button -md -blue-1 bg-dark-3 text-white btn-submit-enquiry">
                    <?php echo e(__("Send now")); ?>

                </button>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /home/r114961reze/public_html/custom/Booking/Views/frontend/global/enquiry-form.blade.php ENDPATH**/ ?>