<?php
return [
    'adminEmail' => 'info@marketinghack.net',
    'supportEmail' => 'support@marketinghack.net',
    'user.passwordResetTokenExpire' => 3600,
    'payments' => array(
        'Webmoney' => array(
            'secretKey' => '',
            'mode' => '0', // 1 - test mode
            'wmz' => '',
            'description'=>'MArketingHack Payment',
        ),
        //generate sertificate file
        //add webhook link
        'FastSpring' => array(
            'secretKey' => '',
            'mode' => '0', // 1 - test mode
            'key_private_path' => '',
            'description' => 'MarketingHack Payment',
        ),
    ),
    'mailchimp' => array(
        'apikey' => '',
        'store_id' => 'mh_store_1',
        'list_id' => '0baf1f4673',
    ),
];
