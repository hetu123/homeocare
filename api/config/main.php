<?php

$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [

    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'name'=>'Homeocare',
    'modules' => [
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'api\modules\v1\Module'
        ]
    ],


    'components' => [

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],



        'urlManager' =>
        [
            'enablePrettyUrl' => true,
           // 'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' =>
             [
                'v1/<controller:\w+>/<action:\w+>'     => 'v1/<controller>/<action>',
               'v1/<controller:\w+>/<action:\w+>/<function:\w+>'=>'v1/<controller>/<action>'
            ], 
                    
        ]
    ],
    //'regio_code'=>'QA',
    'params' => $params,
];