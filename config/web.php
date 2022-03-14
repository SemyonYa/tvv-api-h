<?php

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'components' => [
        'request' => [
            'cookieValidationKey' => '1zE07_Zk0G61of3xhf2ob625AqxaQu1b',
            'baseUrl' => '',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                $response = $event->sender;
                if ($response->statusCode >= 400) {
                    $response->data = [
                        'status' => $response->data->status ?? $response->statusCode,
                        'message' => $response->data['message'] ?? 'Что-то не то',
                        'errors' => $response->statusCode === 422 ? $response->data : [],
                    ];
                    // $response->statusCode = 200;

                    // if ($response->statusCode === 422) {
                    //     $response->data['errors'] = [
                    //         'qwe' => 'ert',
                    //         'erty' => 'adf'
                    //     ];
                    // }
                }
                // if ($response->data !== null) {
                //     $response->data = [
                //         'success' => $response->isSuccessful,
                //         'data' => $response->data,
                //         'q' => $response->statusCode,
                //         // 'mes' => $response->message
                //     ];
                //     $response->statusCode = 200;
                // }
            },
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
            'enableSession' => false,
            'loginUrl' => null,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        // 'mailer' => [
        //     'class' => 'yii\swiftmailer\Mailer',
        //     'useFileTransport' => true,
        // ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['item', 'region', 'place'],
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['product'],
                    'extraPatterns' => [
                        // 'GET <id>/images' => 'images',
                        'PUT <id>/images' => 'update-image-set',
                        'OPTIONS <id>/images' => 'options',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['data'],
                    'pluralize' => false,
                    'extraPatterns' => [
                        'regions' => 'regions',
                        'regions/<regionId>' => 'region',
                        'places' => 'places',
                        'places/<placeId>' => 'place',
                        'projects' => 'projects',
                        'projects/<projectId>' => 'project',
                        'project-types' => 'project-types',
                        // 'OPTIONS landing' => 'options',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => 'image',
                    'extraPatterns' => [
                        'GET for-product/<product_id>' => 'for-product',
                        'OPTIONS for-product/<product_id>' => 'options',
                        'PUT set-deleted' => 'set-deleted',
                        'OPTIONS <action>' => 'options',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['public-data'],
                    'pluralize' => false,
                    'patterns' => [
                        'GET items' => 'landing',
                        'HEAD items' => 'head',
                        'OPTIONS items' => 'options',
                        'OPTIONS <action>' => 'options',
                        'HEAD <action>' => 'head',
                        // 'GET about' => 'about',
                        // 'GET personal' => 'personal',
                        // 'GET positions' => 'positions',
                        // 'GET galery' => 'galery',
                        // 'GET services/<region>' => 'services',
                        // 'GET programs' => 'programs',
                        // 'GET articles' => 'articles',
                        // 'GET article/<id>' => 'article',
                        // 'HEAD <action>' => 'head',
                        // 'OPTIONS <action>' => 'options',
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['user'],
                    'extraPatterns' => [
                        'GET profile' => 'view-profile',
                        'OPTIONS profile' => 'options',
                        'PUT profile' => 'update-profile'
                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => ['auth'],
                    'pluralize' => false,
                    // 'patterns' => [
                    //     'POST' => 'create',
                    //     'DELETE' => 'logout'
                    // ]
                ],
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
