<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>

<?php if (isset($client)) { ?>
    <h4 class="customer-profile-group-heading"><?php echo _l('client_add_edit_profile'); ?></h4>
<?php } ?>

<div class="row">
    <div class="additional"></div>

    <div class="col-md-12">
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#profileview" aria-controls="profileview" role="tab"
                    data-toggle="tab">Details</a>
            </li>
            <li role="presentation"><a href="#profileform" aria-controls="profileform" role="tab" data-toggle="tab">Edit
                    Customer</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="profileview">
                <div class="row">
                    <div class="lead-view<?php if (!isset($lead)) {
                                                echo " hide";
                                            } ?>" id="leadViewWrapper">
                        <div class="col-md-4 col-xs-12 lead-information-col">
                            <div class="lead-info-heading">
                                <h4>
                                    Customer Info
                                </h4>
                            </div>
                            <dl>
                                <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                                    <?php echo _l("lead_add_edit_name"); ?></dt>
                                <dd class="tw-text-neutral-900 tw-mt-1 lead-name">
                                    <?php echo isset($lead) && $lead->name != "" ? e($lead->name) : "-"; ?>
                                </dd>

                                <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                                    <?php echo _l("lead_add_edit_email"); ?></dt>
                                <dd class="tw-text-neutral-900 tw-mt-1">
                                    <?php echo isset($lead) && $lead->email != ""
                                        ? '<a href="mailto:' .
                                        e($lead->email) .
                                        '">' .
                                        e($lead->email) .
                                        "</a>"
                                        : "-"; ?>
                                </dd>


                                <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                                    <?php echo _l("lead_add_edit_phonenumber"); ?></dt>
                                <dd class="tw-text-neutral-900 tw-mt-1">
                                    <?php echo isset($lead) && $lead->phonenumber != ""
                                        ? '<a href="tel:' .
                                        e($lead->phonenumber) .
                                        '">' .
                                        e($lead->phonenumber) .
                                        "</a>"
                                        : "-"; ?>
                                </dd>
                                <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                                    <?php echo _l("lead_address"); ?>
                                </dt>
                                <dd class="tw-text-neutral-900 tw-mt-1">
                                    <?php echo isset($lead) && $lead->address != ""
                                        ? process_text_content_for_display($lead->address)
                                        : "-"; ?>
                                </dd>
                                <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                                    <?php echo _l("lead_city"); ?>
                                </dt>
                                <dd class="tw-text-neutral-900 tw-mt-1">
                                    <?php echo isset($lead) && $lead->city != "" ? e($lead->city) : "-"; ?>
                                </dd>
                                <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                                    <?php echo _l("lead_state"); ?>
                                </dt>
                                <dd class="tw-text-neutral-900 tw-mt-1">
                                    <?php echo isset($lead) && $lead->state != "" ? e($lead->state) : "-"; ?>
                                </dd>
                                <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                                    <?php echo _l("lead_country"); ?>
                                </dt>
                                <dd class="tw-text-neutral-900 tw-mt-1">
                                    <?php echo isset($lead) && $lead->country != 0
                                        ? e(get_country($lead->country)->short_name)
                                        : "-"; ?>
                                </dd>
                                <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                                    <?php echo _l("lead_zip"); ?></dt>
                                <dd class="tw-text-neutral-900 tw-mt-1">
                                    <?php echo isset($lead) && $lead->zip != "" ? e($lead->zip) : "-"; ?>
                                </dd>
                            </dl>
                        </div>
                        <div class="col-md-4 col-xs-12 lead-information-col  ">

                            <dl class="mt-4 pt-4">
                                <dt class="lead-field-heading tw-font-medium tw-text-neutral-500 mt-4 pt-4 ">
                                    <?php echo _l("lead_add_edit_status"); ?>
                                </dt>
                                <dd class="tw-text-neutral-900 tw-mt-2 mbot15">
                                 
                                 
                                    <?php if (isset($lead)) {
                                        echo form_open((isset($lead) ? admin_url('clients/client_status_update/' . $client->userid) : admin_url('clients/client_status_update')), ['id' => 'client_status_form']);  
                                        echo render_customer_status_select( $client->status  );
                                         echo form_close();  
                                    } else {
                                        echo "-";
                                    } ?>
                                </dd>
                                <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                                    <?php echo _l("lead_add_edit_source"); ?></dt>
                                <dd class="tw-text-neutral-900 tw-mt-1 mbot15">
                                    <?php
                                     echo (isset($lead) && $lead->source != '' ? e( get_source_name_by_id($lead->source)) : '-')
                                    ?>
                                </dd>

                                <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                                    <?php echo _l("lead_add_edit_assignees"); ?></dt>
                                <dd class="tw-text-neutral-900 tw-mt-1 mbot15">
                                    <?php
                                    // echo (isset($lead) && $lead->assigned != 0 ? e(get_staff_full_name($lead->assigned)) : '-')
                                    ?>
                                    <?php if (isset($lead) && !empty($lead->assignees)) {
                                        $assignees = is_array($lead->assignees)
                                            ? $lead->assignees
                                            : explode(",", $lead->assignees);
                                        $assigneeNames = [];
                                        foreach ($assignees as $assignee) {
                                            $assigneeNames[] = e(
                                                get_staff_full_name(trim($assignee))
                                            );
                                        }
                                        echo implode(", ", $assigneeNames);
                                    } else {
                                        echo "-";
                                    } ?>


                                </dd>

                                <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                                    <?php echo _l("leads_dt_datecreated"); ?></dt>
                                <dd class="tw-text-neutral-900 tw-mt-1">
                                    <?php echo isset($lead) && $lead->dateadded != ""
                                        ? '<span class="text-has-action" data-toggle="tooltip" data-title="' .
                                        e(_dt($lead->dateadded)) .
                                        '">' .
                                        e(time_ago($lead->dateadded)) .
                                        "</span>"
                                        : "-"; ?>
                                </dd>
                                <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                                    <?php echo _l("leads_dt_last_contact"); ?></dt>
                                <dd class="tw-text-neutral-900 tw-mt-1">
                                    <?php echo isset($lead) && $lead->lastcontact != ""
                                        ? '<span class="text-has-action" data-toggle="tooltip" data-title="' .
                                        e(_dt($lead->lastcontact)) .
                                        '">' .
                                        e(time_ago($lead->lastcontact)) .
                                        "</span>"
                                        : "-"; ?>
                                </dd>
                                <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                                    <?php echo _l("lead_public"); ?>
                                </dt>
                                <dd class="tw-text-neutral-900 tw-mt-1 mbot15">
                                    <?php if (isset($lead)) {
                                        if ($lead->is_public == 1) {
                                            echo _l("lead_is_public_yes");
                                        } else {
                                            echo _l("lead_is_public_no");
                                        }
                                    } else {
                                        echo "-";
                                    } ?>
                                </dd>
                                <?php if (isset($lead) && $lead->from_form_id != 0) { ?>
                                    <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                                        <?php echo _l("web_to_lead_form"); ?></dt>
                                    <dd class="tw-text-neutral-900 tw-mt-1 mbot15">
                                        <?php echo e($lead->form_data->name); ?></dd>
                                <?php } ?>
                            </dl>
                        </div>
                        <div class="col-md-4 col-xs-12 lead-information-col">

                            <div class="lead-info-heading">
                                <h4>
                                    Survey Completed
                                </h4>
                            </div>
                            <dl>
                                <?php echo form_open((isset($lead) ? admin_url('leads/lead_survey_update/' . $lead->id) : admin_url('leads/lead_survey_update')), ['id' => 'lead_form']); ?>


                                <?php $rel_id = (isset($lead) ? $lead->id : false); ?>
                                <div id="surveyfields">

                                    <?php echo render_custom_fields('leads', $rel_id); ?>
                                </div>
                                <button type="submit" class="btn btn-primary pull-right lead-save-btn" id="lead-form-submit">
                                    <?php echo _l('submit'); ?>
                                </button>
                                <?php echo form_close(); ?>
                            </dl>
                        </div>
                        <div class="clearfix"></div>
                        <div class="col-md-12">
                            <dl>
                                <dt class="lead-field-heading tw-font-medium tw-text-neutral-500">
                                    <?php echo _l("lead_description"); ?></dt>
                                <dd class="tw-text-neutral-900 tw-mt-1">
                                    <?php echo process_text_content_for_display(
                                        isset($lead) && $lead->description != ""
                                            ? $lead->description
                                            : "-"
                                    ); ?>
                                </dd>
                            </dl>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="lead-edit<?php if (isset($lead)) {
                                                echo " hide";
                                            } ?>">
                        <div class="col-md-4">

                        </div>
                        <div class="col-md-4">

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

                                ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                    </div>
                </div>

            </div>
            <div role="tabpanel" class="tab-pane" id="profileform">
                <?php echo form_open($this->uri->uri_string(), ['class' => 'client-form', 'autocomplete' => 'off']); ?>

                <div class="col-md-12">
                    <div class="horizontal-scrollable-tabs panel-full-width-tabs">
                        <div class="scroller arrow-left"><i class="fa fa-angle-left"></i></div>
                        <div class="scroller arrow-right"><i class="fa fa-angle-right"></i></div>
                        <div class="horizontal-tabs">
                            <ul class="nav nav-tabs customer-profile-tabs nav-tabs-horizontal" role="tablist">
                                <li role="presentation"
                                    class="<?php echo !$this->input->get('tab') ? 'active' : ''; ?>">
                                    <a href="#contact_info" aria-controls="contact_info" role="tab" data-toggle="tab">
                                        <?php echo _l('customer_profile_details'); ?>
                                    </a>
                                </li>
                                <?php
                                $customer_custom_fields = false;
                                if (total_rows(db_prefix() . 'customfields', ['fieldto' => 'customers', 'active' => 1]) > 0) {
                                    $customer_custom_fields = true; ?>
                                    <li role="presentation" class="<?php if ($this->input->get('tab') == 'custom_fields') {
                                                                        echo 'active';
                                                                    }; ?>">
                                        <a href="#custom_fields" aria-controls="custom_fields" role="tab" data-toggle="tab">
                                            <?php echo hooks()->apply_filters('customer_profile_tab_custom_fields_text', _l('custom_fields')); ?>
                                        </a>
                                    </li>
                                <?php
                                } ?>
                                <li role="presentation">
                                    <a href="#billing_and_shipping" aria-controls="billing_and_shipping" role="tab"
                                        data-toggle="tab">
                                        <?php echo _l('billing_shipping'); ?>
                                    </a>
                                </li>
                                <?php hooks()->do_action('after_customer_billing_and_shipping_tab', isset($client) ? $client : false); ?>
                                <?php if (isset($client)) { ?>
                                    <li role="presentation">
                                        <a href="#customer_admins" aria-controls="customer_admins" role="tab"
                                            data-toggle="tab">
                                            <?php echo _l('customer_admins'); ?>
                                            <?php if (count($customer_admins) > 0) { ?>
                                                <span class="badge bg-default"><?php echo count($customer_admins) ?></span>
                                            <?php } ?>
                                        </a>
                                    </li>
                                    <?php hooks()->do_action('after_customer_admins_tab', $client); ?>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-content mtop15">
                        <?php hooks()->do_action('after_custom_profile_tab_content', isset($client) ? $client : false); ?>
                        <?php if ($customer_custom_fields) { ?>
                            <div role="tabpanel" class="tab-pane <?php if ($this->input->get('tab') == 'custom_fields') {
                                                                        echo ' active';
                                                                    }; ?>" id="custom_fields">
                                <?php $rel_id = (isset($client) ? $client->userid : false); ?>
                                <?php echo render_custom_fields('customers', $rel_id); ?>
                            </div>
                        <?php } ?>
                        <div role="tabpanel" class="tab-pane<?php if (!$this->input->get('tab')) {
                                                                echo ' active';
                                                            }; ?>" id="contact_info">
                            <div class="row">
                                <div class="col-md-12 <?php if (isset($client) && (!is_empty_customer_company($client->userid) && total_rows(db_prefix() . 'contacts', ['userid' => $client->userid, 'is_primary' => 1]) > 0)) {
                                                            echo '';
                                                        } else {
                                                            echo ' hide';
                                                        } ?>" id="client-show-primary-contact-wrapper">
                                    <div class="checkbox checkbox-info mbot20 no-mtop">
                                        <input type="checkbox" name="show_primary_contact" <?php if (isset($client) && $client->show_primary_contact == 1) {
                                                                                                echo ' checked';
                                                                                            } ?> value="1" id="show_primary_contact">
                                        <label
                                            for="show_primary_contact"><?php echo _l('show_primary_contact', _l('invoices') . ', ' . _l('estimates') . ', ' . _l('payments') . ', ' . _l('credit_notes')); ?></label>
                                    </div>
                                </div>
                                <div class="col-md-<?php echo !isset($client) ? 12 : 8; ?>">
                                    <?php hooks()->do_action('before_customer_profile_company_field', $client ?? null); ?>
                                    <?php $value = (isset($client) ? $client->company : ''); ?>
                                    <?php $attrs = (isset($client) ? [] : ['autofocus' => true]); ?>
                                    <?php echo render_input('company', 'client_company', $value, 'text', $attrs); ?>
                                    <div id="company_exists_info" class="hide"></div>
                                    <?php hooks()->do_action('after_customer_profile_company_field', $client ?? null); ?>
                                    <?php if (get_option('company_requires_vat_number_field') == 1) {
                                        $value = (isset($client) ? $client->vat : '');
                                        echo render_input('vat', 'client_vat_number', $value);
                                    } ?>
                                    <?php hooks()->do_action('before_customer_profile_phone_field', $client ?? null); ?>
                                    <?php $value = (isset($client) ? $client->phonenumber : ''); ?>
                                    <?php echo render_input('phonenumber', 'client_phonenumber', $value); ?>
                                    <?php hooks()->do_action('after_customer_profile_company_phone', $client ?? null); ?>
                                    <?php if ((isset($client) && empty($client->website)) || !isset($client)) {
                                        $value = (isset($client) ? $client->website : '');
                                        echo render_input('website', 'client_website', $value);
                                    } else { ?>
                                        <div class="form-group">
                                            <label for="website"><?php echo _l('client_website'); ?></label>
                                            <div class="input-group">
                                                <input type="text" name="website" id="website"
                                                    value="<?php echo e($client->website); ?>" class="form-control">
                                                <span class="input-group-btn">
                                                    <a href="<?php echo e(maybe_add_http($client->website)); ?>"
                                                        class="btn btn-default" target="_blank" tabindex="-1">
                                                        <i class="fa fa-globe"></i></a>
                                                </span>

                                            </div>
                                        </div>
                                    <?php }
                                    $selected = [];
                                    if (isset($customer_groups)) {
                                        foreach ($customer_groups as $group) {
                                            array_push($selected, $group['groupid']);
                                        }
                                    }
                                    if (is_admin() || get_option('staff_members_create_inline_customer_groups') == '1') {
                                        echo render_select_with_input_group('groups_in[]', $groups, ['id', 'name'], 'customer_groups', $selected, '<div class="input-group-btn"><a href="#" class="btn btn-default" data-toggle="modal" data-target="#customer_group_modal"><i class="fa fa-plus"></i></a></div>', ['multiple' => true, 'data-actions-box' => true], [], '', '', false);
                                    } else {
                                        echo render_select('groups_in[]', $groups, ['id', 'name'], 'customer_groups', $selected, ['multiple' => true, 'data-actions-box' => true], [], '', '', false);
                                    }
                                    ?>
                                    <div class="row">
                                        <div class="col-md-<?php echo !is_language_disabled() ? 6 : 12; ?>">
                                            <i class="fa-regular fa-circle-question pull-left tw-mt-0.5 tw-mr-1"
                                                data-toggle="tooltip"
                                                data-title="<?php echo _l('customer_currency_change_notice'); ?>"></i>
                                            <?php
                                            $s_attrs  = ['data-none-selected-text' => _l('system_default_string')];
                                            $selected = '';
                                            if (isset($client) && client_have_transactions($client->userid)) {
                                                $s_attrs['disabled'] = true;
                                            }
                                            foreach ($currencies as $currency) {
                                                if (isset($client)) {
                                                    if ($currency['id'] == $client->default_currency) {
                                                        $selected = $currency['id'];
                                                    }
                                                }
                                            }
                                            // Do not remove the currency field from the customer profile!
                                            echo render_select('default_currency', $currencies, ['id', 'name', 'symbol'], 'invoice_add_edit_currency', $selected, $s_attrs);
                                            ?>
                                        </div>
                                        <?php if (!is_language_disabled()) { ?>
                                            <div class="col-md-6">

                                                <div class="form-group select-placeholder">
                                                    <label for="default_language"
                                                        class="control-label"><?php echo _l('localization_default_language'); ?>
                                                    </label>
                                                    <select name="default_language" id="default_language"
                                                        class="form-control selectpicker"
                                                        data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                                                        <option value=""><?php echo _l('system_default_string'); ?></option>
                                                        <?php foreach ($this->app->get_available_languages() as $availableLanguage) {
                                                            $selected = '';
                                                            if (isset($client)) {
                                                                if ($client->default_language == $availableLanguage) {
                                                                    $selected = 'selected';
                                                                }
                                                            } ?>
                                                            <option value="<?php echo e($availableLanguage); ?>"
                                                                <?php echo e($selected); ?>>
                                                                <?php echo e(ucfirst($availableLanguage)); ?></option>
                                                        <?php
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>

                                    <hr />

                                    <?php $value = (isset($client) ? $client->address : ''); ?>
                                    <?php echo render_textarea('address', 'client_address', $value); ?>
                                    <?php $value = (isset($client) ? $client->city : ''); ?>
                                    <?php echo render_input('city', 'client_city', $value); ?>
                                    <?php $value = (isset($client) ? $client->state : ''); ?>
                                    <?php echo render_input('state', 'client_state', $value); ?>
                                    <?php $value = (isset($client) ? $client->zip : ''); ?>
                                    <?php echo render_input('zip', 'client_postal_code', $value); ?>
                                    <?php $countries       = get_all_countries();
                                    $customer_default_country = get_option('customer_default_country');
                                    $selected                 = (isset($client) ? $client->country : $customer_default_country);
                                    echo render_select('country', $countries, ['country_id', ['short_name']], 'clients_country', $selected, ['data-none-selected-text' => _l('dropdown_non_selected_tex')]);
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php if (isset($client)) { ?>
                            <div role="tabpanel" class="tab-pane" id="customer_admins">
                                <?php if (staff_can('create',  'customers') || staff_can('edit',  'customers')) { ?>
                                    <a href="#" data-toggle="modal" data-target="#customer_admins_assign"
                                        class="btn btn-primary mbot30"><?php echo _l('assign_admin'); ?></a>
                                <?php } ?>
                                <table class="table dt-table">
                                    <thead>
                                        <tr>
                                            <th><?php echo _l('staff_member'); ?></th>
                                            <th><?php echo _l('customer_admin_date_assigned'); ?></th>
                                            <?php if (staff_can('create',  'customers') || staff_can('edit',  'customers')) { ?>
                                                <th><?php echo _l('options'); ?></th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($customer_admins as $c_admin) { ?>
                                            <tr>
                                                <td><a href="<?php echo admin_url('profile/' . $c_admin['staff_id']); ?>">
                                                        <?php echo staff_profile_image($c_admin['staff_id'], [
                                                            'staff-profile-image-small',
                                                            'mright5',
                                                        ]);
                                                        echo e(get_staff_full_name($c_admin['staff_id'])); ?></a>
                                                </td>
                                                <td data-order="<?php echo e($c_admin['date_assigned']); ?>">
                                                    <?php echo e(_dt($c_admin['date_assigned'])); ?></td>
                                                <?php if (staff_can('create',  'customers') || staff_can('edit',  'customers')) { ?>
                                                    <td>
                                                        <a href="<?php echo admin_url('clients/delete_customer_admin/' . $client->userid . '/' . $c_admin['staff_id']); ?>"
                                                            class="tw-mt-px tw-text-neutral-500 hover:tw-text-neutral-700 focus:tw-text-neutral-700 _delete">
                                                            <i class="fa-regular fa-trash-can fa-lg"></i>
                                                        </a>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php } ?>
                        <div role="tabpanel" class="tab-pane" id="billing_and_shipping">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4
                                                class="tw-font-medium tw-text-base tw-text-neutral-700 tw-flex tw-justify-between tw-items-center tw-mt-0 tw-mb-6">
                                                <?php echo _l('billing_address'); ?>
                                                <a href="#"
                                                    class="billing-same-as-customer tw-text-sm tw-text-neutral-500 hover:tw-text-neutral-700 active:tw-text-neutral-700">
                                                    <?php echo _l('customer_billing_same_as_profile'); ?>
                                                </a>
                                            </h4>

                                            <?php $value = (isset($client) ? $client->billing_street : ''); ?>
                                            <?php echo render_textarea('billing_street', 'billing_street', $value); ?>
                                            <?php $value = (isset($client) ? $client->billing_city : ''); ?>
                                            <?php echo render_input('billing_city', 'billing_city', $value); ?>
                                            <?php $value = (isset($client) ? $client->billing_state : ''); ?>
                                            <?php echo render_input('billing_state', 'billing_state', $value); ?>
                                            <?php $value = (isset($client) ? $client->billing_zip : ''); ?>
                                            <?php echo render_input('billing_zip', 'billing_zip', $value); ?>
                                            <?php $selected = (isset($client) ? $client->billing_country : ''); ?>
                                            <?php echo render_select('billing_country', $countries, ['country_id', ['short_name']], 'billing_country', $selected, ['data-none-selected-text' => _l('dropdown_non_selected_tex')]); ?>
                                        </div>
                                        <div class="col-md-6">
                                            <h4
                                                class="tw-font-medium tw-text-base tw-text-neutral-700 tw-flex tw-justify-between tw-items-center tw-mt-0 tw-mb-6">
                                                <span>
                                                    <i class="fa-regular fa-circle-question tw-mr-1"
                                                        data-toggle="tooltip"
                                                        data-title="<?php echo _l('customer_shipping_address_notice'); ?>"></i>

                                                    <?php echo _l('shipping_address'); ?>
                                                </span>
                                                <a href="#"
                                                    class="customer-copy-billing-address tw-text-sm tw-text-neutral-500 hover:tw-text-neutral-700 active:tw-text-neutral-700">
                                                    <?php echo _l('customer_billing_copy'); ?>
                                                </a>
                                            </h4>

                                            <?php $value = (isset($client) ? $client->shipping_street : ''); ?>
                                            <?php echo render_textarea('shipping_street', 'shipping_street', $value); ?>
                                            <?php $value = (isset($client) ? $client->shipping_city : ''); ?>
                                            <?php echo render_input('shipping_city', 'shipping_city', $value); ?>
                                            <?php $value = (isset($client) ? $client->shipping_state : ''); ?>
                                            <?php echo render_input('shipping_state', 'shipping_state', $value); ?>
                                            <?php $value = (isset($client) ? $client->shipping_zip : ''); ?>
                                            <?php echo render_input('shipping_zip', 'shipping_zip', $value); ?>
                                            <?php $selected = (isset($client) ? $client->shipping_country : ''); ?>
                                            <?php echo render_select('shipping_country', $countries, ['country_id', ['short_name']], 'shipping_country', $selected, ['data-none-selected-text' => _l('dropdown_non_selected_tex')]); ?>
                                        </div>
                                        <?php if (
                                            isset($client) &&
                                            (total_rows(db_prefix() . 'invoices', ['clientid' => $client->userid]) > 0 || total_rows(db_prefix() . 'estimates', ['clientid' => $client->userid]) > 0 || total_rows(db_prefix() . 'creditnotes', ['clientid' => $client->userid]) > 0)
                                        ) { ?>
                                            <div class="col-md-12">
                                                <div class="alert alert-warning">
                                                    <div class="checkbox checkbox-default -tw-mb-0.5">
                                                        <input type="checkbox" name="update_all_other_transactions"
                                                            id="update_all_other_transactions">
                                                        <label for="update_all_other_transactions">
                                                            <?php echo _l('customer_update_address_info_on_invoices'); ?><br />
                                                        </label>
                                                    </div>
                                                    <p class="tw-ml-7 tw-mb-0">
                                                        <?php echo _l('customer_update_address_info_on_invoices_help'); ?>
                                                    </p>
                                                    <div class="checkbox checkbox-default">
                                                        <input type="checkbox" name="update_credit_notes"
                                                            id="update_credit_notes">
                                                        <label for="update_credit_notes">
                                                            <?php echo _l('customer_profile_update_credit_notes'); ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-footer text-right tw-space-x-1" id="profile-save-section">
                            <?php if (!isset($client)) { ?>
                                <button class="btn btn-default save-and-add-contact customer-form-submiter">
                                    <?php echo _l("save_customer_and_add_contact"); ?>
                                </button>
                            <?php } ?>
                            <button class="btn btn-primary only-save customer-form-submiter">
                                <?php echo _l("submit"); ?>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<?php echo form_close(); ?>
</div>
<?php if (isset($client)) { ?>
    <?php if (staff_can('create',  'customers') || staff_can('edit',  'customers')) { ?>
        <div class="modal fade" id="customer_admins_assign" tabindex="-1" role="dialog">
            <div class="modal-dialog">
                <?php echo form_open(admin_url('clients/assign_admins/' . $client->userid)); ?>
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><?php echo _l('assign_admin'); ?></h4>
                    </div>
                    <div class="modal-body">
                        <?php
                        $selected = [];
                        foreach ($customer_admins as $c_admin) {
                            array_push($selected, $c_admin['staff_id']);
                        }
                        echo render_select('customer_admins[]', $staff, ['staffid', ['firstname', 'lastname']], '', $selected, ['multiple' => true], [], '', '', false); ?>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _l('close'); ?></button>
                        <button type="submit" class="btn btn-primary"><?php echo _l('submit'); ?></button>
                    </div>
                </div>
                <!-- /.modal-content -->
                <?php echo form_close(); ?>
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    <?php } ?>
<?php } ?>
<?php $this->load->view('admin/clients/client_group'); ?>