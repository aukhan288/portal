<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="modal fade" id="convert_lead_to_client_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <?php echo form_open('admin/leads/convert_to_customer', ['id' => 'lead_to_client_form']); ?>
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span
                        aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">
                    <?php echo _l('lead_convert_to_client'); ?>
                </h4>
            </div>
            <div class="modal-body">
                <?php echo form_hidden('leadid', $lead->id); ?>
                <?php if (mb_strpos($lead->name, ' ') !== false) {
    $_temp     = explode(' ', $lead->name);
    $firstname = $_temp[0];
    if (isset($_temp[2])) {
        $lastname = $_temp[1] . ' ' . $_temp[2];
    } else {
        $lastname = $_temp[1];
    }
} else {
    $lastname  = '';
    $firstname = $lead->name;
}
           ?>
                <?php echo form_hidden('default_language', $lead->default_language); ?>
                <?php echo render_input('firstname', 'lead_convert_to_client_firstname', $firstname); ?>
                <?php   
                //echo  render_input('lastname', 'lead_convert_to_client_lastname', $lastname);
                 ?>
                <?php echo render_input('title', 'contact_position', $lead->title); ?>
                <?php echo render_input('email', 'lead_convert_to_email', $lead->email); ?>
                <?php   
                // echo  render_input('company', 'lead_company', $lead->company); 
                ?>
                <?php echo 
                render_input('phonenumber', 'lead_convert_to_client_phone', $lead->phonenumber); 
                ?>
                <?php   
                // echo render_input('website', 'client_website', $lead->website);
                 ?>
                <?php echo render_textarea('address', 'client_address', $lead->address); ?>
                <?php echo render_input('city', 'client_city', $lead->city); ?>
                <?php echo render_input('state', 'client_state', $lead->state); ?>
                <?php
           $countries                = get_all_countries();
           $customer_default_country = get_option('customer_default_country');
           $selected                 = ($lead->country != 0 ? $lead->country : $customer_default_country);
           echo render_select('country', $countries, [ 'country_id', [ 'short_name']], 'clients_country', $selected, ['data-none-selected-text' => _l('dropdown_non_selected_tex')]);
           ?>
                <?php echo render_input('zip', 'clients_zip', $lead->zip); ?>
                <?php
           $not_mergable_customer_fields = ['userid', 'datecreated', 'leadid', 'default_language', 'default_currency', 'active'];
           $not_mergable_contact_fields  = ['id', 'userid', 'datecreated', 'is_primary', 'password', 'new_pass_key', 'new_pass_key_requested', 'last_ip', 'last_login', 'last_password_change', 'active', 'profile_image', 'direction'];
           $customer_fields              = $this->db->list_fields(db_prefix() . 'clients');
           $contact_fields               = $this->db->list_fields(db_prefix() . 'contacts');
           $custom_fields                = get_custom_fields('leads');
           $found_custom_fields          = false;
           foreach ($custom_fields as $field) {
               $value = get_custom_field_value($lead->id, $field['id'], 'leads');
               if ($value == '') {
                   continue;
               }
               $found_custom_fields = true;
           }
        if ($found_custom_fields == true) {
            echo '<h4 class="bold text-center mtop30">' . _l('copy_custom_fields_convert_to_customer') . '</h4><hr />';
        }
      foreach ($custom_fields as $field) {
          $value = get_custom_field_value($lead->id, $field['id'], 'leads');
          if ($value == '') {
              continue;
          } ?>
                <p class="bold text-info"><?php echo e($field['name']); ?> (<?php echo $value; ?>)</p>
                <hr />
                <p class="bold no-margin"><?php echo _l('leads_merge_customer'); ?></p>
                <div class="radio radio-primary">
                    <input type="radio" data-field-id="<?php echo e($field['id']); ?>" id="m_1_<?php echo e($field['id']); ?>"
                        class="include_leads_custom_fields" checked
                        name="include_leads_custom_fields[<?php echo e($field['id']); ?>]" value="1">
                    <label for="m_1_<?php echo e($field['id']); ?>" class="bold">
                        <span data-toggle="tooltip"
                            data-title="<?php echo _l('copy_custom_fields_convert_to_customer_help'); ?>"><i
                                class="fa fa-info-circle"></i></span> <?php echo _l('lead_merge_custom_field'); ?>
                    </label>
                </div>
                <div class="radio radio-primary">
                    <input type="radio" data-field-id="<?php echo e($field['id']); ?>" id="m_2_<?php echo e($field['id']); ?>"
                        class="include_leads_custom_fields"
                        name="include_leads_custom_fields[<?php echo e($field['id']); ?>]" value="2">
                    <label for="m_2_<?php echo e($field['id']); ?>" class="bold">
                        <?php echo _l('lead_merge_custom_field_existing'); ?>
                    </label>
                </div>
                <div class="hide" id="merge_db_field_<?php echo e($field['id']); ?>">
                    <hr />
                    <select name="merge_db_fields[<?php echo e($field['id']); ?>]" class="selectpicker" data-width="100%"
                        data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                        <option value=""></option>
                        <?php foreach ($customer_fields as $c_field) {
              if (!in_array($c_field, $not_mergable_customer_fields)) {
                  echo '<option value="' . $c_field . '">' . str_replace('_', ' ', ucfirst($c_field)) . '</option>';
              }
          } ?>
                    </select>
                    <hr />
                </div>
                <p class="bold"><?php echo _l('leads_merge_contact'); ?></p>
                <div class="radio radio-primary">
                    <input type="radio" data-field-id="<?php echo e($field['id']); ?>" id="m_3_<?php echo e($field['id']); ?>"
                        class="include_leads_custom_fields"
                        name="include_leads_custom_fields[<?php echo e($field['id']); ?>]" value="3">
                    <label for="m_3_<?php echo e($field['id']); ?>" class="bold">
                        <?php echo _l('leads_merge_as_contact_field'); ?>
                    </label>
                </div>
                <div class="radio radio-primary">
                    <input type="radio" data-field-id="<?php echo e($field['id']); ?>" id="m_4_<?php echo e($field['id']); ?>"
                        class="include_leads_custom_fields"
                        name="include_leads_custom_fields[<?php echo e($field['id']); ?>]" value="4">
                    <label for="m_4_<?php echo e($field['id']); ?>" class="bold">
                        <span data-toggle="tooltip"
                            data-title="<?php echo _l('copy_custom_fields_convert_to_customer_help'); ?>"><i
                                class="fa fa-info-circle"></i></span>
                        <?php echo _l('lead_merge_custom_field'); ?>
                    </label>
                </div>
                <div class="hide" id="merge_db_contact_field_<?php echo e($field['id']); ?>">
                    <hr />
                    <select name="merge_db_contact_fields[<?php echo e($field['id']); ?>]" class="selectpicker"
                        data-width="100%" data-none-selected-text="<?php echo _l('dropdown_non_selected_tex'); ?>">
                        <option value=""></option>
                        <?php foreach ($contact_fields as $c_field) {
              if (!in_array($c_field, $not_mergable_contact_fields)) {
                  echo '<option value="' . $c_field . '">' . str_replace('_', ' ', ucfirst($c_field)) . '</option>';
              }
          } ?>
                    </select>
                </div>
                <hr />
                <div class="radio radio-primary">
                    <input type="radio" data-field-id="<?php echo e($field['id']); ?>" id="m_5_<?php echo e($field['id']); ?>"
                        class="include_leads_custom_fields"
                        name="include_leads_custom_fields[<?php echo e($field['id']); ?>]" value="5">
                    <label for="m_5_<?php echo e($field['id']); ?>" class="bold">
                        <?php echo _l('lead_dont_merge_custom_field'); ?>
                    </label>
                </div>
                <hr />
                <?php
      } ?>
                <?php echo form_hidden('original_lead_email', $lead->email); ?>

                <!-- fake fields are a workaround for chrome autofill getting the wrong fields -->
                <input type="text" class="fake-autofill-field" name="fakeusernameremembered" value='' tabindex="-1" />
                <input type="password" class="fake-autofill-field" name="fakepasswordremembered" value=''
                    tabindex="-1" />
 
                <?php 
                //if (total_rows(db_prefix() . 'notes', ['rel_type' => 'lead', 'rel_id' => $lead->id]) > 0) { 
                ?>
                <div class="checkbox checkbox-primary">
                    <input type="checkbox" name="transfer_notes" id="transfer_notes">
                    <label for="transfer_notes"><?php echo _l('transfer_lead_notes_to_customer'); ?></label>
                </div>
                <!-- <div class="checkbox checkbox-primary">
                    <input type="checkbox" name="transfer_comments" id="transfer_comments">
                    <label for="transfer_comments">PFF & PAA</label>
                </div> -->
                <?php// } ?>
                <?php if (is_gdpr() && get_option('gdpr_enable_consent_for_contacts') == '1' && count($purposes) > 0) { ?>
                <div class="checkbox checkbox-primary">
                    <input type="checkbox" name="transfer_consent" id="transfer_consent">
                    <label for="transfer_consent"><?php echo _l('transfer_consent'); ?></label>
                </div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                    onclick="init_lead(<?php echo e($lead->id); ?>); return false;"
                    data-dismiss="modal"><?php echo _l('back_to_lead'); ?></button>
                <button type="submit" data-form="#lead_to_client_form" autocomplete="off"
                    data-loading-text="<?php echo _l('wait_text'); ?>"
                    class="btn btn-primary"><?php echo _l('submit'); ?></button>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
<script>
validate_lead_convert_to_client_form();
init_selectpicker();
</script>