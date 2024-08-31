<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<hr>

<?php

 

foreach ($notes as $note) { ?>
<?php if ($note['is_comment'] == 1) { ?>
<div class="media lead-note">
    <a href="<?php echo admin_url('profile/' . $note['addedfrom']); ?>" target="_blank">
        <?php echo staff_profile_image($note['addedfrom'], ['staff-profile-image-small', 'pull-left mright10']); ?>
    </a>
    <div class="media-body">
        <?php if ($note['addedfrom'] == get_staff_user_id() || is_admin()) { ?>
        <a href="#" class="pull-right text-danger"
            onclick="delete_lead_note(this,<?php echo e($note['id']); ?>, <?php echo e($lead->id); ?>);return false;">

            <i class="fa fa fa-times"></i></a>
        <a href="#" class="pull-right mright5" onclick="toggle_edit_note(<?php echo e($note['id']); ?>);return false;">
            <i class="fa-regular fa-pen-to-square"></i>
            <?php } ?>

            <a href="<?php echo admin_url('profile/' . $note['addedfrom']); ?>" style="display:inline-block"
                target="_blank">
                <h5 class="media-heading tw-font-semibold tw-mb-0">
                    <?php if (!empty($note['date_contacted'])) { ?>
                    <span data-toggle="tooltip" data-title="<?php echo e(_dt($note['date_contacted'])); ?>">
                        <i class="fa fa-phone-square text-success" aria-hidden="true"></i>
                    </span>
                    <?php } ?>
                    <?php echo e(get_staff_full_name($note['addedfrom'])); ?>
                </h5>
                <span class="tw-text-sm tw-text-neutral-500">
                    <?php echo e(_l('lead_comment_date_added', _dt($note['dateadded']))); ?>
                </span>
            </a>

            <div data-note-description="<?php echo e($note['id']); ?>" class="text-muted mtop10">
                <?php 
                echo process_text_content_for_display($note['description']);
                 ?></div>

            <div data-note-edit-textarea="<?php echo e($note['id']); ?>" class="hide mtop15">
                <?php 
                echo render_textarea('note', '', $note['description'], [], [], '', 'tinymcee');
                ?>

                <div class="text-right">
                    <button type="button" class="btn btn-default"
                        onclick="toggle_edit_note(<?php echo e($note['id']); ?>);return false;"><?php echo _l('cancel'); ?></button>
                    <button type="button" class="btn btn-primary"
                        onclick="edit_note(<?php echo e($note['id']); ?>);"><?php echo _l('update_comment'); ?></button>
                </div>
            </div>
    </div>
    <hr>
</div>
<?php }
} ?>


<?php echo form_open(admin_url('leads/add_note/' . $lead->id), ['id' => 'lead-notes']); ?>
<div class="form-group">
    <textarea id="lead_note_description" name="lead_note_description" class="form-control" rows="4"></textarea>
</div>
<div class="lead-select-date-contacted hide">

    <input type="hidden" name="contacted_indicator" value="<?php echo date('Y-m-d') ?>">
    <input type="hidden" name="is_comment" value="1">
</div>


<button type="submit" class="btn btn-primary pull-right"><?php echo _l('lead_add_edit_add_comment'); ?></button>
<?php echo form_close(); ?>
<div class="clearfix"></div>