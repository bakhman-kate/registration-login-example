<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'name' => 'test-task_sportmenu',
    'language' => 'ru-RU',
    'basePath' => dirname(__DIR__),
    'homeUrl' => '/',
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            'cookieValidationKey' => '3N3yC_SNgfsJ8RBPXlflxcnkL6eZxPA3',            
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
            //'enableSession' => false            
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',            
            'useFileTransport' => false,
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
        'db' => require(__DIR__ . '/db.php'),
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [                
                [
                    'pattern' => '<action:(about|contact|login|logout|cabinet)>',
                    'route' => 'site/<action>',                    
                ]                
            ],
        ],  
        'session' => [
            'savePath' => 'C:/xampp/htdocs/fitbartv/runtime/session'
        ],
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',        
    ];
}

return $config;
