<?php
 use kartik\mpdf\Pdf;
$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
    'reportico' => [
            'class' => 'reportico\reportico\Module' ,
            'controllerMap' => [
                            'reportico' => 'reportico\reportico\controllers\ReporticoController',
                            'mode' => 'reportico\reportico\controllers\ModeController',
                            'ajax' => 'reportico\reportico\controllers\AjaxController',
                        ]
            ],
            ],
    'components' => [

    'pdf' => [
        'class' => Pdf::classname(),
        'format' => Pdf::FORMAT_A4,
        'orientation' => Pdf::ORIENT_PORTRAIT,
        'destination' => Pdf::DEST_BROWSER,
        // refer settings section for all configuration options
    ],
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
            'useFileTransport' => false,
            'transport'=>[
                'class'=>'Swift_SmtpTransport',
                'host'=>'smtp.zoho.com',
                'username'=>'support@pro-z.in',
                'password'=>'8122399081',
                'port'=>'587',
                'encryption'=>'tls',
            ],
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
                'site/pdf' => 'site/pdf',                   
                'category-list/upload-category-list' => 'category-list/upload-category-list',
                'category-list/update-category-list/<category_ID:\w+>' => 'category-list/update-category-list',
                'category-list/delete-category-list/<category_ID:\w+>' => 'category-list/delete-category-list',
                'category-list/sync'=>'category-list/sync',
                //product list url
                'product-list/upload-product-list' => 'product-list/upload-product-list',
                'product-list/update-product-list/<product_ID:\w+>' =>'product-list/update-product-list',
                'product-list/delete-product-list/<product_ID:\w+>' =>'product-list/delete-product-list',
                'product-list/sync'=>'product-list/sync',
                //customer-list url
                'customer-list/upload-customer-list' =>'customer-list/upload-customer-list',
                'customer-list/update-customer-list/<cust_ID:\w+>' =>'customer-list/update-customer-list',
                'customer-list/delete-customer-list/<cust_ID:\w+>' =>'customer-list/delete-customer-list',
                'customer-list/sync'=>'customer-list/sync',

                //sales-ref url
                'sales-ref/upload-sales-ref' =>'sales-ref/upload-sales-ref',
                'sales-ref/update-sales-ref/<salesRefID:\w+>' =>'sales-ref/update-sales-ref',
                'sales-ref/delete-sales-ref/<salesRefID:\w+>' =>'sales-ref/delete-sales-ref',
                'sales-ref/send-mail' =>'sales-ref/send-mail',
                'sales-ref/sync' =>'sales-ref/sync',
                'setting/update-setting'=>'setting/update-setting',
                
            ],
        ],
      
    ],
    'params' => $params,
];

if (YII_ENV_TEST) {
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
