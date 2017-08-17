<?php
return [
    'adminEmail' => 'admin@example.com',
    'supportEmail' => 'support@example.com',
    'user.passwordResetTokenExpire' => 3600,
    'payments' => array(
        'PayPal' => array(
           /*
            'mode' => 'sandbox',
            'clientId' => 'AbjdQBCDnJxsE94Qko2ciML3Fo9bqnW6giJAOVkmSYiDiwJ5ZnMlcPFBJmO8',
            'clientSecret' => 'EADJ3BD9_D9720xCSSA-Yu-7Y-t146G94KO8J23rt03sXSpldw0vOZrF7dMk',
            */

            'mode' => 'live',
            'clientId' => 'AUqCakBl9qylOeMpDuiOQXG4-wTvgAcY0LJY_HdLt0-8zG5BQmFiY-Me_9zqmof7zgb1vIUwyQlg2Gnz',
            'clientSecret' => 'EPAdQok4KSzEQuQZnwqjNFs-VzchgO5exs3jaQNPO4U4TAkQkyAVwCeH3Eav5t8UeMw2QzyGCbecZJtt',                    
            'currency' => 'USD',
            'description'=>'NetGeron Payment',
            //'test_buyer' => 'mailmuchenik-buyer@gmail.com' pwd: mailmuchenik-buyer
        ),
        'Webmoney' => array(
            //https://merchant.webmoney.ru/conf/guide.asp#properties
            /*
            'secretKey' => 'SK409fj29fdj2d09dlkj030213jfdvkljfs094839',
            'mode' => '1', // 1 - test mode
            'wmz' => 'Z110034523225',
             * 
             */
            'secretKey' => 'H735h4H8ejDe9%VDRRYHYsERf57gRET',
            'mode' => '0', // 1 - test mode
            'wmz' => 'Z346340674657',
            'description'=>'MarcketingHack Payment',
        ),
        'TwocheckoutPayment' => array(
            //https://www.2checkout.com/documentation/checkout/parameters/
            'SecretWord' => 'tango',
            'sid' => '901265259', //seller id
            'sandbox' => true,

            //4000000000000002 sandbox: netger, pwd: usual + 1
        ),
        'Bitcoin' => array(
            'xpub' => 'xpub6C32LWtGrPom2dAQa4PWyFs9pQ5hxihHDTCN9kgGmfBWmzUnvuC2q9cCFF6tLRSiEMzKf5Hj9z5y1UR3bCvTSD8kyrp9XvZGfFrFncPBS3B',
            'key'  => 'a3245363-9f00-424f-b1f6-f98116b50280',
        ),
    ),
];
