<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'payments' => array(
        'Webmoney' => array(
            'secretKey' => '',
            'mode' => '0', // 1 - test mode
            'wmz' => '',
            'description'=>'NetGeron Payment',
        ),
    ),
    'mailchimp' => array(
        'apikey' => '',
        'store_id' => 'mh_store_1',
        'list_id' => '0baf1f4673',
    ),
];
