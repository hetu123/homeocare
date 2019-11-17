<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            // uncomment if you want to cache RBAC items hierarchy
            // 'cache' => 'cache',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'fcm' => [
            'class' => 'understeam\fcm\Client',
            'apiKey' => 'AAAAaWIafS0:APA91bEEWmBRRMeAYwyQtkJZ03XP2ElvSM6WRsppzSEapnxmz3CGVp6dgggLIPQkNZiNowW3gChrJ6cp7MYSOWPA3viC3y8JOyu9xvj8TpuXv9ItoBcdKT_E-X-gVlnNFgX9rhzRRWO9', // Server API Key (you can get it here: https://firebase.google.com/docs/server/setup#prerequisites)
        ],
        'Yii2Twilio' => array(
            'class' => 'Twilio\Rest\Client',

            'account_sid' => 'AC5a1d92568045eb99a6bcc1f64c0c902c', //replace with your sid
            'auth_key' => 'b06e29d87e2dbc293d73515e37944cd9', //replace with your token
        ),
    ],
    'modules' => [
        'redactor' => [
           // 'redactor' => 'yii\redactor\RedactorModule',
            'class' => 'yii\redactor\RedactorModule',
            'uploadDir' => '@img/blogs',
            'uploadUrl' => '/uploads/blogs',
            'imageAllowExtensions'=>['jpg','png','gif','jpeg']
        ],
        'auth' => [
            'class' => 'common\modules\auth\module',
        ],
    ],
];
