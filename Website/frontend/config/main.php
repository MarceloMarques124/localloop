<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'api' => [
            'class' => 'frontend\modules\api\ModuleApi',
        ],
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]

        ],

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\FileTarget::class,
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/advertisement', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/cart', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/cart-item', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/invoice', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/item', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/report', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/saved-advertisement', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/trade', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/trade-proposal', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/trade-proposal-item', 'tokens' => ['{id}' => '<id:\\d+>']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'api/user', 'tokens' => ['{id}' => '<id:\\d+>']],
            ],
        ],
    ],
    'params' => $params,
];
