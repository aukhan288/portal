<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="<?php if ($openEdit == true) {
                echo 'open-edit ';
            } ?>lead-wrapper" <?php if (isset($lead) && ($lead->junk == 1 || $lead->lost == 1)) {
                        echo 'lead-is-junk-or-lost';
                    } ?>>

    <?php if (isset($lead)) { ?>
    <div class="btn-group pull-right mleft5" id="lead-more-btn">
        <a href="#" class="btn btn-default dropdown-toggle lead-top-btn" data-toggle="dropdown" aria-haspopup="true"
            aria-expanded="false">
            <?php echo _l('more'); ?>
            <span class="caret"></span>
        </a>
        <ul class="dropdown-menu dropdown-menu-left" id="lead-more-dropdown">
            <?php if ($lead->junk == 0) {
                    if ($lead->lost == 0 && (total_rows(db_prefix() . 'clients', ['leadid' => $lead->id]) == 0)) { ?>
            <li>
                <a href="#" onclick="lead_mark_as_lost(<?php echo e($lead->id); ?>); return false;">
                    <i class="fa fa-mars"></i>
                    <?php echo _l('lead_mark_as_lost'); ?>
                </a>
            </li>
            <?php } elseif ($lead->lost == 1) { ?>
            <li>
                <a href="#" onclick="lead_unmark_as_lost(<?php echo e($lead->id); ?>); return false;">
                    <i class="fa fa-smile-o"></i>
                    <?php echo _l('lead_unmark_as_lost'); ?>
                </a>
            </li>
            <?php } ?>
            <?php
                } ?>
            <!-- mark as junk -->
            <?php if ($lead->lost == 0) {
                    if ($lead->junk == 0 && (total_rows(db_prefix() . 'clients', ['leadid' => $lead->id]) == 0)) { ?>
            <li>
                <a href="#" onclick="lead_mark_as_junk(<?php echo e($lead->id); ?>); return false;">
                    <i class="fa fa fa-times"></i>
                    <?php echo _l('lead_mark_as_junk'); ?>
                </a>
            </li>
            <?php } elseif ($lead->junk == 1) { ?>
            <li>
                <a href="#" onclick="lead_unmark_as_junk(<?php echo e($lead->id); ?>); return false;">
                    <i class="fa fa-smile-o"></i>
                    <?php echo _l('lead_unmark_as_junk'); ?>
                </a>
            </li>
            <?php } ?>
            <?php } ?>
            <?php if ((staff_can('delete',  'leads') && $lead_locked == false) || is_admin()) { ?>
            <li>
                <a href="<?php echo admin_url('leads/delete/' . $lead->id); ?>" class="text-danger delete-text _delete"
                    data-toggle="tooltip" title="">
                    <i class="fa fa-remove"></i>
                    <?php echo _l('lead_edit_delete_tooltip'); ?>
                </a>
            </li>
            <?php } ?>
        </ul>

    </div>

    <div class="pull-right mleft5">
        <a data-toggle="tooltip" class="btn btn-default lead-print-btn lead-top-btn lead-view"
            onclick="print_lead_information(); return false;" data-placement="top" title="<?php echo _l('print'); ?>"
            href="#">
            <i class="fa fa-print"></i>
        </a>
    </div>

    <div class="mleft5 pull-right<?php echo $lead_locked == true ? ' hide' : ''; ?>">
        <a href="#" lead-edit data-toggle="tooltip" data-title="<?php echo _l('edit'); ?>"
            class="btn btn-default lead-top-btn">

            <i class="fa-regular fa-pen-to-square"></i>
        </a>
    </div>

    <?php
        $client                                 = false;
        $convert_to_client_tooltip_email_exists = '';
        if (total_rows(db_prefix() . 'contacts', ['email' => $lead->email]) > 0 && total_rows(db_prefix() . 'clients', ['leadid' => $lead->id]) == 0) {
            $convert_to_client_tooltip_email_exists = _l('lead_email_already_exists');
            $text                                   = _l('lead_convert_to_client');
        } elseif (total_rows(db_prefix() . 'clients', ['leadid' => $lead->id])) {
            $client = true;
        } else {
            $text = _l('lead_convert_to_client');
        }
        ?>

    <?php if ($lead_locked == false) { ?>
    <div class="lead-edit<?php if (isset($lead)) {
                                        echo ' hide';
                                    } ?>">
        <button type="button" class="btn btn-primary pull-right lead-top-btn lead-save-btn"
            onclick="document.getElementById('lead-form-submit').click();">
            <?php echo _l('submit'); ?>
        </button>
    </div>
    <?php } ?>
    <?php if ($client && (staff_can('view',  'customers') || is_customer_admin(get_client_id_by_lead_id($lead->id)))) { ?>
    <a data-toggle="tooltip" class="btn btn-success pull-right lead-top-btn lead-view" data-placement="top"
        title="<?php echo _l('lead_converted_edit_client_profile'); ?>"
        href="<?php echo admin_url('clients/client/' . get_client_id_by_lead_id($lead->id)); ?>">
        <i class="fa-regular fa-user"></i>
    </a>
    <?php } ?>
    <?php if (total_rows(db_prefix() . 'clients', ['leadid' => $lead->id]) == 0) { ?>
    <a href="#" data-toggle="tooltip" data-title="<?php echo e($convert_to_client_tooltip_email_exists); ?>"
        class="btn btn-success pull-right lead-convert-to-customer lead-top-btn lead-view"
        onclick="convert_lead_to_customer(<?php echo e($lead->id); ?>); return false;">
        <i class="fa-regular fa-user"></i>
        <?php echo e($text); ?>
    </a>
    <?php } ?>

    <?php } ?>

    <div class="clearfix no-margin"></div>

    <?php if (isset($lead)) { ?>

    <div class="row mbot15" style="margin-top:12px;">
        <hr class="no-margin" />
    </div>

    <div class="alert alert-warning hide mtop20" role="alert" id="lead_proposal_warning">
        <?php echo _l('proposal_warning_email_change', [_l('lead_lowercase'), _l('lead_lowercase'), _l('lead_lowercase')]); ?>
        <hr />
        <a href="#" onclick="update_all_proposal_emails_linked_to_lead(<?php echo e($lead->id); ?>); return false;">
            <?php echo _l('update_proposal_email_yes'); ?>
        </a>
        <br />
        <a href="#" onclick="init_lead_modal_data(<?php echo e($lead->id); ?>); return false;">
            <?php echo _l('update_proposal_email_no'); ?>
        </a>
    </div>
    <?php } ?>
    <?php echo form_open((isset($lead) ? admin_url('leads/lead/' . $lead->id) : admin_url('leads/lead')), ['id' => 'lead_form']); ?>
    <div class="row">
        <div class="lead-view<?php if (!isset($lead)) {
                                    echo ' hide';
                                } ?>" id="leadViewWrapper">
            <div class="col-md-4 col-xs-12 lead-information-col">
                <div class="lead-info-heading">
                    <h4>
                        <?php echo _l('lead_info'); ?>
                    </h4>
                </div>
                <dl>
                    <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                        <?php echo _l('lead_add_edit_name'); ?></dt>
                    <dd class="tw-text-neutral-900 tw-mt-1 lead-name">
                        <?php echo (isset($lead) && $lead->name != '' ? e($lead->name) : '-') ?></dd>

                    <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                        <?php echo _l('lead_add_edit_email'); ?></dt>
                    <dd class="tw-text-neutral-900 tw-mt-1">
                        <?php echo (isset($lead) && $lead->email != '' ? '<a href="mailto:' . e($lead->email) . '">' . e($lead->email) . '</a>' : '-') ?>
                    </dd>


                    <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                        <?php echo _l('lead_add_edit_phonenumber'); ?></dt>
                    <dd class="tw-text-neutral-900 tw-mt-1">
                        <?php echo (isset($lead) && $lead->phonenumber != '' ? '<a href="tel:' . e($lead->phonenumber) . '">' . e($lead->phonenumber) . '</a>' : '-') ?>
                    </dd>
                    <dt class="lead-field-heading tw-font-medium tw-text-neutral-500"><?php echo _l('lead_address'); ?>
                    </dt>
                    <dd class="tw-text-neutral-900 tw-mt-1">
                        <?php echo (isset($lead) && $lead->address != '' ? process_text_content_for_display($lead->address) : '-') ?>
                    </dd>
                    <dt class="lead-field-heading tw-font-medium tw-text-neutral-500"><?php echo _l('lead_city'); ?>
                    </dt>
                    <dd class="tw-text-neutral-900 tw-mt-1">
                        <?php echo (isset($lead) && $lead->city != '' ? e($lead->city) : '-') ?></dd>
                    <dt class="lead-field-heading tw-font-medium tw-text-neutral-500"><?php echo _l('lead_state'); ?>
                    </dt>
                    <dd class="tw-text-neutral-900 tw-mt-1">
                        <?php echo (isset($lead) && $lead->state != '' ? e($lead->state) : '-') ?>
                    <!-- </dd> -->
                    <!-- <dt class="lead-field-heading tw-font-medium tw-text-neutral-500"><?php 
                    //echo _l('lead_country'); ?> -->
                    <!-- </dt> -->
                    <!-- <dd class="tw-text-neutral-900 tw-mt-1"> -->
                        <?php 
                       // echo (isset($lead) && $lead->country != 0 ? e(get_country($lead->country)->short_name) : '-')
                         ?>
                    <!-- </dd> -->
                    <dt class="lead-field-heading tw-font-medium tw-text-neutral-500"><?php echo _l('lead_zip'); ?></dt>
                    <dd class="tw-text-neutral-900 tw-mt-1">
                        <?php echo (isset($lead) && $lead->zip != '' ? e($lead->zip) : '-') ?></dd>
                </dl>
            </div>
            <div class="col-md-4 col-xs-12 lead-information-col">
                <div class="lead-info-heading">
                    <h4>
                        <?php echo _l('lead_general_info'); ?>
                    </h4>
                </div>
                <dl>
                    <dt class="lead-field-heading tw-font-medium tw-text-neutral-500 no-mtop">
                        <?php echo _l('lead_add_edit_status'); ?>
                    </dt>
                    <dd class="tw-text-neutral-900 tw-mt-2 mbot15">
                        <?php
                        if (isset($lead)) {
                            echo $lead->status_name != '' ? ('<span class="lead-status-' . e($lead->status) . ' label' . (empty($lead->color) ? ' label-default' : '') . '" style="color:' . e($lead->color) . ';border:1px solid ' . adjust_hex_brightness($lead->color, 0.4) . ';background: ' . adjust_hex_brightness($lead->color, 0.04) . ';">' . e($lead->status_name) . '</span>') : '-';
                        } else {
                            echo '-';
                        }
                        ?>
                    </dd>
                    <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                        <?php echo _l('lead_add_edit_source'); ?></dt>
                    <dd class="tw-text-neutral-900 tw-mt-1 mbot15">
                        <?php echo (isset($lead) && $lead->source_name != '' ? e($lead->source_name) : '-') ?></dd>

                    <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                        <?php echo _l('lead_add_edit_assignees'); ?></dt>
                    <dd class="tw-text-neutral-900 tw-mt-1 mbot15">
                        <?php
                        // echo (isset($lead) && $lead->assigned != 0 ? e(get_staff_full_name($lead->assigned)) : '-')
                          ?>
                        <?php
                        if (isset($lead) && !empty($lead->assignees)) {
                            $assignees = is_array($lead->assignees) ? $lead->assignees : explode(',', $lead->assignees);
                            $assigneeNames = [];
                            foreach ($assignees as $assignee) {
                                $assigneeNames[] = e(get_staff_full_name(trim($assignee)));
                            }
                            echo implode(', ', $assigneeNames);
                        } else {
                            echo '-';
                        }
                        ?>


                    </dd>

                    <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                        <?php echo _l('leads_dt_datecreated'); ?></dt>
                    <dd class="tw-text-neutral-900 tw-mt-1">
                        <?php echo (isset($lead) && $lead->dateadded != '' ? '<span class="text-has-action" data-toggle="tooltip" data-title="' . e(_dt($lead->dateadded)) . '">' . e(time_ago($lead->dateadded)) . '</span>' : '-') ?>
                    </dd>
                    <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                        <?php echo _l('leads_dt_last_contact'); ?></dt>
                    <dd class="tw-text-neutral-900 tw-mt-1">
                        <?php echo (isset($lead) && $lead->lastcontact != '' ? '<span class="text-has-action" data-toggle="tooltip" data-title="' . e(_dt($lead->lastcontact)) . '">' . e(time_ago($lead->lastcontact)) . '</span>' : '-') ?>
                    </dd>
                    <dt class="lead-field-heading tw-font-medium tw-text-neutral-500"><?php echo _l('lead_public'); ?>
                    </dt>
                    <dd class="tw-text-neutral-900 tw-mt-1 mbot15">
                        <?php if (isset($lead)) {
                            if ($lead->is_public == 1) {
                                echo _l('lead_is_public_yes');
                            } else {
                                echo _l('lead_is_public_no');
                            }
                        } else {
                            echo '-';
                        }
                        ?>
                    </dd>
                    <?php if (isset($lead) && $lead->from_form_id != 0) { ?>
                    <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                        <?php echo _l('web_to_lead_form'); ?></dt>
                    <dd class="tw-text-neutral-900 tw-mt-1 mbot15"><?php echo e($lead->form_data->name); ?></dd>
                    <?php } ?>
                </dl>
            </div>
            <div class="col-md-4 col-xs-12 lead-information-col">
                
            </div>
            <div class="clearfix"></div>
            <div class="col-md-12">
                <dl>
                    <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                        <?php echo _l('lead_description'); ?></dt>
                    <dd class="tw-text-neutral-900 tw-mt-1">
                        <?php echo process_text_content_for_display((isset($lead) && $lead->description != '' ? $lead->description : '-')); ?>
                    </dd>
                </dl>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="lead-edit<?php if (isset($lead)) {
                                    echo ' hide';
                                } ?>">
            <div class="col-md-4">
                <?php
                $selected = '';
                if (isset($lead)) {
                    $selected = $lead->status;
                } elseif (isset($status_id)) {
                    $selected = $status_id;
                }
                echo render_leads_status_select($statuses, $selected, 'lead_add_edit_status');
                ?>
            </div>
            <div class="col-md-4">
                <?php
                $selected = (isset($lead) ? $lead->source : get_option('leads_default_source'));
                echo render_leads_source_select($sources, $selected, 'lead_add_edit_source');
                ?>
            </div>
            <div class="col-md-4">
                <?php
                // $assigned_attrs = [];
                // $selected       = (isset($lead) ? $lead->assigned : get_staff_user_id());
                // if (
                //     isset($lead)
                //     && $lead->assigned == get_staff_user_id()
                //     && $lead->addedfrom != get_staff_user_id()
                //     && !is_admin($lead->assigned)
                //     && staff_cant('view', 'leads')
                // ) {
                //     $assigned_attrs['disabled'] = true;
                //     $assigned_attrs['multiple'] = true; 
                //     $assigned_attrs['data-live-search'] = true;
                // }
                // echo render_select('assigned', $members, ['staffid', ['firstname', 'lastname']], 'lead_add_edit_assigned', $selected, $assigned_attrs); 
                

                ?>

                <div class="form-group">

                    <?php 
                     $assigned_value = (isset($lead) ? $lead->assigned : get_staff_user_id());
                     echo '<input type="hidden" name="assigned" value="' . htmlspecialchars($assigned_value) . '">';
                     
                     
                     $assigned = isset($lead) ? explode(',', $lead->assignees) : [get_staff_user_id()];
                     $selected = array_map('trim', $assigned); // Remove any whitespace around the IDs
                     
                     // Check if the current staff user ID is in the array of assignees
                    // $is_assigned = in_array(get_staff_user_id(), $assigned);
                     
                     // Now you can use $is_assigned as needed
                   //  $selected = $is_assigned ? $lead->assigned : get_staff_user_id();
                     
                    $assignees_attrs = [
                        'multiple' => true,
                        'data-live-search' => true,
                    ]; 
                    if (
                        isset($lead)
                        && in_array(get_staff_user_id(), $selected)
                        && $lead->addedfrom != get_staff_user_id()
                        && !is_admin(get_staff_user_id())
                        && staff_cant('view', 'leads')
                    ) {
                        $assignees_attrs['disabled'] = true;
                    }

                    echo render_select(
                        'assignees[]',
                        $members,
                        ['staffid', ['firstname', 'lastname']],
                        'lead_add_edit_assignees',
                        $selected,
                        $assignees_attrs,
                        [], // additional options
                        '', // no additional class
                        '', // no additional attributes
                        false // no translation for the label
                    );
                    ?>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="clearfix"></div>
            <hr class="no-mtop mbot15" />
            <div class="col-md-6">
                <?php $value = (isset($lead) ? $lead->name : ''); ?>
                <?php echo render_input('name', 'lead_add_edit_name', $value); ?>


                <?php $value = (isset($lead) ? $lead->phonenumber : ''); ?>
                <?php echo render_input('phonenumber', 'lead_add_edit_phonenumber', $value); ?>
                <?php $value = (isset($lead) ? $lead->address : ''); ?>
                <?php echo render_textarea('address', 'lead_address', $value, ['rows' => 1, 'style' => 'height:36px;font-size:100%;']); ?>
                <?php $value = (isset($lead) ? $lead->city : ''); ?>
                <?php echo render_input('city', 'lead_city', $value); ?>
            </div>
            <div class="col-md-6">

                <?php $value = (isset($lead) ? $lead->email : ''); ?>
                <?php echo render_input('email', 'lead_add_edit_email', $value); ?>



                <?php
                $countries                = get_all_countries();
                $customer_default_country = get_option('customer_default_country');
                $selected                 = (isset($lead) ? $lead->country : $customer_default_country);
                echo render_select('country', $countries, ['country_id', ['short_name']], 'lead_country', $selected, ['data-none-selected-text' => _l('dropdown_non_selected_tex')]);
                ?>
                <?php $value = (isset($lead) ? $lead->state : ''); ?>
                <?php echo render_input('state', 'lead_state', $value); ?>

                <?php $value = (isset($lead) ? $lead->zip : ''); ?>
                <?php echo render_input('zip', 'lead_zip', $value); ?>

            </div>
            <div class="col-md-12">
                <?php $value = (isset($lead) ? $lead->description : ''); ?>
                <?php echo render_textarea('description', 'lead_description', $value); ?>
                <div class="row">
                    <div class="col-md-12">
                        <?php if (!isset($lead)) { ?>
                        <div class="lead-select-date-contacted hide">
                            <?php echo render_datetime_input('custom_contact_date', 'lead_add_edit_datecontacted', '', ['data-date-end-date' => date('Y-m-d')]); ?>
                        </div>
                        <?php } else { ?>
                        <?php echo render_datetime_input('lastcontact', 'leads_dt_last_contact', _dt($lead->lastcontact), ['data-date-end-date' => date('Y-m-d')]); ?>
                        <?php } ?>
                        <div class="checkbox-inline checkbox checkbox-primary<?php if (isset($lead)) {
                                                                                    echo ' hide';
                                                                                } ?><?php if (isset($lead) && (is_lead_creator($lead->id) || staff_can('edit',  'leads'))) {
                        echo ' lead-edit';
                    } ?>">
                            <input type="checkbox" name="is_public" <?php if (isset($lead)) {
                                                                        if ($lead->is_public == 1) {
                                                                            echo 'checked';
                                                                        }
                                                                    }; ?> id="lead_public">
                            <label for="lead_public"><?php echo _l('lead_public'); ?></label>
                        </div>
                        <?php if (!isset($lead)) { ?>
                        <div class="checkbox-inline checkbox checkbox-primary">
                            <input type="checkbox" name="contacted_today" id="contacted_today" checked>
                            <label for="contacted_today"><?php echo _l('lead_add_edit_contacted_today'); ?></label>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
             
            <div class="clearfix"></div>
        </div>
    </div>
    <?php if (isset($lead)) { ?>
    <div class="lead-latest-activity tw-mb-3 lead-view">
        <div class="lead-info-heading">
            <h4><?php echo _l('lead_latest_activity'); ?></h4>
        </div>
        <div id="lead-latest-activity" class="pleft5"></div>
    </div>
    <?php } ?>
    <?php if ($lead_locked == false) { ?>
    <div class="lead-edit<?php echo isset($lead) ? ' hide' : ''; ?>">
        <hr class="-tw-mx-4 tw-border-neutral-200" />
        <button type="submit" class="btn btn-primary pull-right lead-save-btn" id="lead-form-submit">
            <?php echo _l('submit'); ?>
        </button>
        <button type=" button" class="btn btn-default pull-right mright5" data-dismiss="modal">
            <?php echo _l('close'); ?>
        </button>
    </div>
    <?php } ?>
    <div class="clearfix"></div>
    <?php echo form_close(); ?>
</div>
<?php if (isset($lead) && $lead_locked == true) { ?>
<script>
$(function() {
    // Set all fields to disabled if lead is locked
    $.each($('.lead-wrapper').find('input, select, textarea'), function() {
        $(this).attr('disabled', true);
        if ($(this).is('select')) {
            $(this).selectpicker('refresh');
        }
    });
});
</script>
<?php } ?>