<?php

defined('BASEPATH') or exit('No direct script access allowed');

use Twilio\Rest\Client;

hooks()->add_action('admin_init', 'maybe_test_sms_gateway');

function maybe_test_sms_gateway()
{
    $CI = &get_instance();
    if (is_staff_logged_in() && $CI->input->post('sms_gateway_test')) {
        $gateway = $CI->{'sms_' . $CI->input->post('id')};

        $gateway->set_test_mode(true);

        $retval = $gateway->send(
            $CI->input->post('number'),
            clear_textarea_breaks(nl2br($CI->input->post('message')))
        );

        $response = ['success' => false];

        if (isset($GLOBALS['sms_error'])) {
            $response['error'] = $GLOBALS['sms_error'];
        } else {
            $response['success'] = true;
        }

        $gateway->set_test_mode(false);

        echo json_encode($response);
        die;
    }
}

hooks()->add_action('admin_init', '_maybe_sms_gateways_settings_group');

function _maybe_sms_gateways_settings_group($groups)
{
    $CI = &get_instance();

    $gateways = $CI->app_sms->get_gateways();

    if (count($gateways) > 0) {
        $CI->app_tabs->add_settings_tab('sms', [
            'name'     => 'SMS',
            'view'     => 'admin/settings/includes/sms',
            'position' => 60,
            'icon'     => 'fa-regular fa-message',
        ]);
    }
}

hooks()->add_action('app_init', 'app_init_sms_gateways');

function app_init_sms_gateways()
{
    $CI = &get_instance();

    $gateways = [
        'sms/sms_clickatell',
        'sms/sms_msg91',
        'sms/sms_twilio',
    ];

    $gateways = hooks()->apply_filters('sms_gateways', $gateways);

    foreach ($gateways as $gateway) {
        $CI->load->library($gateway);
    }
}

function is_sms_trigger_active($trigger = '')
{
    $CI     = &get_instance();
    $active = $CI->app_sms->get_active_gateway();

    if (!$active) {
        return false;
    }

    return $CI->app_sms->is_trigger_active($trigger);
}

function can_send_sms_based_on_creation_date($data_date_created)
{
    $now       = time();
    $your_date = strtotime($data_date_created);
    $datediff  = $now - $your_date;

    $days_diff = floor($datediff / (60 * 60 * 24));

    return $days_diff < DO_NOT_SEND_SMS_ON_DATA_OLDER_THEN || $days_diff == DO_NOT_SEND_SMS_ON_DATA_OLDER_THEN;
}


if (!function_exists('send_whatsapp_message')) {

    function send_whatsapp_message($to, $message)
    {
        // Get your Account SID and Auth Token from the environment variables
        $sid = "AC2b909efae40dc33154d9d2683811fb51";
        $token = "c54b12085ed96809b79e99ef6359e120";
        $from = 'whatsapp:+447460985490'; // Sender's WhatsApp number

        $contentSid = 'HX862a4d239d3cca9ec13e905cc5532ffc'; // Replace with your content SID
        $messagingServiceSid = 'MGa230b96deb08fedb8bb5011eec91ad94'; // Replace with your messaging service SID

        $client = new Client($sid, $token);

        try {
            if (is_array($to)) {
                foreach ($to as $recipient) {
                    $client->messages->create(
                        'whatsapp:' . $recipient,
                        [
                            'from' => $from,
                            'body' => $message,
                            'contentSid' => $contentSid,
                            //'contentVariables' => json_encode(["1" => "Name"]), // Replace with your variables
                            'messagingServiceSid' => $messagingServiceSid
                        ]
                    );
                }
            } else {
                $client->messages->create(
                    'whatsapp:' . $to,
                    [
                        'from' => $from,
                        'body' => $message,
                        'contentSid' => $contentSid,
                        //'contentVariables' => json_encode(["1" => "Name"]), // Replace with your variables
                        'messagingServiceSid' => $messagingServiceSid
                    ]
                );
            }
            return true;
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return false;
        }
    }
}


if (!function_exists('send_whatsapp_task_message')) {
    function send_whatsapp_task_messages($to, $des)
    {
        // Get your Account SID and Auth Token from the environment variables
        $sid = "AC2b909efae40dc33154d9d2683811fb51";
        $token = "c54b12085ed96809b79e99ef6359e120";
        $from = 'whatsapp:+447460985490'; // Sender's WhatsApp number

        $contentSid = 'HXe060db91738cb6f0d1d74eaab001c246'; // Replace with your content SID
        $messagingServiceSid = 'MGa230b96deb08fedb8bb5011eec91ad94'; // Replace with your messaging service SID

        $client = new Client($sid, $token);

        try {
            if (is_array($to)) {
                // $date = date('Y-m-d H:i:s');
                foreach ($to as $recipient) {
                    $client->messages->create(
                        'whatsapp:' . $recipient,
                        [
                            'from' => $from,
                            'body' => '',
                            'contentSid' => $contentSid,
                            'contentVariables' => json_encode(["1" => $des]),
                            'messagingServiceSid' => $messagingServiceSid
                        ]
                    );
                }
            } else {
                $client->messages->create(
                    'whatsapp:' . $to,
                    [
                        'from' => $from,
                        'body' => '',
                        'contentSid' => $contentSid,
                        'contentVariables' => json_encode(["1" => $des]),
                        'messagingServiceSid' => $messagingServiceSid
                    ]
                );
            }
            return true;
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return false;
        }
    }

    function send_whatsapp_lead_message($to, $des)
    {
        // Get your Account SID and Auth Token from the environment variables
        $sid = "AC2b909efae40dc33154d9d2683811fb51";
        $token = "c54b12085ed96809b79e99ef6359e120";
        $from = 'whatsapp:+447460985490'; // Sender's WhatsApp number

        $contentSid = 'HX2901ee2fd4d5a0fbdbfc18e9057b3cc7'; // Replace with your content SID
        $messagingServiceSid = 'MGa230b96deb08fedb8bb5011eec91ad94'; // Replace with your messaging service SID

        $client = new Client($sid, $token);

        try {
            $client->messages->create(
                'whatsapp:' . $to,
                [
                    'from' => $from,
                    'body' => $des,
                    'contentSid' => $contentSid,
                    'contentVariables' => json_encode(["1" => $des]),
                    'messagingServiceSid' => $messagingServiceSid
                ]
            );
            return true;
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return false;
        }
    }
}

if (!function_exists('send_sms_task_message')) {
    function send_sms_task_messages($to, $des)
    {
        // Get your Account SID and Auth Token from the environment variables
        $sid = "AC2b909efae40dc33154d9d2683811fb51";
        $token = "c54b12085ed96809b79e99ef6359e120";
        $from = '+447460985490'; // Sender's SMS number (Twilio number)

        $contentSid = 'HXe060db91738cb6f0d1d74eaab001c246'; // Replace with your content SID
        $messagingServiceSid = 'MGa230b96deb08fedb8bb5011eec91ad94'; // Replace with your messaging service SID

        $client = new Client($sid, $token);

        try {
            if (is_array($to)) {
                foreach ($to as $recipient) {
                    // Check if the number is UK-based (UK country code is +44)
                    if (preg_match('/^\+44\d{10,14}$/', $recipient)) {
                        $client->messages->create(
                            $recipient,
                            [
                                'from' => $from,
                                'body' => '',
                                'contentSid' => $contentSid,
                                'contentVariables' => json_encode([
                                    "1" => $des,
                                ]), // Replace with your variables
                                'messagingServiceSid' => $messagingServiceSid
                            ]
                        );
                    }
                }
            }
            return true;
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return false;
        }
    }


    function send_sms_lead_message($to, $des)
    {
        // Get your Account SID and Auth Token from the environment variables
        $sid = "AC2b909efae40dc33154d9d2683811fb51";
        $token = "c54b12085ed96809b79e99ef6359e120";
        $from = '+447460985490'; // Sender's SMS number (Twilio number)

        $contentSid = 'HX2901ee2fd4d5a0fbdbfc18e9057b3cc7'; // Replace with your content SID
        $messagingServiceSid = 'MGa230b96deb08fedb8bb5011eec91ad94'; // Replace with your messaging service SID

        $client = new Client($sid, $token);

        try {
            // Check if the number is UK-based (UK country code is +44)
            if (preg_match('/^\+44\d{10,14}$/', $to)) {
                $client->messages->create(
                    $to,
                    [
                        'from' => $from,
                        'body' => '',
                        'contentSid' => $contentSid,
                        'contentVariables' => json_encode([
                            "1" => $des,
                        ]), // Replace with your variables
                        'messagingServiceSid' => $messagingServiceSid
                    ]
                );
            } else {
                throw new Exception("Invalid UK number format");
            }
            return true;
        } catch (Exception $e) {
            log_message('error', $e->getMessage());
            return false;
        }
    }
}
