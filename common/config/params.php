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
            'TEST_MODE' => 1, 
            'DEBUG' => 1, //Payment side console debug
            'PRIVATE_KEY_PATH' => '', //generates in payment controll panel
            'ACCESS_KEY' => '', //generates in payment controll panel
            'description' => '',
            'API_NAAME' => '',
            'API_PASSWORD' => '',
        ),
    ),
    'mailchimp' => array(
        'apikey' => '',
        'store_id' => 'mh_store_1',
        'list_id' => '0baf1f4673',
    ),
];
