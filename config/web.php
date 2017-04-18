<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'ozKJpNob13JRSCK0PLGTE4F7GApirzza',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
                //category list url                    
                'category-list/upload-category-list' => 'category-list/upload-category-list',
                'category-list/update-category-list/<category_ID:\w+>' => 'category-list/update-category-list',
                'category-list/delete-category-list/<category_ID:\w+>' => 'category-list/delete-category-list',
                //product list url
                'product-list/upload-product-list' => 'product-list/upload-product-list',
                'product-list/update-product-list/<product_ID:\w+>' =>'product-list/update-product-list',
                'product-list/delete-product-list/<product_ID:\w+>' =>'product-list/delete-product-list',
                //customer-list url
                'customer-list/upload-customer-list' =>'customer-list/upload-customer-list',
                'customer-list/update-customer-list/<cust_ID:\w+>' =>'customer-list/update-customer-list',
                'customer-list/delete-customer-list/<cust_ID:\w+>' =>'customer-list/delete-customer-list',
                
            ],
        ],
      
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
